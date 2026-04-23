<hr>
<h2>Test Concorrenza</h2>
<div class="container">
    <label for="test-username" class="form-label">Username di test</label><br>
    <input type="text" class="form-control" id="test-username" value="utente_test"/><br>
    <label for="test-email" class="form-label">Email di test</label><br>
    <input type="text" class="form-control" id="test-email" value="test@example.com"/><br>
    <label for="test-password" class="form-label">Password di test</label><br>
    <input type="password" class="form-control" id="test-password" value="123456"/><br>
    <br>
    <button class="btn btn-danger" id="start-concurrency-test">Avvia test concorrenza</button>
</div>

<script>
document.getElementById('start-concurrency-test').addEventListener('click', function() {
    const username = document.getElementById('test-username').value;
    const email = document.getElementById('test-email').value;
    const password = document.getElementById('test-password').value;

    const data = new URLSearchParams();
    data.append('username', username);
    data.append('email', email);
    data.append('password', password);

    // Invio prima richiesta
    fetch('registra.php', {
        method: 'POST',
        body: data
    }).then(response => response.text())
      .then(text => console.log('Prima richiesta:', text));

    // Invio seconda richiesta quasi contemporaneamente
    fetch('registra.php', {
        method: 'POST',
        body: data
    }).then(response => response.text())
      .then(text => console.log('Seconda richiesta:', text));
});
</script>