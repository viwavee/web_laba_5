<?php
session_start();

$username = trim($_POST['username'] ?? '');
$ticket = $_POST['ticket'] ?? '';
$genre = $_POST['genre'] ?? '';
$period = $_POST['period'] ?? '';
$ebook = isset($_POST['ebook']) ? 'yes' : 'no';

$errors = [];
if (empty($username)) $errors[] = "Имя не может быть пустым";
if (empty($ticket) || !is_numeric($ticket) || $ticket <= 0) $errors[] = "Номер билета должен быть положительным числом";
if (empty($genre)) $errors[] = "Выберите жанр";
if (empty($period)) $errors[] = "Выберите срок аренды";

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header("Location: index.php");
    exit();
}

// Очистка для безопасности
$username = htmlspecialchars($username);
$ticket = htmlspecialchars($ticket);
$genre = htmlspecialchars($genre);
$period = htmlspecialchars($period);
// $ebook уже безопасен

$_SESSION['username'] = $username;
$_SESSION['ticket'] = $ticket;
$_SESSION['genre'] = $genre;
$_SESSION['ebook'] = $ebook;
$_SESSION['period'] = $period;

$line = $username . ";" . $ticket . ";" . $genre . ";" . $ebook . ";" . $period . "\n";
file_put_contents("data.txt", $line, FILE_APPEND | LOCK_EX);

header("Location: index.php");
exit();
?>