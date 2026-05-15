<?php
require_once 'config/config.php';

header('Content-Type: application/json');

echo json_encode([
    'BASE_URL' => BASE_URL,
    'UPLOADS_DIR' => UPLOADS_DIR,
    'script_name' => $_SERVER['SCRIPT_NAME'] ?? 'N/A',
    'http_host' => $_SERVER['HTTP_HOST'] ?? 'N/A',
    'server_name' => $_SERVER['SERVER_NAME'] ?? 'N/A',
    'request_uri' => $_SERVER['REQUEST_URI'] ?? 'N/A',
    'script_filename' => $_SERVER['SCRIPT_FILENAME'] ?? 'N/A',
    'posts_con_immagini' => [],
], JSON_PRETTY_PRINT);

// Aggiungi info sui post
$sql = "SELECT id, titolo, url_media FROM WorldGO_posts WHERE url_media != '' LIMIT 5";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$posts = $stmt->fetchAll();

$result = json_decode(json_encode([
    'BASE_URL' => BASE_URL,
    'posts' => $posts,
], JSON_PRETTY_PRINT), true);

echo json_encode($result, JSON_PRETTY_PRINT);
?>
