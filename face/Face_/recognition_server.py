from flask import Flask, request, jsonify
import face_recognition
import numpy as np
import cv2
import pathlib
import subprocess
import os
import mysql.connector
from datetime import datetime, timedelta

def FileRead(fpath):
    file = open(fpath, mode='r')
    content = file.read()
    file.close()
    return content

cpath = str(pathlib.Path(__file__).parent.resolve()) + "\\"
#cpath = subprocess.getoutput("cd") + "\\"

config_file = cpath + 'config.json'
config = eval(FileRead(config_file))

app = Flask(__name__)

# Подключение к MySQL
db = mysql.connector.connect(
    host=config['db_host'],
    user=config['db_user'],
    password=config['db_password'],
    database=config['db_database']
)
cursor = db.cursor()

# Загружаем известные лица
known_face_encodings = []
known_face_ids = []

pictures_path = cpath + 'database\\pictures'
for filename in os.listdir(pictures_path):
    if filename.endswith(('.jpg', '.jpeg', '.png')):
        img = face_recognition.load_image_file(os.path.join(pictures_path, filename))
        enc = face_recognition.face_encodings(img)
        if enc:
            known_face_encodings.append(enc[0])
            known_face_ids.append(os.path.splitext(filename)[0])  # Используется как id

@app.route('/recognize', methods=['POST'])
def recognize():
    print("Handling recognition request")
    if 'image' not in request.files:
        return jsonify({"error": "No image uploaded"}), 400

    file = request.files['image']
    file_bytes = np.frombuffer(file.read(), np.uint8)
    img = cv2.imdecode(file_bytes, cv2.IMREAD_COLOR)
    rgb = cv2.cvtColor(img, cv2.COLOR_BGR2RGB)

    face_locations = face_recognition.face_locations(rgb)
    face_encodings = face_recognition.face_encodings(rgb, face_locations)

    results = []
    now = datetime.now()
    one_minute_ago = now - timedelta(minutes=1)

    for encoding, loc in zip(face_encodings, face_locations):
        name = "Unknown"
        user_id = 0
        face_distances = face_recognition.face_distance(known_face_encodings, encoding)

        if len(face_distances) > 0:
            best_match = np.argmin(face_distances)
            if face_distances[best_match] < 0.6:
                name = known_face_ids[best_match]
                user_id = int(name)  # имя файла — это id пользователя

        # Проверяем, была ли запись в течение последней минуты
        cursor.execute("""
            SELECT COUNT(*) FROM visits 
            WHERE user_id = %s AND visit = 'visited' AND time > %s
        """, (user_id, one_minute_ago))
        (count,) = cursor.fetchone()
        if count == 0:
            cursor.execute("""
                INSERT INTO visits (user_id, visit, time)
                VALUES (%s, 'visited', %s)
            """, (user_id, now))
            db.commit()

        results.append({
            "name": name,
            "location": [int(x) for x in loc]
        })

    return jsonify(results)

if __name__ == '__main__':
    app.run(host='127.0.0.1', port=5500)
