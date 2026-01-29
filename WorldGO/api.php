<?php
require 'vendor/autoload.php';
require 'config.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

header('Content-Type: application/json');

// Recupero token JWT
$headers = array_change_key_case(getallheaders(), CASE_LOWER);
$token = $headers['authorization'] ?? '';
if (!$token) {
    http_response_code(401);
    echo json_encode(['error'=>'Token mancante']);
    exit;
}
$token = str_replace("Bearer ", "", $token);

try {
    $decoded = JWT::decode($token, new Key(SECRET_KEY,'HS256'));
} catch (Exception $e) {
    http_response_code(401);
    echo json_encode(['error'=>'Token non valido']);
    exit;
}

// Routing
$route = $_GET['route'] ?? '';

switch($route){
    case 'utente':
        echo json_encode([
            'username' => $decoded->username ?? 'Utente',
            'user_id'  => $decoded->user_id ?? 0
        ]);
        break;

    case 'visualizzaRuolo':
        try {
            // Prepariamo la query per ottenere ruoli e permessi dell'utente
            $sql = "
                SELECT 
                    r.role AS role_name,
                    p.Permission AS permission_name
                FROM WorldGO_users u
                LEFT JOIN WorldGO_user_roles ur ON u.id = ur.user_id
                LEFT JOIN WorldGO_roles r ON ur.role_id = r.id
                LEFT JOIN WorldGO_role_permissions rp ON r.id = rp.role_id
                LEFT JOIN WorldGO_permissions p ON rp.permission_id = p.id
                WHERE u.username = :username
            ";

            $stmt = $pdo->prepare($sql);
            $stmt->execute(['username' => $decoded->username]);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Organizziamo i dati in array ruoli => permessi
            $roles = [];
            foreach ($results as $row) {
                $role = $row['role_name'];
                $perm = $row['permission_name'];
                if (!isset($roles[$role])) {
                    $roles[$role] = [];
                }
                $roles[$role][] = $perm;
            }

            echo json_encode([
                'username' => $decoded->username,
                'roles'    => $roles
            ]);

        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Errore nel recupero dei ruoli: ' . $e->getMessage()]);
        }
        break;

    case 'logout':
        // Non si può invalidare JWT lato server se è solo firmato
        echo json_encode(['message'=>'Logout lato client: rimuovi il token dal localStorage']);
        break;

    default:
        http_response_code(404);
        echo json_encode(['error'=>'Risorsa non trovata']);
        break;
}
