<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Главная страница библиотеки</title>
    <style>
        body {
            font-family: "Segoe UI", Roboto, Arial, sans-serif;
            background: #f3f6fb;
            margin: 0;
            padding: 40px;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #1e40af;
            margin-bottom: 20px;
        }

        h3 {
            margin-top: 40px;
            color: #1e3a8a;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            padding: 30px 40px;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            background: #f9fafc;
            margin-bottom: 10px;
            padding: 12px 15px;
            border-radius: 8px;
            border-left: 4px solid #1e40af;
        }

        a {
            color: #1e40af;
            text-decoration: none;
            font-weight: 600;
        }

        a:hover {
            text-decoration: underline;
        }

        .links {
            margin-top: 15px;
            text-align: center;
        }

        .error-list {
            background: #fee2e2;
            color: #991b1b;
            border-radius: 8px;
            padding: 10px 15px;
            margin-bottom: 20px;
        }

        .book-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .book {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .book:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.1);
        }

        .book img {
            width: 100%;
            height: 280px;
            object-fit: cover;
            border-bottom: 1px solid #e5e7eb;
        }

        .book-info {
            padding: 12px 15px;
        }

        .book-info strong {
            color: #1d4ed8;
            display: block;
            margin-bottom: 5px;
            font-size: 1.05em;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            color: #6b7280;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📚 Главная страница библиотеки</h1>

        <?php if (isset($_SESSION['errors'])): ?>
            <div class="error-list">
                <ul>
                    <?php foreach ($_SESSION['errors'] as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php unset($_SESSION['errors']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['username'])): ?>
            <h3>🧾 Данные из сессии (последняя заявка):</h3>
            <ul>
                <li><strong>Имя:</strong> <?= htmlspecialchars($_SESSION['username']) ?></li>
                <li><strong>Номер билета:</strong> <?= htmlspecialchars($_SESSION['ticket']) ?></li>
                <li><strong>Жанр:</strong> <?= htmlspecialchars($_SESSION['genre']) ?></li>
                <li><strong>Электронная версия:</strong> <?= $_SESSION['ebook'] === 'yes' ? 'Да' : 'Нет' ?></li>
                <li><strong>Срок аренды:</strong> <?= htmlspecialchars($_SESSION['period']) ?></li>
            </ul>
        <?php else: ?>
            <p style="text-align:center; color:#6b7280;">Данных пока нет. Заполните форму, чтобы начать.</p>
        <?php endif; ?>

        <div class="links">
            <a href="form.html">📝 Заполнить форму</a> |
            <a href="view.php">📂 Посмотреть все данные</a>
        </div>

        <?php
        // ====== ДАННЫЕ ИЗ API ======
        if (isset($_SESSION['api_data'])) {
            echo "<h3>📖 Данные из OpenLibrary API (книги Толстого):</h3>";

            $books = $_SESSION['api_data']['docs'] ?? [];
            $books = array_slice($books, 0, 6);

            if (!empty($books)) {
                echo "<div class='book-grid'>";
                foreach ($books as $book) {
                    $title = htmlspecialchars($book['title'] ?? 'Без названия');
                    $year = htmlspecialchars($book['first_publish_year'] ?? '—');
                    $authors = isset($book['author_name']) ? implode(', ', $book['author_name']) : 'Неизвестен';
                    $lang = isset($book['language']) ? implode(', ', $book['language']) : '—';
                    $coverId = $book['cover_i'] ?? null;
                    $coverUrl = $coverId
                        ? "https://covers.openlibrary.org/b/id/{$coverId}-L.jpg"
                        : "https://via.placeholder.com/200x280?text=Нет+обложки";

                    echo "
                    <div class='book'>
                        <img src='{$coverUrl}' alt='Обложка'>
                        <div class='book-info'>
                            <strong>{$title}</strong>
                            <div>Автор(ы): {$authors}</div>
                            <div>Год: {$year}</div>
                            <div>Языки: {$lang}</div>
                        </div>
                    </div>";
                }
                echo "</div>";
            } else {
                echo "<p>Нет данных от API.</p>";
            }
        }

        // ====== ИНФОРМАЦИЯ О ПОЛЬЗОВАТЕЛЕ ======
        if (isset($_SESSION['user_info'])) {
            echo "<h3>👤 Информация о пользователе:</h3>";
            echo "<ul>";
            foreach ($_SESSION['user_info'] as $key => $val) {
                echo "<li><strong>" . htmlspecialchars($key) . ":</strong> " . htmlspecialchars($val) . "</li>";
            }
            echo "</ul>";
        }

        // ====== COOKIE ======
        if (isset($_COOKIE['last_submission'])) {
            echo "<p><strong>🕓 Последняя заявка отправлена:</strong> " . htmlspecialchars($_COOKIE['last_submission']) . "</p>";
        }
        ?>
    </div>

    <div class="footer">
        © <?= date('Y') ?> Электронная библиотека • Все права защищены
    </div>
</body>
</html>
