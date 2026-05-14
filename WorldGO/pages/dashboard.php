<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Utente</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h2 { color: #333; }
        .card { border: 1px solid #ccc; padding: 15px; margin-bottom: 15px; border-radius: 8px; box-shadow: 2px 2px 6px rgba(0,0,0,0.1); }
        ul { padding-left: 20px; }
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
    </script>
</body>
</html>
