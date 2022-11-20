PRAGMA foreign_keys=on;

DROP TABLE IF EXISTS appointments;
DROP TABLE IF EXISTS doctors;
DROP TABLE IF EXISTS specializations;
DROP TABLE IF EXISTS procedures;
DROP TABLE IF EXISTS procedure_categories;

CREATE TABLE specializations (
    id INTEGER PRIMARY KEY,
    specialization_name VARCHAR(255) NOT NULL UNIQUE);

CREATE TABLE doctors (
    id INTEGER PRIMARY KEY,
    surname VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    patronymic VARCHAR(255) NOT NULL,
    status VARCHAR(255) NOT NULL CHECK (status = "working" OR status = "dismissed"),
    procedure_percent REAL NOT NULL CHECK (procedure_percent > 0 AND procedure_percent <= 100),
    specialization_id INTEGER NOT NULL,
    FOREIGN KEY (specialization_id) REFERENCES specializations(id));

CREATE TABLE procedure_categories (
    id INTEGER PRIMARY KEY,
    category_name VARCHAR(255) NOT NULL UNIQUE);

CREATE TABLE procedures (
    id INTEGER PRIMARY KEY,
    procedure_name VARCHAR(255) NOT NULL,
    duration TEXT NOT NULL,
    price REAL NOT NULL,
    procedure_category_id INTEGER NOT NULL,
    FOREIGN KEY (procedure_category_id) REFERENCES procedure_categories(id));

CREATE TABLE appointments (
    id INTEGER PRIMARY KEY,
    doctor_id INTEGER NOT NULL,
    procedure_id INTEGER NOT NULL,
    begin_date TEXT NOT NULL,
    status VARACHAR(255) NOT NULL CHECK (status = "assigned" OR status = "done" OR status = "cancelled"),
    FOREIGN KEY (doctor_id) REFERENCES doctors(id),
    FOREIGN KEY (procedure_id) REFERENCES procedures(id));

INSERT INTO specializations (specialization_name) VALUES
("Терапевт"),
("Гигиенист"),
("Хирург"),
("Ортопед"),
("Пародонтолог"),
("Имплантолог"),
("Ортодонт"),
("Детский стоматолог"),
("Челюстно-лицевой хирург"),
("Гнатолог");

INSERT INTO doctors (surname, name, patronymic, status, procedure_percent, specialization_id) VALUES
("Игначук", "Константин", "Викторович", "working", 15, 1),
("Скоробогадько", "Павел", "Петрович", "working", 20, 2),
("Конкордин", "Виталий", "Васильевич", "working", 5, 3),
("Пригожий", "Дмитрий", "Сергеевич", "working", 12, 4),
("Герман", "Григорий", "Михайлович", "working", 18, 5),
("Зеленый", "Александр", "Порфирьевич", "working", 25, 6),
("Залугов", "Алексей", "Рафикович", "working", 16, 7),
("Прохоров", "Андрей", "Денисович", "working", 8, 8),
("Полянская", "Юлия", "Антоновна", "working", 21, 9),
("Москаев", "Владимир", "Данилович", "working", 14, 10),
("Всеволодова", "Анна", "Мирославовна", "working", 19, 1),
("Фейгов", "Руслан", "Владиславович", "working", 15, 1),
("Лукашик", "Владлена", "Ивановна", "working", 15, 1);

INSERT INTO procedure_categories (category_name) VALUES
("Имплантация"),
("Терапевтическая стоматология"),
("Хирургическая стоматология");

INSERT INTO procedures (procedure_name, duration, price, procedure_category_id) VALUES
("Установка импланта", "03:15:00", 25000, 1),
("Протезирование", "01:00:00", 5000, 1),
("Установка виниров", "04:00:00", 15000, 1),
("Лечение кариеса", "00:20:00", 3200, 2),
("Профессиональная гигиена", "00:30:00", 1800, 2),
("Профилактический осмотр", "00:20:00", 1200, 2),
("Удаление зуба мудрости", "01:20:00", 7500, 3),
("Удаление молочного зуба", "00:10:00", 700, 3),
("Удаление зуба", "01:00:00", 2200, 3),
("Пластика уздечки", "00:25:00", 2500, 3);


INSERT INTO appointments (doctor_id, procedure_id, begin_date, status) VALUES
(1, 1, "2022-11-22T08:00:00", "assigned"),
(2, 4, "2022-11-22T08:30:00", "assigned"),
(3, 5, "2022-11-22T09:50:00", "assigned"),
(4, 3, "2022-11-22T10:00:00", "assigned"),
(5, 1, "2022-11-22T11:15:00", "assigned"),
(6, 2, "2022-11-22T12:00:00", "assigned"),
(7, 7, "2022-11-22T13:45:00", "assigned"),
(8, 8, "2022-11-22T14:20:00", "assigned"),
(9, 9, "2022-11-22T15:25:00", "assigned"),
(10, 5, "2022-11-22T16:30:00", "assigned"),
(11, 3, "2022-11-22T17:00:00", "assigned"),
(12, 6, "2022-11-23T09:00:00", "assigned"),
(13, 1, "2022-11-23T09:30:00", "assigned"),
(5, 4, "2022-11-23T10:00:00", "assigned"),
(4, 6, "2022-11-23T11:20:00", "assigned"),
(3, 7, "2022-11-23T11:40:00", "assigned");
