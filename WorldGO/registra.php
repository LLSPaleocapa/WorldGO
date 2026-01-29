<?php
require 'config.php'; 

$username = $_POST["username"];
$password = $_POST["password"];
$email = $_POST["email"];

$hash = password_hash($password, PASSWORD_DEFAULT);

try {
    $sql = "INSERT INTO WorldGO_users (username, password, email) VALUES (:username, :password, :email)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':username' => $username,
        ':password' => $hash,
        ':email' => $email
    ]);

    header("Location: index.php?messaggio=Registrazione+avvenuta+con+successo+e+email+inviata");
        

    /*
    $to = $email;
    $subject = "Benvenuto!";
    $message = "Ciao ". $username ."! Ti sei registrato con successo al nostro sito!"; 
    $headers = "From: lilisheng5ie@altervista.org\r\n";
    $headers .= "Reply-To: lilisheng5ie@altervista.org\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";


    if (mail($to, $subject, $message, $headers)) {
        header("Location: index.php?messaggio=Registrazione+avvenuta+con+successo+e+email+inviata");
        exit;
    } else {
        header("Location: index.php?messaggio=Registrazione+avvenuta,+ma+errore+nell'invio+della+mail");
        exit;
    }
    */

} catch (PDOException $e) {
    die("Errore durante la registrazione: " . $e->getMessage());
}
?>
