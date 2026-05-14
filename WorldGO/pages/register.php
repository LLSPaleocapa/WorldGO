<!doctype html>
<html lang="en">
    <head>
        <title>Title</title>
        <!-- Required meta tags -->
        <meta charset="utf-8"/>
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <!-- Bootstrap CSS v5.2.1 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
        <link rel="stylesheet" href="../css/auth.css">
    </head>

    <body>
        <header>
            <!-- place navbar here -->
        </header>
        <main>
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
                <h4>Unisciti a WorldGO</h4>
                <p>Crea un account per condividere i tuoi viaggi</p>
                <form action="../auth/register.php" method="POST">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required/>
                    <label for="email" class="form-label">Email</label>
                    <input type="text" class="form-control" id="email" name="email" required/>
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required/>
                    <br><button class="btn" type="submit">Registra</button>
                </form>
                <br>
                <p>Hai già un account? <a href="login.php">Accedi</a></p>
                <br>
                <p><a href="../index.php">torna alla HOME</a></p>
            </div>

        </main>
        <footer>
            <!-- place footer here -->
        </footer>
        <!-- Bootstrap JavaScript Libraries -->
         
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
    </body>
</html>

