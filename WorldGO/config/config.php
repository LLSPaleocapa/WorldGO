<?php
header('Content-Type: application/json');

$host = '127.0.0.1';
$port = '3306';
$dbname = 'my_lilisheng5ie';
$username = 'lilisheng5ie';
$password = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,       // Errori come eccezioni
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,  // Restituisce array associativi
    PDO::ATTR_EMULATE_PREPARES => false,               // Usa prepared statements reali
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    http_response_code(500);
    die(json_encode(['error' => 'Connessione fallita: ' . $e->getMessage()]));
}

define('SECRET_KEY', 'mia_chiave_super_segreta_molto_lunga');