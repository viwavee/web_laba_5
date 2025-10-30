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
  <style>
    body {
      font-family: "Segoe UI", Roboto, Arial, sans-serif;
      background: linear-gradient(135deg, #e3eeff, #ffffff);
      margin: 0;
      padding: 40px;
      min-height: 100vh;
    }

    h1 {
      text-align: center;
      color: #1e3a8a;
      margin-bottom: 30px;
    }

    .container {
      max-width: 800px;
      margin: 0 auto;
    }

    .card {
      background: #fff;
      border-radius: 14px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
      padding: 20px 25px;
      margin-bottom: 20px;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card:hover {
      transform: translateY(-3px);
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12);
    }

    .card strong {
      color: #1e40af;
      font-size: 18px;
    }

    .meta {
      color: #475569;
      margin-top: 5px;
      font-size: 14px;
    }

    .empty {
      text-align: center;
      font-size: 16px;
      color: #64748b;
      background: #f1f5f9;
      border-radius: 10px;
      padding: 20px;
    }

    a.button {
      display: inline-block;
      text-decoration: none;
      background-color: #1e40af;
      color: white;
      padding: 10px 20px;
      border-radius: 8px;
      font-weight: 600;
      transition: background 0.2s ease;
    }

    a.button:hover {
      background-color: #2563eb;
    }

    .footer {
      text-align: center;
      margin-top: 40px;
      font-size: 0.9em;
      color: #6b7280;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>📚 Все заявки читателей</h1>

    <?php if (empty($requests)): ?>
      <div class="empty">Пока нет заявок 😔</div>
    <?php else: ?>
      <?php foreach ($requests as $r): ?>
        <div class="card">
          <strong><?= htmlspecialchars($r['name']) ?></strong> — билет №<?= htmlspecialchars($r['ticket_number']) ?>
          <div class="meta">
            Жанр: <?= htmlspecialchars($r['genre']) ?><br>
            Электронная версия: <?= $r['ebook'] ? 'да' : 'нет' ?><br>
            Срок аренды: <?= htmlspecialchars($r['period']) ?>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>

    <div style="text-align:center; margin-top:30px;">
      <a href="index.php" class="button">🏠 На главную</a>
      <a href="form.html" class="button" style="margin-left:10px;">➕ Добавить новую</a>
    </div>

    <div class="footer">
      © <?= date('Y') ?> Электронная библиотека | Все права защищены
    </div>
  </div>
</body>
</html>
