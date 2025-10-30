Лабораторная работа №5 – Работа с базой данных MySQL через PHP и Docker



👩‍💻 Автор: Есева Виктория, группа 3МО-2


🎯 Цель работы

Освоить принципы контейнеризации с использованием Docker и Docker Compose.

Настроить работу связки Nginx + PHP + MySQL.

Научиться создавать и подключать базы данных MySQL в контейнерах.

Реализовать веб-приложение с формой заявок и сохранением данных в БД.

Отработать доступ к базе данных как через Adminer, так и из PHP-кода.



🌐 Результат доступен по адресам

Главная страница: http://localhost:8080

Adminer (управление БД): http://localhost:8081


📦 Структура проекта
web_laba_5/
│
├── docker-compose.yml        # Основной файл сборки и настройки контейнеров
├── nginx/
│   └── default.conf          # Конфигурация Nginx (маршрутизация и php-fpm)
│
├── php/
│   └── Dockerfile            # Dockerfile для контейнера с PHP
│
├── src/                      # Исходники приложения
│   ├── index.php             # Главная страница
│   ├── form.html             # Форма добавления заявки
│   ├── process.php           # Обработка формы, сохранение данных
│   ├── view.php              # Таблица всех заявок (с подключением к MySQL)
│   ├── db.php                # Подключение к базе данных (PDO)
│   ├── LibraryRequest.php    # Класс для работы с заявками
│   └── assets/               # (по желанию) стили и изображения
│
└── README.md


🧠 Как запустить проект

1.Открыть папку проекта в терминале
2.Выполнить:

docker-compose up -d


3.Проверить работу:

сайт: http://localhost:8080

adminer: http://localhost:8081

4.В Adminer войти с данными:

System: MySQL
Server: db
User: lab5_user
Password: lab5_pass
Database: lab5_db


📸 Скриншоты работы
1. Таблица заявок в view.php
   <img width="1243" height="591" alt="image" src="https://github.com/user-attachments/assets/89994feb-a7ad-485f-a51e-4c0d8eb1d65c" />


2. Структура базы данных в Adminer
   <img width="1204" height="585" alt="image" src="https://github.com/user-attachments/assets/5e0badc7-0c0b-4765-a835-f990656cf02c" />


