<?php

require_once '../vendor/autoload.php';
require_once '../config/config-web.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// Recupero JWT dal cookie
$token = $_COOKIE['jwt'] ?? '';

if (!$token) {
    header('Location: create_post.php?error=' . urlencode('Token di autenticazione mancante'));
    exit;
}

try {
    // Decodifico il JWT per ottenere l'user_id
    $decoded = JWT::decode($token, new Key(SECRET_KEY, 'HS256'));
    $user_id = (int)($decoded->user_id ?? 0);

    if (!$user_id) {
        throw new Exception('User ID non trovato nel token');
    }

    $titolo = $_POST['titolo'] ?? '';
    $descrizione = $_POST['descrizione'] ?? '';
    $url_media_input = $_POST['url_media'] ?? '';

    // Validazione base
    if (empty($titolo) || empty($descrizione)) {
        throw new Exception('Titolo e descrizione sono obbligatori');
    }

    if (strlen($titolo) > 30) {
        throw new Exception('Il titolo non può superare 30 caratteri');
    }

    $url_media = $url_media_input;
    $tipo_media = 1; // 1 = immagine

    // Gestire il caricamento del file
    if (isset($_FILES['immagine']) && $_FILES['immagine']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $file_name = $_FILES['immagine']['name'];
        $file_size = $_FILES['immagine']['size'];
        $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        // Controlla la dimensione (5MB massimo)
        if ($file_size > 5 * 1024 * 1024) {
            throw new Exception('Il file è troppo grande. Massimo: 5MB');
        }

        if (!in_array($ext, $allowed)) {
            throw new Exception('Formato file non supportato. Usa: JPG, JPEG, PNG, GIF');
        }

        // Creare directory se non esiste
        $upload_dir = '../imgs/uploads/posts/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $new_name = uniqid() . '.' . $ext;
        $destination = $upload_dir . $new_name;

        if (!move_uploaded_file($_FILES['immagine']['tmp_name'], $destination)) {
            throw new Exception('Errore durante il caricamento del file');
        }

        $url_media = 'imgs/uploads/posts/' . $new_name;
    } elseif (isset($_FILES['immagine']) && $_FILES['immagine']['error'] != 0) {
        // Gestisci errori di upload
        $upload_errors = [
            UPLOAD_ERR_INI_SIZE => 'File troppo grande (superato il limite del server)',
            UPLOAD_ERR_FORM_SIZE => 'File troppo grande (superato il limite del form)',
            UPLOAD_ERR_PARTIAL => 'Upload interrotto',
            UPLOAD_ERR_NO_FILE => 'Nessun file selezionato',
            UPLOAD_ERR_NO_TMP_DIR => 'Directory temporanea mancante',
            UPLOAD_ERR_CANT_WRITE => 'Errore durante la scrittura del file',
            UPLOAD_ERR_EXTENSION => 'Estensione del file non consentita',
        ];
        $error_code = $_FILES['immagine']['error'];
        $error_msg = $upload_errors[$error_code] ?? 'Errore sconosciuto durante l\'upload';
        throw new Exception($error_msg);
    }

    if (empty($url_media)) {
        $url_media = 'https://via.placeholder.com/500x300?text=WorldGO';
    }

    // Genera ID univoco per il post
    $post_id = (int)(microtime(true) * 10000);

    $sql = "
    INSERT INTO WorldGO_posts
    (id, id_utente, titolo, descrizione, tipo_media, url_media, data_pubblicazione)
    VALUES (?, ?, ?, ?, ?, ?, NOW())
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $post_id,
        $user_id,
        $titolo,
        $descrizione,
        $tipo_media,
        $url_media
    ]);

    header('Location: ../pages/dashboard.php?success=1');
    exit;

} catch (Exception $e) {
    header('Location: create_post.php?error=' . urlencode($e->getMessage()));
    exit;
}