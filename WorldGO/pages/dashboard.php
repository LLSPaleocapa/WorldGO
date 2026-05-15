<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Utente</title>
    <link rel="stylesheet" href="../css/index.css">
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h2 { color: #333; }
        .card { border: 1px solid #ccc; padding: 15px; margin-bottom: 15px; border-radius: 8px; box-shadow: 2px 2px 6px rgba(0,0,0,0.1); }
        ul { padding-left: 20px; }
        #user-highlighted-posts {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <h1>Dashboard Utente</h1>

    <div class="card">
        <h2>Dati Utente</h2>
        <div id="userData">Caricamento...</div>
    </div>

    <div class="card">
        <h2>Ruoli e Permessi</h2>
        <div id="rolesData">Caricamento...</div>
    </div>

    <div class="card">
        <h2>I tuoi post pubblicati</h2>
        <div id="user-posts-message">Caricamento...</div>
        <div id="user-highlighted-posts"></div>
    </div>

    <a class="btn btn-primary" href="../index.php">HOME</a>
    <a class="btn btn-primary" href="../auth/logout.php">LOGOUT</a>

    <script>
        const userData = document.getElementById("userData");
        const rolesData = document.getElementById("rolesData");

        fetch("../api/api.php?route=utente", {
            credentials: "same-origin"
        })
        .then(res => res.json())
        .then(data => {
            if (data.error) {
                userData.innerText = data.error;
            } else {
                userData.innerHTML = `
                    <p><strong>Username:</strong> ${data.username}</p>
                    <p><strong>User ID:</strong> ${data.user_id}</p>
                `;
            }
        })
        .catch(err => {
            userData.innerText = "Errore nel recupero dei dati utente";
            console.error(err);
        });

        fetch("../api/api.php?route=visualizzaRuolo", {
            credentials: "same-origin"
        })
        .then(res => res.json())
        .then(data => {
            if (data.error) {
                rolesData.innerText = data.error;
            } else {
                if (!data.roles || Object.keys(data.roles).length === 0) {
                    rolesData.innerText = "Nessun ruolo o permesso assegnato.";
                } else {
                    let html = "";
                    for (const role in data.roles) {
                        html += `<h3>${role}</h3><ul>`;
                        if (data.roles[role].length === 0) {
                            html += "<li>Nessun permesso</li>";
                        } else {
                            data.roles[role].forEach(perm => {
                                html += `<li>${perm}</li>`;
                            });
                        }
                        html += `</ul>`;
                    }
                    rolesData.innerHTML = html;
                }
            }
        })
        .catch(err => {
            rolesData.innerText = "Errore nel recupero dei ruoli";
            console.error(err);
        });

        const userPostsMessage = document.getElementById('user-posts-message');
        const userPostsContainer = document.getElementById('user-highlighted-posts');

        fetch('../api/api.php?route=userPosts', {
            credentials: 'same-origin'
        })
        .then(res => res.json())
        .then(data => {
            if (data.error) {
                userPostsMessage.innerText = data.error;
                return;
            }

            if (!Array.isArray(data) || data.length === 0) {
                userPostsMessage.innerText = 'Nessun post pubblicato al momento.';
                return;
            }

            userPostsMessage.style.display = 'none';
            userPostsContainer.innerHTML = '';

            data.forEach(post => {
                console.log('Post caricato:', post.titolo, 'Immagine URL:', post.url_media);
                userPostsContainer.innerHTML += `
                    <div class="highlighted-post" onclick="window.location.href='../pages/post_details.php?id=${post.id}'" style="cursor: pointer;">
                        ${post.url_media ? `<img src="${".." + post.url_media}" alt="Immagine del post" class="post-image" onerror="console.error('Immagine non trovata:', '${".." + post.url_media}')">` : ''}
                        <h2>${post.titolo}</h2>
                        <p>${post.descrizione}</p>
                        <p>by: ${post.username}</p>
                        <p>❤️${post.numero_likes}</p>
                    </div>
                `;
            });
        })
        .catch(err => {
            userPostsMessage.innerText = 'Errore nel recupero dei tuoi post';
            console.error(err);
        });
    </script>
</body>
</html>
