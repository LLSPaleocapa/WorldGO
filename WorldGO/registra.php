<?php
require 'config.php'; 

$username = $_POST["username"];
$password = $_POST["password"];
$email = $_POST["email"];

$hash = password_hash($password, PASSWORD_DEFAULT);

try {
    $pdo->beginTransaction();

    // Controllo username (opzionale)
    $stmt = $pdo->prepare("SELECT * FROM WorldGO_users WHERE username = :username FOR UPDATE");
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch();

    if ($user) {
        $pdo->rollBack(); // Annulla transazione
        echo "Errore: username già presente!";
        exit;
    }

    // Inserimento nuovo utente
    $stmt = $pdo->prepare("INSERT INTO WorldGO_users (username, password, email) VALUES (:username, :password, :email)");
    $stmt->execute([
        ':username' => $username,
        ':password' => $hash,
        ':email' => $email
    ]);

    $pdo->commit(); // Conferma la transazione
    echo "Registrazione avvenuta con successo per $username";

} catch (PDOException $e) {
    $pdo->rollBack(); // Annulla la transazione se c'è un errore
    if ($e->getCode() == 23000) {
        // Duplicate entry
        echo "Errore: username già presente (gestito dalla transazione)";
    } else {
        echo "Errore PDO: " . $e->getMessage();
    }
}

/*
try {
    // Controllo se l'username esiste già
    $sql = "SELECT * FROM WorldGO_users WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch();

    if ($user) {
        echo "Errore: username già presente!";
        exit;
    }

    // Inserimento nuovo utente
    $sql = "INSERT INTO WorldGO_users (username, password, email) VALUES (:username, :password, :email)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':username' => $username,
        ':password' => $hash,
        ':email' => $email
    ]);

    echo "Registrazione avvenuta con successo per $username";

} catch (PDOException $e) {
    // Mostra sempre il messaggio reale del database
    echo "Errore PDO: " . $e->getMessage();
}

*/

?>