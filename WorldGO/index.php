<!doctype html>
<html lang="it">
<head>
    <title>WorldGO</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72 72" width="50" height="50">
            <g transform="translate(5,5)">
                <path fill="none" stroke="currentColor" stroke-width="2" d="M40,14.1c-1.9-1-4.1-1.7-6.3-2.1L31,0l-2.7,12.1c-8.4,1.2-15.1,7.8-16.3,16.3L0,31l12.1,2.7c0.3,2.3,1,4.4,2.1,6.3"/>
                <path fill="none" stroke="currentColor" stroke-width="2" d="M22,47.9c1.9,1,4.1,1.7,6.3,2.1L31,62l2.7-12.1c8.4-1.2,15.1-7.8,16.3-16.3L62,31l-12.1-2.7c-0.3-2.3-1-4.4-2.1-6.3"/>
                <path fill="none" stroke="currentColor" stroke-width="2" d="M43.7,28.1C43.9,29,44,30,44,31c0,7.2-5.8,13-13,13c-1,0-2-0.1-3-0.3"/>
                <path fill="none" stroke="currentColor" stroke-width="2" d="M18.3,33.9C18.1,33,18,32,18,31c0-7.2,5.8-13,13-13c1.1,0,2.1,0.1,3.1,0.4"/>
                <path fill="none" stroke="currentColor" stroke-width="2" d="M4.8,57.2l22-30.4l30.4-22l-22,30.4L4.8,57.2z"/>
                <circle cx="31" cy="31" r="2" fill="none" stroke="currentColor" stroke-width="2"/>
            </g>
        </svg>

        <a class="navbar-brand text-white fw-bold" href="#">WorldGO</a>

        <button class="navbar-toggler border-0" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="nav">
            <ul class="navbar-nav gap-3">
                <li class="nav-item"><a class="nav-link text-white" href="pages/login.php">Accedi</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="pages/register.php">Registrati</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="pages/dashboard.php">Dashboard</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- HERO -->
<main>
    <section class="hero">

        <div class="hero-bg active"></div>
        <div class="hero-bg"></div>

        <div class="hero-content">
            <h1>WorldGO</h1>
            <p>Dove vuoi, come vuoi</p>

            <div class="d-flex gap-3 justify-content-center mt-4">
                <a href="pages/login.php" class="btn btn-brand">Accedi</a>
                <a href="pages/register.php" class="btn btn-brand">Registrati</a>
            </div>
        </div>

    </section>
</main>

<section class="posts in evidenza">
    <h2>In evidenza</h2>
    <p>Scopri le mete più amate dalla community e lasciati ispirare per il tuo prossimo viaggio</p>
</section>

<!-- FOOTER -->
<footer class="footer">
    <div class="container">
        © 2026 WorldGO
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/index.js"></script>
</body>
</html>