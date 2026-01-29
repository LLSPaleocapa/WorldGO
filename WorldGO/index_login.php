<?php
// Non serve più session_start() perché usiamo JWT
?>

<!doctype html>
<html lang="en">
<head>
    <title>LOGIN</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous"
    />
</head>
<body>
    <header></header>
    <main>
        <h1 class="alert alert-success"> LOGIN </h1>

        <?php if(isset($_GET["errore"])){ ?>
            <h2 class="alert alert-danger">Errore</h2>
        <?php  } ?>

        <?php if(isset($_GET["messaggio"])){ ?>
            <h2 class="alert alert-success">Registrazione con successo</h2>
        <?php  } ?>

        <div class="container">
            <form id="loginForm">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required/>
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required/>
                <br>
                <button class="btn btn-primary" type="submit">login</button>
            </form>
            <a class="btn btn-primary" href="index_registra.php">Registrati</a>
            <a class="btn btn-primary" href="index.php">HOME</a>
        </div>
    </main>

    <footer></footer>

    <!-- Bootstrap JS -->
    <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"
    ></script>
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"
    ></script>

    <script>
    // Gestione login con JWT
    const form = document.getElementById("loginForm");
    form.addEventListener("submit", function(e) {
        e.preventDefault(); // blocca submit classico

        fetch("login.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                username: document.getElementById("username").value,
                password: document.getElementById("password").value
            })
        })
        .then(res => res.json())
        .then(data => {
            if(data.token){
                localStorage.setItem("jwt", data.token);
                window.location.href = "visualizzaUtente.php";
            } else {
                alert(data.messaggio || "Errore login");
            }
        })
        .catch(err => {
            console.error("Errore rilevato:", err);
            alert("Errore server: " + err.message);
        });
    });

    // Rimuovi messaggio errore dopo 3 secondi
    <?php if(isset($_GET["errore"])){ ?>
        setTimeout(() => {
            const h2 = document.querySelector("h2.alert-danger");
            if(h2) h2.style.display = "none";
        }, 3000);
    <?php } ?>
    </script>
</body>
</html>
