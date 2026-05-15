<?php

require_once '../config/config.php';

try {
    $sql = "
    SELECT 
        p.id,
        p.titolo,
        p.descrizione,
        p.url_media,
        p.data_pubblicazione,
        u.username,
        COUNT(l.id_post) AS numero_likes
    FROM WorldGO_posts p
    LEFT JOIN WorldGO_likes l 
        ON p.id = l.id_post
    LEFT JOIN WorldGO_users u 
        ON p.id_utente = u.id
    GROUP BY p.id
    ORDER BY numero_likes DESC, p.data_pubblicazione DESC
    LIMIT 6
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $posts = $stmt->fetchAll();


    foreach ($posts as &$post) {
        if (!empty($post['url_media'])) {
            // Se non è un URL assoluto, aggiungi BASE_URL
            if (!preg_match('~^https?://~', $post['url_media'])) {
                $post['url_media'] =ltrim($post['url_media'], '/');
            }
        } else {
            $post['url_media'] = '/imgs/uploads/posts/placeholder.jpg';
        }
    }

    header('Content-Type: application/json');
    echo json_encode($posts);

} catch (Exception $e) {
    header('Content-Type: application/json');
    echo json_encode(['error' => $e->getMessage()]);
}

?>