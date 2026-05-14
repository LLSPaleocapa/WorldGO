<?php

require_once '../vendor/autoload.php';
require_once '../config/config.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

header('Content-Type: application/json');

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'ID post mancante o non valido']);
    exit;
}

$post_id = (int)$_GET['id'];

try {
    $sql = "
    SELECT 
        p.id,
        p.titolo,
        p.descrizione,
        p.url_media,
        p.data_pubblicazione,
        u.id as user_id,
        u.username,
        COUNT(l.id_post) AS numero_likes
    FROM WorldGO_posts p
    LEFT JOIN WorldGO_likes l 
        ON p.id = l.id_post
    LEFT JOIN WorldGO_users u 
        ON p.id_utente = u.id
    WHERE p.id = ?
    GROUP BY p.id
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$post_id]);
    $post = $stmt->fetch();

    if (!$post) {
        http_response_code(404);
        echo json_encode(['error' => 'Post non trovato']);
        exit;
    }

    // Verifica JWT per controllare se l'utente è loggato
    $user_id = null;
    $is_owner = false;
    $token = $_COOKIE['jwt'] ?? '';
    
    if ($token) {
        try {
            $decoded = JWT::decode($token, new Key(SECRET_KEY, 'HS256'));
            $user_id = $decoded->user_id ?? null;
            $is_owner = ($user_id == $post['user_id']);
        } catch (Exception $e) {
            // Token non valido
        }
    }

    // Costruisci il percorso corretto dell'immagine
    $image_url = $post['url_media'];
    if (!filter_var($image_url, FILTER_VALIDATE_URL)) {
        // Se non è un URL assoluto, aggiungi il prefisso relativo
        $image_url = '../' . $image_url;
    }

    echo json_encode([
        'id' => $post['id'],
        'titolo' => $post['titolo'],
        'descrizione' => $post['descrizione'],
        'url_media' => $image_url,
        'data_pubblicazione' => $post['data_pubblicazione'],
        'username' => $post['username'],
        'user_id' => $post['user_id'],
        'numero_likes' => (int)$post['numero_likes'],
        'is_owner' => $is_owner,
        'current_user_id' => $user_id
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Errore nel recupero del post: ' . $e->getMessage()]);
}
