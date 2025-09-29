import pandas as pd
import sys
input_file = sys.argv[1]
df = pd.read_csv(input_file)
subjects = df.groupby("subject")["grade_value"].mean()
report = []
report.append(f"Прогноз для ученика: {df['surname'][0]} {df['name'][0]}, класс {df['grade'][0]}{df['class'][0]}")
report.append("")
good, weak = [], []
for subj, grade in subjects.items():
    if grade >= 8:
        good.append(f"{subj} (средний балл: {grade:.1f})")
    elif grade <= 5:
        weak.append(f"{subj} (средний балл: {grade:.1f})")
if good:
    report.append("Хорошие предметы:")
    report += [" - " + g for g in good]
else:
    report.append("Хороших предметов не выявлено.")

if weak:
    report.append("\nСлабые предметы (нужно подтянуть):")
    report += [" - " + w for w in weak]
else:
    report.append("\nСлабых предметов нет.")
visits = df["visit"].dropna()
if not visits.empty:
    attendance = (visits == "visited").mean() * 100
    report.append(f"\nПосещаемость: {attendance:.1f}%")
    if attendance < 60:
        report.append("Риск исключения из-за низкой посещаемости.")
    elif attendance < 80:
        report.append("Нужно чаще посещать уроки.")
    else:
        report.append("Хорошая посещаемость.")
else:
    report.append("\nНет данных о посещаемости.")

print(report)

temp_file = "C:\\OpenServer\\domains\\face\\temp.txt"
ans_file = "C:\\OpenServer\\domains\\face\\ans.txt"
with open(ans_file, 'w', encoding="utf-8") as file:
    file.write("\n".join(report))

print("\n".join(report))
