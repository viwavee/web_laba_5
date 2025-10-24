<?php
session_start();
require_once 'ApiClient.php';
require_once 'UserInfo.php';

// === API и кеш ===
$api = new ApiClient();
$url = 'https://openlibrary.org/search.json?q=tolstoy';

$cacheFile = 'api_cache.json';
$cacheTtl = 300; // 5 минут

if (file_exists($cacheFile) && time() - filemtime($cacheFile) < $cacheTtl) {
    $apiData = json_decode(file_get_contents($cacheFile), true);
} else {
    $apiData = $api->request($url);
    if (!isset($apiData['error'])) {
        file_put_contents($cacheFile, json_encode($apiData, JSON_UNESCAPED_UNICODE));
    }
}
$_SESSION['api_data'] = $apiData;
$_SESSION['user_info'] = UserInfo::getInfo();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Главная</title>
    <style>
        body {
            font-family: "Segoe UI", Roboto, Arial, sans-serif;
            margin: 40px;
            background: linear-gradient(135deg, #eef2ff, #ffffff);
        }
        h1, h3 { color: #1e3a8a; }
        .book {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            padding: 15px;
            margin: 10px 0;
            overflow: hidden;
        }
        .book img {
            float: left;
            margin-right: 10px;
            border-radius: 6px;
        }
        button {
            background: #1e40af;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            margin-bottom: 20px;
        }
        button:hover {
            background: #2563eb;
        }
        .error {
            color: red;
            background: #fee2e2;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h1>Главная страница библиотеки</h1>

    <?php if (isset($_SESSION['username'])): ?>
        <h3>Данные из сессии (последняя заявка):</h3>
        <ul>
            <li><strong>Имя:</strong> <?= $_SESSION['username'] ?></li>
            <li><strong>Номер билета:</strong> <?= $_SESSION['ticket'] ?></li>
            <li><strong>Жанр:</strong> <?= $_SESSION['genre'] ?></li>
            <li><strong>Электронная версия:</strong> <?= $_SESSION['ebook'] === 'yes' ? 'да' : 'нет' ?></li>
            <li><strong>Срок аренды:</strong> <?= $_SESSION['period'] ?></li>
        </ul>
    <?php else: ?>
        <p>Данных пока нет. Заполните форму!</p>
    <?php endif; ?>

    <p>
        <a href="form.html">Заполнить форму</a> |
        <a href="view.php">Посмотреть все данные</a>
    </p>

    <h3>Данные из OpenLibrary API (книги Толстого):</h3>
    <button id="refreshBtn">🔄 Обновить данные</button>
    <div id="apiResult">
        <?php
        if (isset($apiData['error'])) {
            echo "<div class='error'>Ошибка при подключении к API: " . htmlspecialchars($apiData['error']) . "</div>";
        } elseif (!empty($apiData['docs'])) {
            foreach (array_slice($apiData['docs'], 0, 5) as $book) {
                $title = htmlspecialchars($book['title'] ?? 'Без названия');
                $year = htmlspecialchars($book['first_publish_year'] ?? '—');
                $authors = isset($book['author_name']) ? implode(', ', $book['author_name']) : 'Неизвестен';
                $coverId = $book['cover_i'] ?? null;
                $coverUrl = $coverId
                    ? "https://covers.openlibrary.org/b/id/{$coverId}-M.jpg"
                    : "https://via.placeholder.com/128x180?text=Нет+обложки";

                echo "
                <div class='book'>
                    <img src='{$coverUrl}' width='80'>
                    <strong>{$title}</strong><br>
                    Автор(ы): {$authors}<br>
                    Год публикации: {$year}
                    <div style='clear:both;'></div>
                </div>";
            }
        } else {
            echo "<p>Нет данных от API.</p>";
        }
        ?>
    </div>

    <h3>Информация о пользователе:</h3>
    <?php foreach ($_SESSION['user_info'] as $k => $v): ?>
        <?= htmlspecialchars($k) ?>: <?= htmlspecialchars($v) ?><br>
    <?php endforeach; ?>

    <?php if (isset($_COOKIE['last_submission'])): ?>
        <p><strong>Последняя заявка отправлена:</strong> <?= htmlspecialchars($_COOKIE['last_submission']) ?></p>
    <?php endif; ?>

    <script>
    document.getElementById('refreshBtn').addEventListener('click', async () => {
        const btn = document.getElementById('refreshBtn');
        btn.disabled = true;
        btn.textContent = "Обновляем...";
        try {
            const res = await fetch('refresh_api.php');
            const data = await res.text();
            document.getElementById('apiResult').innerHTML = data;
        } catch (e) {
            document.getElementById('apiResult').innerHTML =
                "<div class='error'>Ошибка при обновлении данных. Попробуйте позже.</div>";
        }
        btn.disabled = false;
        btn.textContent = "🔄 Обновить данные";
    });
    </script>
</body>
</html>
