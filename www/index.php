<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Главная</title>
</head>
<body>
    <h1>Главная страница библиотеки</h1>

    <?php if(isset($_SESSION['errors'])): ?>
        <ul style="color: red;">
            <?php foreach($_SESSION['errors'] as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
        <?php unset($_SESSION['errors']); ?>
    <?php endif; ?>

    <?php if(isset($_SESSION['username'])): ?>
        <p>Данные из сессии (последняя заявка):</p>
        <ul>
            <li>Имя: <?= $_SESSION['username'] ?></li>
            <li>Номер билета: <?= $_SESSION['ticket'] ?></li>
            <li>Жанр: <?= $_SESSION['genre'] ?></li>
            <li>Электронная версия: <?= $_SESSION['ebook'] === 'yes' ? 'да' : 'нет' ?></li>
            <li>Срок аренды: <?= $_SESSION['period'] ?></li>
        </ul>
    <?php else: ?>
        <p>Данных пока нет. Заполните форму!</p>
    <?php endif; ?>

    <p><a href="form.html">Заполнить форму</a> | <a href="view.php">Посмотреть все данные</a></p>

    <?php
    if (isset($_SESSION['api_data'])) {
        echo "<h3>Данные из OpenLibrary API:</h3>";
        echo "<pre>" . htmlspecialchars(print_r(array_slice($_SESSION['api_data']['docs'] ?? [], 0, 3), true)) . "</pre>";
    }

    if (isset($_SESSION['user_info'])) {
        echo "<h3>Информация о пользователе:</h3>";
        foreach ($_SESSION['user_info'] as $key => $val) {
            echo htmlspecialchars($key) . ': ' . htmlspecialchars($val) . '<br>';
        }
    }

    if (isset($_COOKIE['last_submission'])) {
        echo "<p><strong>Последняя заявка отправлена:</strong> " . htmlspecialchars($_COOKIE['last_submission']) . "</p>";
    }
    ?>
</body>
</html>
