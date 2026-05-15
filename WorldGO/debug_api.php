<?php
require_once __DIR__ . '/config/config.php';

echo "BASE_URL: " . BASE_URL . PHP_EOL;
echo "UPLOADS_DIR: " . UPLOADS_DIR . PHP_EOL;

$sql = "SELECT id, titolo, url_media FROM WorldGO_posts LIMIT 3";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$posts = $stmt->fetchAll();

echo "\nPosts nel database:\n";
foreach ($posts as $post) {
    echo "ID: " . $post['id'] . " | Titolo: " . $post['titolo'] . " | Media: " . $post['url_media'] . PHP_EOL;
}

echo "\nDopo normalizzazione:\n";
foreach ($posts as $post) {
    $url = $post['url_media'];
    if (!empty($url)) {
        if (!preg_match('~^https?://~', $url)) {
            $url = BASE_URL . ltrim($url, '/');
        }
    }
    echo "ID: " . $post['id'] . " | Normalizzato: " . $url . PHP_EOL;
}
?>
