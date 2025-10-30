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
      background: #f8fafc;
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
      max-width: 900px;
      margin: 0 auto;
      background: #fff;
      border-radius: 14px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
      padding: 30px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 15px;
    }

    th, td {
      border: 1px solid #e2e8f0;
      padding: 12px 14px;
      text-align: left;
    }

    th {
      background-color: #1e3a8a;
      color: white;
      font-weight: 600;
      text-transform: uppercase;
      font-size: 14px;
    }

    tr:nth-child(even) {
      background-color: #f1f5f9;
    }

    tr:hover {
      background-color: #e0e7ff;
      transition: background-color 0.2s ease;
    }

    .empty {
      text-align: center;
      color: #64748b;
      font-size: 16px;
      padding: 20px;
    }

    .buttons {
      text-align: center;
      margin-top: 25px;
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
      margin: 0 5px;
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
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Имя читателя</th>
            <th>Билет №</th>
            <th>Жанр</th>
            <th>Электронная версия</th>
            <th>Срок аренды</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($requests as $r): ?>
            <tr>
              <td><?= htmlspecialchars($r['id']) ?></td>
              <td><?= htmlspecialchars($r['name']) ?></td>
              <td><?= htmlspecialchars($r['ticket_number']) ?></td>
              <td><?= htmlspecialchars($r['genre']) ?></td>
              <td><?= $r['ebook'] ? 'Да' : 'Нет' ?></td>
              <td><?= htmlspecialchars($r['period']) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>

    <div class="buttons">
      <a href="index.php" class="button">🏠 На главную</a>
      <a href="form.html" class="button">➕ Добавить новую</a>
    </div>

    <div class="footer">
      © <?= date('Y') ?> Электронная библиотека | Все права защищены
    </div>
  </div>
</body>
</html>
