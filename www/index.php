<?php session_start(); ?>

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
</body>
</html>