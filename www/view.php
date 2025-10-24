<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Все данные</title>
</head>
<body>
    <h2>Все сохранённые заявки:</h2>
    <ul>
        <?php
        if (file_exists("data.txt")) {
            $lines = file("data.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            if (empty($lines)) {
                echo "<li>Данных нет</li>";
            } else {
                foreach ($lines as $line) {
                    list($name, $ticket, $genre, $ebook, $period) = explode(";", $line);
                    $ebookText = ($ebook === 'yes') ? 'да' : 'нет';
                    echo "<li>Заявка: $name (билет #$ticket), жанр: $genre, электронная: $ebookText, срок: $period</li>";
                }
            }
        } else {
            echo "<li>Файл данных не существует (нет заявок)</li>";
        }
        ?>
    </ul>
    <a href="index.php">На главную</a>
</body>
</html>