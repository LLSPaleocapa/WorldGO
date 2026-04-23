<?php
$host = 'localhost';
$dbname = 'my_lilisheng5ie';
$username = 'lilisheng5ie';
$password = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,       // Errori come eccezioni
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,  // Restituisce array associativi
    PDO::ATTR_EMULATE_PREPARES => false,               // Usa prepared statements reali
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    die("Connessione fallita: " . $e->getMessage());
}

define('SECRET_KEY', 'mia_chiave_super_segreta_molto_lunga');