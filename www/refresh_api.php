<?php
require_once 'ApiClient.php';

$api = new ApiClient();
$url = 'https://openlibrary.org/search.json?q=tolstoy';
$cacheFile = 'api_cache.json';

$apiData = $api->request($url);
if (isset($apiData['error'])) {
    echo "<div class='error'>Ошибка при получении данных: " . htmlspecialchars($apiData['error']) . "</div>";
    exit;
}

file_put_contents($cacheFile, json_encode($apiData, JSON_UNESCAPED_UNICODE));

if (!empty($apiData['docs'])) {
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
