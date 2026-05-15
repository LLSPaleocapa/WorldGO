# 👨‍💻 WorldGO - Guida allo Sviluppatore

*Manuale tecnico per sviluppatori che desiderano contribuire o estendere WorldGO*

---

## 📋 Indice

1. [Setup dell'Ambiente di Sviluppo](#setup-ambiente)
2. [Struttura del Progetto](#struttura-progetto)
3. [Stack Tecnologico](#stack-tecnologico)
4. [Architettura](#architettura)
5. [Convenzioni di Codice](#convenzioni)
6. [Come Aggiungere Nuove Funzionalità](#aggiungere-funzionalità)
7. [Database Schema](#database-schema)
8. [API Endpoints](#api-endpoints)
9. [Autenticazione e Autorizzazione](#autenticazione)
10. [Debug e Logging](#debug)
11. [Performance Optimization](#performance)
12. [Deployment](#deployment)

---

## 🛠️ Setup dell'Ambiente di Sviluppo {#setup-ambiente}

### Prerequisiti

```bash
- PHP 8.0+ 
- MySQL 5.7+ o MariaDB
- Composer
- Git
- Browser moderno (Chrome/Firefox/Safari)
```

### Installazione Locale

```bash
# 1. Clonare il repository
git clone https://github.com/LLSPaleocapa/WorldGO.git
cd WorldGO

# 2. Installare dipendenze Composer
composer install

# 3. Configurare database
# Editare WorldGO/config/config.php con credenziali MySQL

# 4. Importare schema database
mysql -u username -p database_name < my_lilisheng5ie.sql

# 5. Avviare server locale
cd WorldGO
php -S localhost:8000

# 6. Visitare http://localhost:8000
```

### Struttura Directory di Sviluppo

```
WorldGO/
├── WorldGO/               # Root dell'applicazione
│   ├── config/            # Configurazioni database e app
│   ├── auth/              # File autenticazione
│   ├── pages/             # Pagine HTML/PHP
│   ├── actions/           # Backend logic per azioni
│   ├── api/               # Endpoints API
│   ├── css/               # Stylesheet
│   ├── js/                # JavaScript
│   ├── imgs/              # Immagini e upload
│   └── vendor/            # Dipendenze Composer (auto-generated)
├── tests.php              # Unit tests
├── integration_tests.php  # Integration tests
├── MANUALE_UTENTE.md     # Manual utente
├── TEST_DOCUMENTATION.md # Documentazione test
└── DEVELOPER_GUIDE.md    # Questa guida
```

---

## 🏗️ Struttura del Progetto {#struttura-progetto}

### Livello Presentazione

**File:** `pages/*.php`
- `login.php` - Pagina login
- `register.php` - Pagina registrazione
- `dashboard.php` - Dashboard utente
- `create_post.php` - Creazione post
- `post_details.php` - Dettagli post
- `index.php` - Homepage

### Livello Business Logic

**File:** `actions/*.php`
- `create_post_action.php` - Logica creazione post
- `post_details_action.php` - Logica recupero post

### Livello Autenticazione

**File:** `auth/*.php`
- `login.php` - Endpoint login (JSON API)
- `register.php` - Endpoint registrazione
- `logout.php` - Endpoint logout

### Livello API

**File:** `api/api.php`
- Endpoint centrale per operazioni API
- Routing basato su parametro `route`

### Configurazione

**File:** `config/config.php`
- Credenziali database
- Chiave segreta JWT

---

## 💻 Stack Tecnologico {#stack-tecnologico}

### Backend
- **Linguaggio:** PHP 8.x
- **Database:** MySQL/MariaDB
- **Autenticazione:** JWT (Firebase/JWT)
- **Password Hashing:** bcrypt (PASSWORD_DEFAULT)

### Frontend
- **HTML:** Semantico
- **CSS:** Bootstrap 5.3.2
- **JavaScript:** Vanilla (nessun framework)
- **HTTP Requests:** Fetch API

### Dipendenze (Composer)

```json
{
  "require": {
    "firebase/php-jwt": "^6.0"
  }
}
```

---

## 🎯 Architettura {#architettura}

### Pattern Utilizzati

#### 1. MVC Semplificato
```
Request → Controller (actions/*.php) → Model (DB) → View (pages/*.php)
```

#### 2. JWT per Stateless Auth
```
Client → POST login.php → Server verifica & crea JWT
Client → Richieste successive con JWT in header/cookie
```

#### 3. Prepared Statements per SQL Injection Prevention
```php
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
```

### Flusso Autenticazione

```
┌─────────────────────────────────────────────────┐
│  1. User compila form login                      │
│  2. JavaScript invia richiesta POST a login.php  │
│  3. login.php valida credenziali DB              │
│  4. Se OK: crea JWT con user_id + username       │
│  5. JWT inviato in Set-Cookie (HttpOnly)         │
│  6. Client include JWT in richieste successive   │
│  7. Server valida JWT prima di operazioni        │
└─────────────────────────────────────────────────┘
```

### Flusso Creazione Post

```
┌──────────────────────────────────────────────────┐
│  1. User accede create_post.php                  │
│  2. Verifica JWT token (richiede autenticazione) │
│  3. User compila form (titolo, descrizione, img) │
│  4. Form inviato a create_post_action.php        │
│  5. Validazione dati lato server                 │
│  6. Se file immagine: upload e storage           │
│  7. INSERT post nel database                     │
│  8. Redirect a homepage con conferma             │
└──────────────────────────────────────────────────┘
```

---

## 📝 Convenzioni di Codice {#convenzioni}

### Naming Conventions

**PHP Classes (non usate attualmente)**
```php
class UserManager { }
class PostService { }
```

**PHP Functions**
```php
function validateUserInput() { }
function sanitizePostDescription() { }
```

**PHP Variables**
```php
$user_id = 5;           // snake_case
$postTitle = "Roma";    // Evitare CamelCase per PHP
$_POST, $_GET, $_FILES  // Globali in CAPS
```

**Database Tables (Italian plurals)**
```
WorldGO_users
WorldGO_posts
WorldGO_likes
WorldGO_commenti
WorldGO_roles
WorldGO_permissions
WorldGO_user_roles
WorldGO_role_permissions
```

**Database Columns**
```
id (primary key)
id_utente (foreign key)
titolo (Italian for title)
data_pubblicazione (datetime format)
numero_likes (integer)
```

### Code Style

**Indentazione:** 4 spazi

```php
// ✓ Corretto
if ($user_id) {
    $sql = "SELECT * FROM WorldGO_users";
    $stmt = $pdo->prepare($sql);
}

// ✗ Sbagliato
if ($user_id) {
$sql = "SELECT * FROM WorldGO_users";
}
```

**Documentazione:**

```php
/**
 * Recupera un post dal database
 * 
 * @param int $post_id ID del post
 * @return array|null Post data o null se non trovato
 * @throws PDOException Se errore database
 */
function getPost($post_id) {
    // Implementazione
}
```

---

## 🚀 Come Aggiungere Nuove Funzionalità {#aggiungere-funzionalità}

### Processo Generale

#### 1. Definisci i Requisiti
```
Funzionalità: "Permettere agli utenti di salvare post"
- User può cliccare "Salva" su un post
- Post salvati visibili in dashboard
- User può rimuovere un post dalla lista salvati
```

#### 2. Progetta il Database
```sql
ALTER TABLE WorldGO_users ADD TABLE WorldGO_saved_posts (
  id_utente INT NOT NULL,
  id_post BIGINT NOT NULL,
  data_salvataggio DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id_utente, id_post),
  FOREIGN KEY (id_utente) REFERENCES WorldGO_users(id),
  FOREIGN KEY (id_post) REFERENCES WorldGO_posts(id)
);
```

#### 3. Crea l'Endpoint Backend
```php
// File: actions/save_post_action.php
require_once '../vendor/autoload.php';
require_once '../config/config.php';

header('Content-Type: application/json');

$token = $_COOKIE['jwt'] ?? '';
try {
    $decoded = JWT::decode($token, new Key(SECRET_KEY, 'HS256'));
    $user_id = $decoded->user_id;
} catch (Exception $e) {
    http_response_code(401);
    echo json_encode(['error' => 'Non autorizzato']);
    exit;
}

$post_id = $_POST['post_id'] ?? 0;

// Validazione
if (!$post_id) throw new Exception('Post ID mancante');

// Insert nel DB
$sql = "INSERT INTO WorldGO_saved_posts (id_utente, id_post) VALUES (?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id, $post_id]);

echo json_encode(['success' => true, 'message' => 'Post salvato']);
```

#### 4. Crea il Frontend
```html
<!-- In post_details.php -->
<button id="save-btn" onclick="savePost(<?php echo $post_id; ?>)">
    💾 Salva
</button>

<script>
function savePost(postId) {
    const formData = new FormData();
    formData.append('post_id', postId);
    
    fetch('../actions/save_post_action.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert('Post salvato!');
        }
    });
}
</script>
```

#### 5. Aggiungi Test
```php
public static function testSavePost() {
    // Simulare salvataggio post
    $user_id = 1;
    $post_id = 1;
    
    Assert::assertTrue($user_id > 0, "User ID valido");
    Assert::assertTrue($post_id > 0, "Post ID valido");
}

$runner->addTest("Salva Post", function() { 
    WorldGOTests::testSavePost(); 
});
```

---

## 🗄️ Database Schema {#database-schema}

### Tabella: WorldGO_users

```sql
CREATE TABLE WorldGO_users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(30) UNIQUE NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    foto_profilo VARCHAR(255),
    bio TEXT,
    data_creazione DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

**Campi:**
- `id` - Identificativo univoco
- `username` - Nome utente (max 30 char, unico)
- `email` - Email di contatto
- `password` - Hash bcrypt della password
- `foto_profilo` - URL foto profilo (opzionale)
- `bio` - Biografia utente (opzionale)

### Tabella: WorldGO_posts

```sql
CREATE TABLE WorldGO_posts (
    id BIGINT PRIMARY KEY,
    id_utente INT NOT NULL,
    titolo VARCHAR(30) NOT NULL,
    descrizione TEXT NOT NULL,
    tipo_media INT,
    url_media VARCHAR(255),
    data_pubblicazione DATETIME,
    FOREIGN KEY (id_utente) REFERENCES WorldGO_users(id)
);
```

### Tabella: WorldGO_likes

```sql
CREATE TABLE WorldGO_likes (
    id_utente INT NOT NULL,
    id_post BIGINT NOT NULL,
    PRIMARY KEY (id_utente, id_post),
    FOREIGN KEY (id_utente) REFERENCES WorldGO_users(id),
    FOREIGN KEY (id_post) REFERENCES WorldGO_posts(id)
);
```

### Tabella: WorldGO_commenti

```sql
CREATE TABLE WorldGO_commenti (
    id VARCHAR(30) PRIMARY KEY,
    id_utente INT NOT NULL,
    id_post BIGINT NOT NULL,
    testo TEXT NOT NULL,
    data_pubblicazione DATETIME,
    FOREIGN KEY (id_utente) REFERENCES WorldGO_users(id),
    FOREIGN KEY (id_post) REFERENCES WorldGO_posts(id)
);
```

### Tabella: WorldGO_roles

```sql
CREATE TABLE WorldGO_roles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    role VARCHAR(50) UNIQUE NOT NULL
);
```

**Ruoli Predefiniti:**
- `admin` - Amministratore del sistema
- `CRUD` - Utente con diritti di pubblicazione
- `user` - Utente standard

### Tabella: WorldGO_permissions

```sql
CREATE TABLE WorldGO_permissions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    permission VARCHAR(100) UNIQUE NOT NULL
);
```

**Permessi Predefiniti:**
- `pubblica_post` - Può pubblicare nuovi post
- `commento` - Può commentare
- `CRUD_permissions` - Può gestire permessi

---

## 🔌 API Endpoints {#api-endpoints}

### Base URL
```
http://localhost:8000/WorldGO/api/api.php?route=ROUTE_NAME
```

### Autenticazione

**Tutti gli endpoint richiedono JWT token nel cookie o header Authorization**

```php
// Header Authorization
Authorization: Bearer YOUR_JWT_TOKEN

// Oppure Cookie (auto-impostato da login.php)
Cookie: jwt=YOUR_JWT_TOKEN
```

### Endpoint Disponibili

#### 1. GET /api/api.php?route=utente
Recupera dati utente corrente

**Risposta:**
```json
{
  "username": "traveler123",
  "user_id": 1
}
```

#### 2. GET /api/api.php?route=visualizzaRuolo
Recupera ruoli e permessi utente

**Risposta:**
```json
{
  "username": "admin-CRUD",
  "roles": {
    "CRUD": ["pubblica_post", "commento"],
    "admin": ["pubblica_post", "commento"]
  }
}
```

#### 3. GET /api/api.php?route=logout
Logout utente (rimuove JWT cookie)

**Risposta:**
```json
{
  "message": "Logout lato client: cookie JWT eliminato"
}
```

### Errori API

```json
// 401 - Non autorizzato
{
  "error": "Token non valido"
}

// 404 - Risorsa non trovata
{
  "error": "Risorsa non trovata"
}

// 500 - Errore server
{
  "error": "Errore nel recupero dei dati: ..."
}
```

---

## 🔐 Autenticazione e Autorizzazione {#autenticazione}

### JWT Token Structure

```
Header: {
  "alg": "HS256",
  "typ": "JWT"
}

Payload: {
  "user_id": 1,
  "username": "traveler123",
  "iat": 1715700000,
  "exp": 1715700600
}

Signature: HMACSHA256(base64UrlEncode(header) + "." + base64UrlEncode(payload), SECRET_KEY)
```

### Token Validation

```php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$token = $_COOKIE['jwt'] ?? '';

try {
    $decoded = JWT::decode($token, new Key(SECRET_KEY, 'HS256'));
    $user_id = $decoded->user_id;
} catch (Exception $e) {
    // Token invalido o scaduto
    http_response_code(401);
    echo json_encode(['error' => 'Non autorizzato']);
    exit;
}
```

### Role-Based Access Control (RBAC)

```php
// Verificare se utente ha permesso
$sql = "
    SELECT COUNT(*) as count FROM WorldGO_user_roles ur
    JOIN WorldGO_role_permissions rp ON ur.role_id = rp.role_id
    JOIN WorldGO_permissions p ON rp.permission_id = p.id
    WHERE ur.user_id = ? AND p.permission = ?
";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id, 'pubblica_post']);
$hasPermission = $stmt->fetch()['count'] > 0;

if (!$hasPermission) {
    throw new Exception('Permesso negato');
}
```

---

## 🐛 Debug e Logging {#debug}

### Abilitare Debug Mode

```php
// In config.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
```

### Log Errori Database

```php
try {
    // operazioni DB
} catch (PDOException $e) {
    error_log("DB Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Database error']);
}
```

### Debug JavaScript

```javascript
// Abilitare console logging
console.log('Data:', data);
console.error('Error:', error);

// Utilizzare debugger browser
debugger; // Pausa esecuzione (F12)
```

### Logger Semplice

```php
function logEvent($message, $level = 'INFO') {
    $timestamp = date('Y-m-d H:i:s');
    $logEntry = "[$timestamp] [$level] $message\n";
    error_log($logEntry, 3, '/var/log/worldgo.log');
}

// Utilizzo
logEvent("Post creato da user_id=1", "INFO");
logEvent("Login fallito per user=admin", "WARNING");
```

---

## ⚡ Performance Optimization {#performance}

### Database

**1. Indexing**
```sql
CREATE INDEX idx_posts_user ON WorldGO_posts(id_utente);
CREATE INDEX idx_likes_post ON WorldGO_likes(id_post);
CREATE INDEX idx_users_username ON WorldGO_users(username);
```

**2. Query Optimization**
```php
// ✗ Cattivo - N+1 queries
foreach ($posts as $post) {
    $user = $pdo->query("SELECT * FROM WorldGO_users WHERE id = " . $post['id_utente']);
}

// ✓ Buono - Single query with JOIN
$sql = "SELECT p.*, u.username FROM WorldGO_posts p 
        JOIN WorldGO_users u ON p.id_utente = u.id";
```

### Frontend

**1. Lazy Loading Immagini**
```html
<img src="placeholder.jpg" data-src="actual-image.jpg" loading="lazy">
```

**2. Minificazione Assets**
```bash
# Installare minifier
npm install -g minify

# Minificare CSS
minify css/index.css > css/index.min.css

# Minificare JS
minify js/index.js > js/index.min.js
```

**3. Caching**
```php
// HTTP Caching headers
header('Cache-Control: max-age=3600, public');
header('ETag: ' . md5($content));
```

---

## 🚀 Deployment {#deployment}

### Pre-Deployment Checklist

```bash
# 1. Eseguire test
php tests.php
php integration_tests.php

# 2. Verificare variabili ambiente
- SECRET_KEY configurato
- Database credentials corrette
- HTTPS abilitato

# 3. Pulizia
- Rimuovere file di debug
- Disabilitare display_errors
- Cache cleared

# 4. Backup database
mysqldump -u user -p database > backup_$(date +%Y%m%d).sql
```

### Deployment su Server Remoto

```bash
# 1. SSH al server
ssh user@server.com

# 2. Clone repository
cd /var/www
git clone https://github.com/LLSPaleocapa/WorldGO.git

# 3. Install dependencies
cd WorldGO
composer install --no-dev

# 4. Database migration
mysql -u user -p database < my_lilisheng5ie.sql

# 5. Impostare permessi
chmod 755 WorldGO/imgs/uploads/posts/
chmod 644 WorldGO/config/config.php

# 6. Configurare web server (Nginx)
# Vedi nginx.conf nella root
```

### Environment Variables

```php
// Usare .env file in produzione
// Esempio: WorldGO/.env
DATABASE_HOST=localhost
DATABASE_USER=production_user
DATABASE_PASS=secure_password
JWT_SECRET=very_long_random_string
APP_DEBUG=false
```

---

## 📚 Risorse Esterne

- **JWT:** https://jwt.io/
- **PHP Security:** https://www.php.net/manual/en/security.php
- **OWASP:** https://owasp.org/
- **Bootstrap 5:** https://getbootstrap.com/
- **Fetch API:** https://developer.mozilla.org/en-US/docs/Web/API/Fetch_API

---

## 📞 Contatti

**Autore:** Li Lisheng  
**Scuola:** ITIS P. Paleocapa  
**Anno:** 2025/2026  
**Repository:** https://github.com/LLSPaleocapa/WorldGO

---

**Ultimo aggiornamento:** Maggio 2026  
**Versione Guida:** 1.0  
**Status:** ✅ Completato
