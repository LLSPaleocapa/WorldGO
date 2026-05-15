<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/config.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

header('Content-Type: application/json');

// Recupero token JWT
$headers = array_change_key_case(getallheaders(), CASE_LOWER);
$token = '';
if (!empty($headers['authorization'])) {
    $token = str_replace("Bearer ", "", $headers['authorization']);
} elseif (!empty($_COOKIE['jwt'])) {
    $token = $_COOKIE['jwt'];
}

if (!$token) {
    http_response_code(401);
    echo json_encode(['error'=>'Token mancante']);
    exit;
}

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

    case 'userPosts':
        try {
            $sql = "
                SELECT 
                    p.id,
                    p.titolo,
                    p.descrizione,
                    p.url_media,
                    p.data_pubblicazione,
                    u.username,
                    COUNT(l.id_post) AS numero_likes
                FROM WorldGO_posts p
                LEFT JOIN WorldGO_likes l ON p.id = l.id_post
                LEFT JOIN WorldGO_users u ON p.id_utente = u.id
                WHERE p.id_utente = :user_id
                GROUP BY p.id
                ORDER BY p.data_pubblicazione DESC
            ";

            $stmt = $pdo->prepare($sql);
            $stmt->execute(['user_id' => $decoded->user_id]);
            $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Normalizza i percorsi delle immagini - usa BASE_URL per renderli assoluti
            foreach ($posts as &$post) {
                if (!empty($post['url_media'])) {
                    // Se non è un URL assoluto, aggiungi BASE_URL
                    if (!preg_match('~^https?://~', $post['url_media'])) {
                        $post['url_media'] = BASE_URL . ltrim($post['url_media'], '/');
                    }
                } else {
                    $post['url_media'] = BASE_URL . 'imgs/uploads/posts/placeholder.jpg';
                }
            }

            echo json_encode($posts);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Errore nel recupero dei post utente: ' . $e->getMessage()]);
        }
        break;

    case 'logout':
        // Non si può invalidare JWT lato server se è solo firmato,
        // ma possiamo eliminare il cookie HttpOnly lato client.
        setcookie('jwt', '', [
            'expires' => time() - 3600,
            'path' => '/',
            'httponly' => true,
            'samesite' => 'Strict',
            'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'
        ]);
        echo json_encode(['message'=>'Logout lato client: cookie JWT eliminato']);
        break;

    default:
        http_response_code(404);
        echo json_encode(['error'=>'Risorsa non trovata']);
        break;
}
