import cv2
import requests
import threading
import time
import queue
from PIL import Image, ImageDraw, ImageFont
import numpy as np
import pathlib
import subprocess

def FileRead(fpath):
    file = open(fpath, mode='r')
    content = file.read()
    file.close()
    return content

cpath = str(pathlib.Path(__file__).parent.resolve()) + "\\"
#cpath = subprocess.getoutput("cd") + "\\"

config_file = cpath + 'config.json'
config = eval(FileRead(config_file))

# Очередь для передачи данных между потоками
response_queue = queue.Queue()
waiting_for_frame = False

# Функция для рисования текста с использованием Pillow
def draw_text(image, text, position, font_size=30, color=(255, 255, 255)):
    pil_image = Image.fromarray(cv2.cvtColor(image, cv2.COLOR_BGR2RGB))  # конвертируем OpenCV изображение в формат PIL
    draw = ImageDraw.Draw(pil_image)

    # Выбираем шрифт (убедитесь, что путь к шрифту правильный)
    font = ImageFont.truetype("arial.ttf", font_size)  # Можно заменить на другой шрифт, поддерживающий кириллицу

    # Рисуем текст
    draw.text(position, text, font=font, fill=color)

    # Преобразуем обратно в формат OpenCV
    return cv2.cvtColor(np.array(pil_image), cv2.COLOR_RGB2BGR)

def send_frame_to_server(frame):
    global waiting_for_frame
    global config
    try:
        # Сжимаем изображение
        _, jpeg = cv2.imencode('.jpg', frame)
        
        # Отправляем запрос на сервер
        response = requests.post(
            config['recognition_url'],
            files={'image': ('frame.jpg', jpeg.tobytes(), 'image/jpeg')}
        )

        waiting_for_frame = False
        
        if response.ok:
            # Отправляем данные обратно в очередь
            response_queue.put(response.json())
    except Exception as e:
        print("Ошибка при отправке запроса:", e)

# Главная функция обработки видео
def process_video():
    global waiting_for_frame
    video_capture = cv2.VideoCapture(0)
    frame_count = 0
    last_response = []

    while True:
        ret, frame = video_capture.read()
        if not ret:
            continue

        frame_count += 1

        # Каждые 5 кадров — отправляем на сервер
        if not waiting_for_frame:
            waiting_for_frame = True
            # Создаем отдельный поток для отправки запроса на сервер
            threading.Thread(target=send_frame_to_server, args=(frame,)).start()

        # Проверяем очередь на наличие нового ответа
        if not response_queue.empty():
            last_response = response_queue.get()

        # Отображаем результаты
        for item in last_response:
            name = item['name']
            top, right, bottom, left = item['location']
            cv2.rectangle(frame, (left, top), (right, bottom), (0, 255, 0), 2)
            # Используем функцию из Pillow для отображения текста с кириллицей
            frame = draw_text(frame, name, (left, top - 30), font_size=25, color=(255, 255, 255))

        # Отображаем изображение
        cv2.imshow("Face Recognition", frame)

        if cv2.waitKey(1) & 0xFF == ord('q'):
            break

    video_capture.release()
    cv2.destroyAllWindows()

# Запускаем обработку видео
if __name__ == "__main__":
    process_video()
