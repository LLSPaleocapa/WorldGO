<?php
header('Content-Type: application/json');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'config.php';
require 'vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// Legge il body della richiesta
$input = json_decode(file_get_contents('php://input'), true);
$username = $input['username'] ?? '';
$password = $input['password'] ?? '';

// Controlla se l'utente esiste nel DB
$sql = "SELECT * FROM WorldGO_users WHERE username = :username";
$stmt = $pdo->prepare($sql);
$stmt->execute([':username' => $username]);
$utente = $stmt->fetch();

if($utente && password_verify($password, $utente['password'])) {
    $payload = [
        'user_id' => $utente['id'],
        'username' => $utente['username'],
        'iat' => time(),
        'exp' => time() + 600  // 10 minuti
    ];

    $jwt = JWT::encode($payload, SECRET_KEY, 'HS256');
    
    $response = [
        "success" => true,
        "message" => "Login effettuato",
        "token"   => $jwt
    ];

    echo json_encode($response);

} else {
    http_response_code(401);
    echo json_encode(['error' => 'Credenziali non valide']);
}