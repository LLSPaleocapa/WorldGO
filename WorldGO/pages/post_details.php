<?php
require_once '../vendor/autoload.php';
require_once '../config/config-web.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: ../index.php');
    exit;
}

$post_id = (int)$_GET['id'];

// Verifica JWT per controllare se l'utente è loggato
$user_id = null;
$token = $_COOKIE['jwt'] ?? '';
if ($token) {
    try {
        $decoded = JWT::decode($token, new Key(SECRET_KEY, 'HS256'));
        $user_id = $decoded->user_id ?? null;
    } catch (Exception $e) {
        // Token non valido, ma permettiamo la visualizzazione
    }
}
?>

<!doctype html>
<html lang="it">
<head>
    <title>Post - WorldGO</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<p><a href="../index.php">torna indietro</a></p>

<main class="container mt-5">
    <div class="row">
        <div class="col-md-8">
            <div id="loading" class="text-center">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Caricamento...</span>
                </div>
            </div>
            <div id="post-content" style="display: none;">
                <h1 id="post-title"></h1>
                <p class="text-muted" id="post-meta"></p>
                <img id="post-image" alt="Immagine del post" class="img-fluid mb-3" style="display: none; max-width: 100%; height: auto;">
                <p id="post-description"></p>
                <p id="post-likes"><strong>❤️ <span id="likes-count">0</span> likes</strong></p>
                <div id="post-actions" class="mt-4"></div>
            </div>
            <div id="error-message" class="alert alert-danger" style="display: none;"></div>
        </div>
    </div>
</main>

<!-- FOOTER -->
<footer class="footer">
    <div class="container">
        © 2026 WorldGO
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Recupera i dati del post dal backend
    const postId = <?php echo $post_id; ?>;
    const userId = <?php echo $user_id ?? 'null'; ?>;

    fetch(`../actions/post_details_action.php?id=${postId}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                throw new Error(data.error);
            }

            // Aggiorna il titolo della pagina
            document.title = `${data.titolo} - WorldGO`;

            // Popola i campi
            document.getElementById('post-title').textContent = data.titolo;
            document.getElementById('post-meta').textContent = 
                `Pubblicato da ${data.username} il ${new Date(data.data_pubblicazione).toLocaleDateString('it-IT')}`;
            
            if (data.url_media) {
                const img = document.getElementById('post-image');
                img.src = data.url_media;
                img.style.display = 'block';
            }

            document.getElementById('post-description').innerHTML = data.descrizione.replace(/\n/g, '<br>');
            document.getElementById('likes-count').textContent = data.numero_likes;

            // Mostra il contenuto e nascondi il loading
            document.getElementById('loading').style.display = 'none';
            document.getElementById('post-content').style.display = 'block';

            // Se è il proprietario, mostra i pulsanti di azione
            if (data.is_owner) {
                const actionsDiv = document.getElementById('post-actions');
                actionsDiv.innerHTML = `
                    <button class="btn btn-warning me-2" onclick="editPost(${data.id})">Modifica</button>
                    <button class="btn btn-danger" onclick="deletePost(${data.id})">Elimina</button>
                `;
            }
        })
        .catch(error => {
            console.error('Errore:', error);
            document.getElementById('loading').style.display = 'none';
            document.getElementById('error-message').style.display = 'block';
            document.getElementById('error-message').textContent = `Errore: ${error.message}`;
        });

    function editPost(postId) {
        alert('Modifica post: ' + postId);
        // Da implementare
    }

    function deletePost(postId) {
        if (confirm('Sei sicuro di voler eliminare questo post?')) {
            alert('Elimina post: ' + postId);
            // Da implementare
        }
    }
</script>
</body>
</html>