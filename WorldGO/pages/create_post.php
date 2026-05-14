<?php
require_once '../vendor/autoload.php';
require_once '../config/config-web.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

    // Verifica che l'utente sia autenticato (JWT nel cookie)
    $token = $_COOKIE['jwt'] ?? '';

    if (!$token) {
        header('Location: login.php');
        exit;
    }

    try {
        $decoded = JWT::decode($token, new Key(SECRET_KEY, 'HS256'));
    } catch (Exception $e) {
        header('Location: login.php');
        exit;
    }
?>

<!doctype html>
<html lang="it">
<head>
    <title>Crea Post - WorldGO</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/index.css">
</head>

<body>

<main class="container mt-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <h1 class="mb-4">Pubblica un viaggio</h1>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
            <?php endif; ?>

            <form action="../actions/create_post_action.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="titolo" class="form-label">Titolo del viaggio</label>
                    <input type="text" class="form-control" id="titolo" name="titolo" required maxlength="30">
                    <small class="text-muted">Massimo 30 caratteri</small>
                </div>

                <div class="mb-3">
                    <label for="descrizione" class="form-label">Descrizione</label>
                    <textarea class="form-control" id="descrizione" name="descrizione" rows="5" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="url_media" class="form-label">URL Immagine</label>
                    <input type="text" class="form-control" id="url_media" name="url_media" placeholder="https://esempio.com/immagine.jpg">
                    <small class="text-muted">Puoi inserire un URL esterno</small>
                </div>

                <div class="mb-3">
                    <label for="immagine" class="form-label">Oppure carica un'immagine</label>
                    <input type="file" class="form-control" id="immagine" name="immagine" accept="image/*">
                    <small class="text-muted">Formati supportati: JPG, JPEG, PNG, GIF - Massimo 5MB</small>
                    <div id="file-error" class="text-danger small mt-2" style="display: none;"></div>
                </div>

                <button type="submit" class="btn btn-brand" id="submit-btn">Pubblica</button>
                <a href="dashboard.php" class="btn btn-secondary">Annulla</a>
            </form>
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
    // Validazione file size lato client
    const MAX_FILE_SIZE = 5 * 1024 * 1024; // 5MB
    const fileInput = document.getElementById('immagine');
    const fileError = document.getElementById('file-error');
    const submitBtn = document.getElementById('submit-btn');

    fileInput.addEventListener('change', function() {
        fileError.style.display = 'none';
        fileError.textContent = '';
        submitBtn.disabled = false;

        if (this.files.length > 0) {
            const file = this.files[0];
            
            if (file.size > MAX_FILE_SIZE) {
                fileError.textContent = `Errore: Il file è troppo grande (${(file.size / 1024 / 1024).toFixed(2)}MB). Massimo: 5MB`;
                fileError.style.display = 'block';
                submitBtn.disabled = true;
                this.value = '';
            } else if (!['image/jpeg', 'image/png', 'image/gif'].includes(file.type)) {
                fileError.textContent = 'Errore: Formato non supportato. Usa JPG, PNG o GIF';
                fileError.style.display = 'block';
                submitBtn.disabled = true;
                this.value = '';
            }
        }
    });

    // Validazione form submit
    document.querySelector('form').addEventListener('submit', function(e) {
        if (fileInput.files.length > 0 && fileInput.files[0].size > MAX_FILE_SIZE) {
            e.preventDefault();
            fileError.textContent = 'Errore: Il file è troppo grande. Massimo: 5MB';
            fileError.style.display = 'block';
        }
    });
</script>