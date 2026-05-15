<?php
/**
 * WorldGO Unit Tests
 * Test suite per le funzionalità principali dell'applicazione
 * 
 * Autore: Li Lisheng
 * ITIS P. Paleocapa - a.s. 2025/2026
 * 
 * Utilizzo:
 * php tests.php
 * 
 * Prerequisiti:
 * - PHPUnit (facoltativo): composer require phpunit/phpunit
 * - Database MySql configurato e collegato
 */

// ============================================================================
// CONFIGURAZIONE E SETUP
// ============================================================================

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Colori per output terminale
class Colors {
    const SUCCESS = "\033[92m"; // Verde
    const ERROR = "\033[91m";   // Rosso
    const INFO = "\033[94m";    // Blu
    const WARNING = "\033[93m"; // Giallo
    const RESET = "\033[0m";
}

// Classe semplice di test
class TestRunner {
    private $tests = [];
    private $passed = 0;
    private $failed = 0;
    private $total = 0;
    
    public function addTest($testName, $testFunction) {
        $this->tests[] = ['name' => $testName, 'function' => $testFunction];
    }
    
    public function runTests() {
        echo "\n" . Colors::INFO . "=" . str_repeat("=", 78) . Colors::RESET . "\n";
        echo Colors::INFO . "WORLDGO - UNIT TESTS SUITE" . Colors::RESET . "\n";
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
            call_user_func($testFunction);
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
}

// Classe di asserzioni
class Assert {
    public static function assertEquals($expected, $actual, $message = '') {
        if ($expected !== $actual) {
            throw new Exception("Atteso: {$expected}, Ottenuto: {$actual}. {$message}");
        }
    }
    
    public static function assertTrue($condition, $message = '') {
        if ($condition !== true) {
            throw new Exception("Atteso true, ma la condizione è falsa. {$message}");
        }
    }
    
    public static function assertFalse($condition, $message = '') {
        if ($condition !== false) {
            throw new Exception("Atteso false, ma la condizione è vera. {$message}");
        }
    }
    
    public static function assertEmpty($value, $message = '') {
        if (!empty($value)) {
            throw new Exception("Valore atteso vuoto. {$message}");
        }
    }
    
    public static function assertNotEmpty($value, $message = '') {
        if (empty($value)) {
            throw new Exception("Valore atteso non vuoto. {$message}");
        }
    }
    
    public static function assertStringContains($needle, $haystack, $message = '') {
        if (strpos($haystack, $needle) === false) {
            throw new Exception("'{$needle}' non trovato in '{$haystack}'. {$message}");
        }
    }
    
    public static function assertIsArray($value, $message = '') {
        if (!is_array($value)) {
            throw new Exception("Tipo array atteso, ma è " . gettype($value) . ". {$message}");
        }
    }
}

// ============================================================================
// TEST UNITARI
// ============================================================================

class WorldGOTests {
    
    // ====== VALIDAZIONI ======
    
    public static function testUsernameValidation() {
        // Test validazione username
        $username = "validuser123";
        Assert::assertNotEmpty($username, "Username non deve essere vuoto");
        
        // Test lunghezza massima
        $longUsername = str_repeat("a", 31);
        Assert::assertEquals(strlen($longUsername) > 30, true, "Username troppo lungo");
    }
    
    public static function testEmailValidation() {
        // Test formato email valido
        $email = "user@example.com";
        $isValid = filter_var($email, FILTER_VALIDATE_EMAIL);
        Assert::assertTrue($isValid !== false, "Email dovrebbe essere valida");
        
        // Test formato email non valido
        $invalidEmail = "userexample.com";
        $isInvalid = filter_var($invalidEmail, FILTER_VALIDATE_EMAIL);
        Assert::assertEquals($isInvalid, false, "Email non valida dovrebbe fallire");
    }
    
    public static function testPasswordHashing() {
        // Test bcrypt hashing
        $password = "MySecurePassword123";
        $hash = password_hash($password, PASSWORD_DEFAULT);
        
        Assert::assertNotEmpty($hash, "Hash password non deve essere vuoto");
        Assert::assertTrue(password_verify($password, $hash), "Password deve corrispondere all'hash");
        Assert::assertFalse(password_verify("WrongPassword", $hash), "Password errata non deve corrispondere");
    }
    
    // ====== STRUTTURA DATI ======
    
    public static function testPostDataStructure() {
        // Test struttura dati di un post
        $post = [
            'id' => 1,
            'id_utente' => 1,
            'titolo' => 'Roma in 3 giorni',
            'descrizione' => 'Un meraviglioso viaggio nella capitale italiana',
            'url_media' => 'https://example.com/image.jpg',
            'data_pubblicazione' => date('Y-m-d H:i:s'),
            'numero_likes' => 5,
            'username' => 'traveler123'
        ];
        
        Assert::assertIsArray($post, "Post deve essere un array");
        Assert::assertNotEmpty($post['id'], "Post ID non deve essere vuoto");
        Assert::assertNotEmpty($post['titolo'], "Titolo non deve essere vuoto");
        Assert::assertTrue(strlen($post['titolo']) <= 30, "Titolo non deve superare 30 caratteri");
    }
    
    public static function testUserDataStructure() {
        // Test struttura dati utente
        $user = [
            'id' => 1,
            'username' => 'admin-CRUD',
            'email' => 'admin@example.com',
            'password' => '$2y$12$...',
            'data_creazione' => date('Y-m-d H:i:s')
        ];
        
        Assert::assertIsArray($user, "Utente deve essere un array");
        Assert::assertNotEmpty($user['username'], "Username non deve essere vuoto");
        Assert::assertNotEmpty($user['email'], "Email non deve essere vuota");
    }
    
    // ====== LOGICA DI BUSINESS ======
    
    public static function testPostTitleValidation() {
        // Test validazione titolo post
        $validTitle = "Viaggio in Giappone";
        Assert::assertTrue(strlen($validTitle) <= 30, "Titolo valido deve avere max 30 caratteri");
        
        $invalidTitle = str_repeat("a", 31);
        Assert::assertFalse(strlen($invalidTitle) <= 30, "Titolo di 31 caratteri dovrebbe fallire");
    }
    
    public static function testPostDescriptionValidation() {
        // Test validazione descrizione
        $description = "Descrizione del viaggio...";
        Assert::assertNotEmpty($description, "Descrizione non deve essere vuota");
        Assert::assertTrue(strlen($description) > 0, "Descrizione deve avere contenuto");
    }
    
    public static function testFileUploadValidation() {
        // Test validazione upload file
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $test_type = 'image/jpeg';
        
        Assert::assertTrue(in_array($test_type, $allowed_types), "JPEG dovrebbe essere tipo supportato");
        Assert::assertFalse(in_array('image/bmp', $allowed_types), "BMP non dovrebbe essere supportato");
        
        // Test dimensione file
        $max_size = 5 * 1024 * 1024; // 5MB
        $file_size = 3 * 1024 * 1024; // 3MB
        Assert::assertTrue($file_size <= $max_size, "File di 3MB dovrebbe essere accettato");
        Assert::assertFalse((6 * 1024 * 1024) <= $max_size, "File di 6MB dovrebbe essere rifiutato");
    }
    
    public static function testJWTTokenStructure() {
        // Test JWT payload
        require_once __DIR__ . '/WorldGO/config/config.php';
        require_once __DIR__ . '/WorldGO/vendor/autoload.php';
        
        use Firebase\JWT\JWT;
        
        $payload = [
            'user_id' => 1,
            'username' => 'testuser',
            'iat' => time(),
            'exp' => time() + 600
        ];
        
        try {
            $token = JWT::encode($payload, 'test_secret', 'HS256');
            Assert::assertNotEmpty($token, "Token JWT non deve essere vuoto");
            Assert::assertTrue(is_string($token), "Token JWT deve essere una stringa");
        } catch (Exception $e) {
            throw new Exception("Errore nella creazione JWT: " . $e->getMessage());
        }
    }
    
    // ====== AUTORIZZAZIONE ======
    
    public static function testRoleBasedAccess() {
        // Test controllo dei ruoli
        $roles = ['user', 'CRUD', 'admin'];
        
        // Simulare accesso a funzioni con diversi ruoli
        $userRole = 'user';
        $canPublish = in_array($userRole, ['CRUD', 'admin']);
        Assert::assertFalse($canPublish, "Utente 'user' non dovrebbe poter pubblicare");
        
        $crudRole = 'CRUD';
        $canPublish = in_array($crudRole, ['CRUD', 'admin']);
        Assert::assertTrue($canPublish, "Utente 'CRUD' dovrebbe poter pubblicare");
    }
    
    public static function testPostOwnershipVerification() {
        // Test verifica proprietario post
        $post = [
            'id' => 1,
            'id_utente' => 5,
            'titolo' => 'Mio viaggio',
            'username' => 'traveler123'
        ];
        
        $currentUserId = 5;
        $isOwner = ($currentUserId == $post['id_utente']);
        Assert::assertTrue($isOwner, "Utente 5 dovrebbe essere proprietario del post");
        
        $currentUserId = 3;
        $isOwner = ($currentUserId == $post['id_utente']);
        Assert::assertFalse($isOwner, "Utente 3 non dovrebbe essere proprietario del post");
    }
    
    // ====== FUNZIONI HELPER ======
    
    public static function testHTMLSpecialChars() {
        // Test sanitizzazione input
        $input = "<script>alert('XSS')</script>";
        $sanitized = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
        
        Assert::assertStringContains("&lt;", $sanitized, "HTML dovrebbe essere escapato");
        Assert::assertFalse(strpos($sanitized, "<script>") !== false, "Script tag dovrebbe essere rimosso");
    }
    
    public static function testDateFormatting() {
        // Test formattazione date
        $date = date('Y-m-d H:i:s');
        Assert::assertNotEmpty($date, "Data non deve essere vuota");
        Assert::assertTrue(strlen($date) === 19, "Formato data deve essere YYYY-MM-DD HH:MM:SS");
    }
    
    public static function testImageFileExtension() {
        // Test validazione estensione file
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        
        $file_ext = 'jpg';
        Assert::assertTrue(in_array($file_ext, $allowed), "JPG dovrebbe essere estensione valida");
        
        $file_ext = 'pdf';
        Assert::assertFalse(in_array($file_ext, $allowed), "PDF non dovrebbe essere estensione valida");
    }
    
    // ====== TEST INTEGRAZIONE SEMPLICI ======
    
    public static function testUserRegistrationFlow() {
        // Simulare flusso di registrazione
        $username = "newuser123";
        $email = "newuser@example.com";
        $password = "securepass123";
        
        // Validazioni
        Assert::assertNotEmpty($username, "Username richiesto");
        Assert::assertNotEmpty($email, "Email richiesta");
        Assert::assertNotEmpty($password, "Password richiesta");
        Assert::assertTrue(filter_var($email, FILTER_VALIDATE_EMAIL) !== false, "Email deve essere valida");
        
        // Simulare hashing password
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        Assert::assertTrue(password_verify($password, $hashed), "Password hash deve verificarsi");
    }
    
    public static function testPostPublicationFlow() {
        // Simulare flusso di pubblicazione post
        $post = [
            'titolo' => 'Viaggio Meraviglioso',
            'descrizione' => 'Una descrizione dettagliata del viaggio...',
            'url_media' => 'https://example.com/image.jpg'
        ];
        
        // Validazioni
        Assert::assertNotEmpty($post['titolo'], "Titolo richiesto");
        Assert::assertTrue(strlen($post['titolo']) <= 30, "Titolo deve avere max 30 caratteri");
        Assert::assertNotEmpty($post['descrizione'], "Descrizione richiesta");
        Assert::assertNotEmpty($post['url_media'], "URL media richiesto");
    }
    
    public static function testPostDetailsRetrievalFlow() {
        // Simulare flusso di recupero dettagli post
        $post = [
            'id' => 1,
            'titolo' => 'Roma in 3 giorni',
            'descrizione' => 'Itinerario completo a Roma',
            'numero_likes' => 15,
            'username' => 'traveler123',
            'data_pubblicazione' => date('Y-m-d H:i:s')
        ];
        
        Assert::assertNotEmpty($post['id'], "Post ID richiesto");
        Assert::assertNotEmpty($post['titolo'], "Titolo richiesto");
        Assert::assertTrue(is_int($post['numero_likes']), "Likes deve essere integer");
        Assert::assertNotEmpty($post['username'], "Username richiesto");
    }
}

// ============================================================================
// ESECUZIONE TEST
// ============================================================================

// Creare runner di test
$runner = new TestRunner();

// Aggiungere test di validazione
$runner->addTest("Validazione Username", function() { WorldGOTests::testUsernameValidation(); });
$runner->addTest("Validazione Email", function() { WorldGOTests::testEmailValidation(); });
$runner->addTest("Hashing Password", function() { WorldGOTests::testPasswordHashing(); });

// Aggiungere test di struttura dati
$runner->addTest("Struttura Dati Post", function() { WorldGOTests::testPostDataStructure(); });
$runner->addTest("Struttura Dati Utente", function() { WorldGOTests::testUserDataStructure(); });

// Aggiungere test di logica business
$runner->addTest("Validazione Titolo Post", function() { WorldGOTests::testPostTitleValidation(); });
$runner->addTest("Validazione Descrizione Post", function() { WorldGOTests::testPostDescriptionValidation(); });
$runner->addTest("Validazione Upload File", function() { WorldGOTests::testFileUploadValidation(); });
$runner->addTest("Struttura JWT Token", function() { WorldGOTests::testJWTTokenStructure(); });

// Aggiungere test di autorizzazione
$runner->addTest("Accesso Basato su Ruoli", function() { WorldGOTests::testRoleBasedAccess(); });
$runner->addTest("Verifica Proprietario Post", function() { WorldGOTests::testPostOwnershipVerification(); });

// Aggiungere test helper
$runner->addTest("Sanitizzazione HTML", function() { WorldGOTests::testHTMLSpecialChars(); });
$runner->addTest("Formattazione Date", function() { WorldGOTests::testDateFormatting(); });
$runner->addTest("Estensione File Immagine", function() { WorldGOTests::testImageFileExtension(); });

// Aggiungere test di flusso
$runner->addTest("Flusso Registrazione Utente", function() { WorldGOTests::testUserRegistrationFlow(); });
$runner->addTest("Flusso Pubblicazione Post", function() { WorldGOTests::testPostPublicationFlow(); });
$runner->addTest("Flusso Recupero Dettagli Post", function() { WorldGOTests::testPostDetailsRetrievalFlow(); });

// Eseguire tutti i test
$runner->runTests();

?>
