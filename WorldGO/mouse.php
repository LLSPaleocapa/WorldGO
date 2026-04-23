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
    </head>

    <body>
        <header>
            <!-- place navbar here -->
        </header>
        <main>


        </main>
        <footer>
            <!-- place footer here -->
        </footer>
        <!-- Bootstrap JavaScript Libraries -->
    
        <script src="https://unpkg.com/mqtt/dist/mqtt.min.js"></script>

        <script>
        const client = mqtt.connect("wss://broker.emqx.io:8084/mqtt");

        // ID utente unico
        const userId = "user_" + Math.floor(Math.random() * 10000);

        // Salva cursori degli altri
        const cursori = {};

        client.on("connect", () => {
        console.log("Connesso!");
        client.subscribe("mouse/stanza1");
        });

        // 📤 INVIO POSIZIONE MOUSE
        let lastSent = 0;

        document.addEventListener("mousemove", (e) => {
        const now = Date.now();
        if (now - lastSent < 30) return; // limita invii

        lastSent = now;

        const data = {
            id: userId,
            x: e.clientX,
            y: e.clientY
        };

        client.publish("mouse/stanza1", JSON.stringify(data));
        });

        // 📥 RICEZIONE POSIZIONI
        client.on("message", (topic, message) => {
        const data = JSON.parse(message.toString());

        // ignora il proprio mouse
        if (data.id === userId) return;

        let cursor = cursori[data.id];

        // crea cursore se non esiste
        if (!cursor) {
            cursor = document.createElement("div");
            cursor.style.position = "absolute";
            cursor.style.width = "12px";
            cursor.style.height = "12px";
            cursor.style.borderRadius = "50%";
            cursor.style.background = "red";
            cursor.style.pointerEvents = "none";

            document.body.appendChild(cursor);
            cursori[data.id] = cursor;
        }

        // aggiorna posizione
        cursor.style.left = data.x + "px";
        cursor.style.top = data.y + "px";
        });
        </script>


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
