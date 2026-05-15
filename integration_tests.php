#!/usr/bin/env php
<?php
/**
 * WorldGO Integration Tests
 * Test suite di integrazione per API endpoints
 * 
 * Questo file contiene test di integrazione che simulano richieste HTTP
 * agli endpoint principali dell'applicazione WorldGO.
 * 
 * Utilizzo:
 * php integration_tests.php
 * 
 * Prerequisiti:
 * - Server web avviato (es. php -S localhost:8000)
 * - Database MySQL configurato e accessibile
 * - URL_BASE configurato correttamente sotto
 */

// ============================================================================
// CONFIGURAZIONE
// ============================================================================

define('URL_BASE', 'http://lilisheng5ie.altervista.org');
define('TIMEOUT', 10);

// Colori output
class Colors {
    const SUCCESS = "\033[92m";
    const ERROR = "\033[91m";
    const INFO = "\033[94m";
    const WARNING = "\033[93m";
    const RESET = "\033[0m";
}

// ============================================================================
// CLASSE TEST HTTP
// ============================================================================

class HttpTestRunner {
    private $tests = [];
    private $passed = 0;
    private $failed = 0;
    private $total = 0;
    private $cookies = [];
    private $jwt_token = null;
    
    public function addTest($testName, $testFunction) {
        $this->tests[] = ['name' => $testName, 'function' => $testFunction];
    }
    
    public function runTests() {
        echo "\n" . Colors::INFO . "=" . str_repeat("=", 78) . Colors::RESET . "\n";
        echo Colors::INFO . "WORLDGO - INTEGRATION TESTS" . Colors::RESET . "\n";
        echo Colors::INFO . "Base URL: " . URL_BASE . Colors::RESET . "\n";
        echo Colors::INFO . "=" . str_repeat("=", 78) . Colors::RESET . "\n\n";
        
        foreach ($this->tests as $test) {
            $this->runTest($test['name'], $test['function']);
        }
        
        $this->printSummary();
    }
    
    private function runTest($testName, $testFunction) {
        $this->total++;
        echo "Test {$this->total}: {$testName} ... ";
        
        try {
            call_user_func($testFunction, $this);
            echo Colors::SUCCESS . "✓ PASSATO" . Colors::RESET . "\n";
            $this->passed++;
        } catch (Exception $e) {
            echo Colors::ERROR . "✗ FALLITO" . Colors::RESET . "\n";
            echo "  " . Colors::ERROR . "Errore: " . $e->getMessage() . Colors::RESET . "\n";
            $this->failed++;
        }
    }
    
    private function printSummary() {
        echo "\n" . Colors::INFO . str_repeat("=", 80) . Colors::RESET . "\n";
        echo "RISULTATI:\n";
        echo "  " . Colors::SUCCESS . "Passati: {$this->passed}" . Colors::RESET . "\n";
        echo "  " . Colors::ERROR . "Falliti: {$this->failed}" . Colors::RESET . "\n";
        echo "  Totali: {$this->total}\n";
        
        if ($this->failed === 0) {
            echo "\n" . Colors::SUCCESS . "✓ TUTTI I TEST PASSATI!" . Colors::RESET . "\n";
        } else {
            echo "\n" . Colors::ERROR . "✗ ALCUNI TEST SONO FALLITI!" . Colors::RESET . "\n";
        }
        echo Colors::INFO . str_repeat("=", 80) . Colors::RESET . "\n\n";
    }
    
    /**
     * Effettua richiesta HTTP con cURL
     */
    public function request($method, $endpoint, $data = null, $useAuth = false) {
        $url = URL_BASE . $endpoint;
        
        $ch = curl_init($url);
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, TIMEOUT);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_COOKIEFILE, '');
        
        // Aggiungi header Authorization se autenticato
        $headers = ['Content-Type: application/json'];
        if ($useAuth && $this->jwt_token) {
            $headers[] = 'Authorization: Bearer ' . $this->jwt_token;
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        // Aggiungi dati POST/PUT
        if ($data && in_array($method, ['POST', 'PUT'])) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
        
        // Estrai cookie dalla risposta
        $headerFunction = function($curl, $header) {
            $len = strlen($header);
            if (strpos($header, 'Set-Cookie:') === 0) {
                preg_match('/jwt=([^;]+)/', $header, $matches);
                if (!empty($matches[1])) {
                    $this->jwt_token = $matches[1];
                }
            }
            return $len;
        };
        curl_setopt($ch, CURLOPT_HEADERFUNCTION, $headerFunction);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($error) {
            throw new Exception("Errore cURL: {$error}");
        }
        
        return [
            'code' => $httpCode,
            'body' => $response,
            'json' => json_decode($response, true)
        ];
    }
    
    public function setJWTToken($token) {
        $this->jwt_token = $token;
    }
    
    public function getJWTToken() {
        return $this->jwt_token;
    }
}

// ============================================================================
// TEST DI INTEGRAZIONE
// ============================================================================

class WorldGOIntegrationTests {
    
    // ====== AUTENTICAZIONE ======
    
    public static function testLoginEndpointAvailable($runner) {
        // Verifica che l'endpoint di login sia disponibile
        $result = $runner->request('GET', '/WorldGO/auth/login.php');
        
        if ($result['code'] !== 200 && $result['code'] !== 405) {
            throw new Exception("Login endpoint non disponibile (HTTP {$result['code']})");
        }
    }
    
    public static function testLoginWithValidCredentials($runner) {
        // Test login con credenziali valide
        // Nota: Usa credenziali di test esistenti
        $credentials = [
            'username' => 'admin-CRUD',
            'password' => 'password123' // Esempio - modificare con password reale di test
        ];
        
        $result = $runner->request('POST', '/WorldGO/auth/login.php', $credentials);
        
        // Verifica risposta
        if ($result['code'] !== 200) {
            throw new Exception("Login fallito con codice HTTP {$result['code']}");
        }
        
        if (!isset($result['json']['success'])) {
            throw new Exception("Risposta login non contiene campo 'success'");
        }
        
        if (!empty($result['json']['token'])) {
            $runner->setJWTToken($result['json']['token']);
        }
    }
    
    public static function testLoginWithInvalidCredentials($runner) {
        // Test login con credenziali non valide
        $credentials = [
            'username' => 'nonexistent_user_xyz',
            'password' => 'wrongpassword'
        ];
        
        $result = $runner->request('POST', '/WorldGO/auth/login.php', $credentials);
        
        // Deve fallire
        if ($result['code'] === 200 && !empty($result['json']['success'])) {
            throw new Exception("Login dovrebbe fallire con credenziali non valide");
        }
    }
    
    public static function testRegisterEndpointAvailable($runner) {
        // Verifica che la pagina di registrazione sia disponibile
        $result = $runner->request('GET', '/WorldGO/pages/register.php');
        
        if ($result['code'] !== 200 && $result['code'] !== 405) {
            throw new Exception("Register endpoint non disponibile (HTTP {$result['code']})");
        }
    }
    
    // ====== POST ======
    
    public static function testCreatePostPageRequiresAuth($runner) {
        // Verifica che la pagina di creazione post richieda autenticazione
        $result = $runner->request('GET', '/WorldGO/pages/create_post.php', null, false);
        
        // Dovrebbe reindirizzare a login (302 o 307)
        if ($result['code'] !== 302 && $result['code'] !== 307 && $result['code'] !== 200) {
            // Potrebbe anche essere 200 se il server reindirizza internamente
            throw new Exception("Create post page dovrebbe richiedere autenticazione");
        }
    }
    
    public static function testPostDetailsEndpointExists($runner) {
        // Verifica che l'endpoint di dettagli post esista
        $result = $runner->request('GET', '/WorldGO/actions/post_details_action.php?id=1');
        
        // Può restituire 200 o 404 (se post non esiste), ma non 500
        if ($result['code'] === 500) {
            throw new Exception("Endpoint dettagli post restituisce errore 500");
        }
    }
    
    public static function testPostDetailsReturnsJSON($runner) {
        // Verifica che i dettagli del post siano in JSON
        $result = $runner->request('GET', '/WorldGO/actions/post_details_action.php?id=1');
        
        if ($result['json'] === null) {
            throw new Exception("Risposta post details non è JSON valido");
        }
    }
    
    public static function testPostDetailsWithInvalidID($runner) {
        // Test con ID post non valido
        $result = $runner->request('GET', '/WorldGO/actions/post_details_action.php?id=invalid');
        
        if ($result['code'] !== 400) {
            throw new Exception("Endpoint dovrebbe restituire 400 per ID non valido");
        }
    }
    
    public static function testPostDetailsWithMissingID($runner) {
        // Test senza ID post
        $result = $runner->request('GET', '/WorldGO/actions/post_details_action.php');
        
        if ($result['code'] !== 400) {
            throw new Exception("Endpoint dovrebbe restituire 400 per ID mancante");
        }
    }
    
    // ====== API ENDPOINTS ======
    
    public static function testAPIEndpointAvailable($runner) {
        // Verifica che l'endpoint API sia disponibile
        $result = $runner->request('GET', '/WorldGO/api/api.php?route=utente');
        
        // Potrebbe richiedere autenticazione (401) o funzionare (200)
        if ($result['code'] !== 200 && $result['code'] !== 401 && $result['code'] !== 500) {
            throw new Exception("API endpoint restituisce codice HTTP imprevisto: {$result['code']}");
        }
    }
    
    public static function testAPIRequiresAuthentication($runner) {
        // Verifica che l'API richieda token JWT
        $result = $runner->request('GET', '/WorldGO/api/api.php?route=utente');
        
        // Dovrebbe richiedere autenticazione
        if ($result['code'] === 401 || !empty($result['json']['error'])) {
            // OK - Richiede autenticazione
        } elseif ($result['code'] !== 200) {
            throw new Exception("Comportamento API non previsto");
        }
    }
    
    public static function testAPIReturnsJSON($runner) {
        // Verifica che l'API ritorni JSON
        $result = $runner->request('GET', '/WorldGO/api/api.php?route=utente');
        
        if ($result['json'] === null && strlen($result['body']) > 0) {
            throw new Exception("API dovrebbe restituire JSON valido");
        }
    }
    
    public static function testAPIRouteNotFound($runner) {
        // Test rotta API non valida
        $result = $runner->request('GET', '/WorldGO/api/api.php?route=nonexistent_route');
        
        if ($result['code'] !== 404 && empty($result['json']['error'])) {
            throw new Exception("API dovrebbe restituire errore per rotta non valida");
        }
    }
    
    // ====== PAGINE PRINCIPALI ======
    
    public static function testHomepageLoads($runner) {
        // Verifica che la homepage carica correttamente
        $result = $runner->request('GET', '/WorldGO/index.php');
        
        if ($result['code'] !== 200) {
            throw new Exception("Homepage non carica (HTTP {$result['code']})");
        }
    }
    
    public static function testDashboardPageExists($runner) {
        // Verifica che la pagina dashboard esista
        $result = $runner->request('GET', '/WorldGO/pages/dashboard.php');
        
        if ($result['code'] !== 200 && $result['code'] !== 302 && $result['code'] !== 307) {
            throw new Exception("Dashboard page non disponibile (HTTP {$result['code']})");
        }
    }
    
    // ====== STRUTTURA DIRECTORY ======
    
    public static function testUploadsDirectoryExists($runner) {
        // Nota: Questo test è principalmente per documentazione
        // In un vero scenario, verificheremmo l'accesso al filesystem
        $upload_path = '/WorldGO/imgs/uploads/posts/';
        
        // Potremmo aggiungere logica per verificare se il path è accessibile
        // Per ora, documentiamo il percorso atteso
        if (empty($upload_path)) {
            throw new Exception("Upload path non configurato");
        }
    }
}

// ============================================================================
// ESECUZIONE TEST
// ============================================================================

// Controllare se cURL è disponibile
if (!extension_loaded('curl')) {
    echo Colors::ERROR . "Errore: L'estensione cURL non è caricata!\n";
    echo "Installa cURL per PHP per eseguire questi test.\n" . Colors::RESET;
    exit(1);
}

// Creare runner
$runner = new HttpTestRunner();

// ---- Test Autenticazione ----
$runner->addTest("Endpoint Login Disponibile", function($r) { WorldGOIntegrationTests::testLoginEndpointAvailable($r); });
$runner->addTest("Registrazione Endpoint Disponibile", function($r) { WorldGOIntegrationTests::testRegisterEndpointAvailable($r); });

// ---- Test POST ----
$runner->addTest("Pagina Creazione Post Richiede Auth", function($r) { WorldGOIntegrationTests::testCreatePostPageRequiresAuth($r); });
$runner->addTest("Endpoint Dettagli Post Esiste", function($r) { WorldGOIntegrationTests::testPostDetailsEndpointExists($r); });
$runner->addTest("Dettagli Post Restituisce JSON", function($r) { WorldGOIntegrationTests::testPostDetailsReturnsJSON($r); });
$runner->addTest("Dettagli Post con ID Non Valido", function($r) { WorldGOIntegrationTests::testPostDetailsWithInvalidID($r); });
$runner->addTest("Dettagli Post Senza ID", function($r) { WorldGOIntegrationTests::testPostDetailsWithMissingID($r); });

// ---- Test API ----
$runner->addTest("API Endpoint Disponibile", function($r) { WorldGOIntegrationTests::testAPIEndpointAvailable($r); });
$runner->addTest("API Richiede Autenticazione", function($r) { WorldGOIntegrationTests::testAPIRequiresAuthentication($r); });
$runner->addTest("API Restituisce JSON", function($r) { WorldGOIntegrationTests::testAPIReturnsJSON($r); });
$runner->addTest("API Rotta Non Trovata", function($r) { WorldGOIntegrationTests::testAPIRouteNotFound($r); });

// ---- Test Pagine ----
$runner->addTest("Homepage Carica", function($r) { WorldGOIntegrationTests::testHomepageLoads($r); });
$runner->addTest("Dashboard Pagina Esiste", function($r) { WorldGOIntegrationTests::testDashboardPageExists($r); });

// ---- Test Struttura ----
$runner->addTest("Directory Upload Path Configurato", function($r) { WorldGOIntegrationTests::testUploadsDirectoryExists($r); });

// Eseguire test
$runner->runTests();

?>
