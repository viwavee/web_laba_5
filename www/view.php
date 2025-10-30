<?php
require_once 'db.php';
require_once 'LibraryRequest.php';

$library = new LibraryRequest($pdo);
$requests = $library->getAll();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Все заявки</title>
</head>
<body>
    <h2>Все сохранённые заявки:</h2>
    <ul>
        <?php if (empty($requests)): ?>
            <li>Данных нет</li>
        <?php else: ?>
            <?php foreach ($requests as $r): ?>
                <li>
                    <?= htmlspecialchars($r['name']) ?> (билет #<?= $r['ticket_number'] ?>),
                    жанр: <?= htmlspecialchars($r['genre']) ?>,
                    электронная: <?= $r['ebook'] ? 'да' : 'нет' ?>,
                    срок: <?= htmlspecialchars($r['period']) ?>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
    <a href="index.php">На главную</a>
</body>
</html>
