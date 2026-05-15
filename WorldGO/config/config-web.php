<?php
// Configurazione per pagine web (senza header JSON)

$host = '127.0.0.1';
$port = '3306';
$dbname = 'my_lilisheng5ie';
$username = 'lilisheng5ie';
$password = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    die('Errore di connessione: ' . $e->getMessage());
}

define('SECRET_KEY', 'mia_chiave_super_segreta_molto_lunga');
// Per localhost: BASE_URL deve essere '/'
// Per AlterVista con subdirectory: BASE_URL deve essere '/WorldGO/' o il path effettivo
define('BASE_URL', getenv('BASE_URL') ?: '/');
define('UPLOADS_DIR', __DIR__ . '/../imgs/uploads/posts/');
