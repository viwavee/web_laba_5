<?php
session_start();
require_once 'db.php';
require_once 'LibraryRequest.php';

$username = trim($_POST['username'] ?? '');
$ticket = $_POST['ticket'] ?? '';
$genre = $_POST['genre'] ?? '';
$period = $_POST['period'] ?? '';
$ebook = isset($_POST['ebook']) ? 1 : 0;

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

$request = new LibraryRequest($pdo);
$request->add($username, $ticket, $genre, $ebook, $period);

$_SESSION['username'] = htmlspecialchars($username);
$_SESSION['ticket'] = htmlspecialchars($ticket);
$_SESSION['genre'] = htmlspecialchars($genre);
$_SESSION['ebook'] = $ebook ? 'yes' : 'no';
$_SESSION['period'] = htmlspecialchars($period);

setcookie("last_submission", date('Y-m-d H:i:s'), time() + 3600, "/");

header("Location: index.php");
exit();
