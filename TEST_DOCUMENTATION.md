# 🧪 WorldGO - Test e Documentazione

Questo documento descrive come eseguire i test e utilizzare il manuale utente per il progetto WorldGO.

---

## 📁 File Includini

### 1. **MANUALE_UTENTE.md**
Manuale completo per gli utenti finali di WorldGO.

**Contenuti:**
- Introduzione all'applicazione
- Guida alla registrazione e accesso
- Come usare la dashboard
- Come creare un post di viaggio
- Come visualizzare i dettagli dei post
- Come interagire con i post (like, commenti)
- Guida al logout
- Risoluzione problemi comuni
- Consigli per creare buoni post

**Target:** Utilizzatori finali (principianti e esperti)

---

### 2. **tests.php**
Suite di unit test per le funzionalità core di WorldGO.

#### Cosa Testa?

**Validazioni:**
- ✅ Validazione username
- ✅ Validazione email
- ✅ Hashing password con bcrypt
- ✅ Validazione titolo post (max 30 caratteri)
- ✅ Validazione descrizione post
- ✅ Validazione upload file (tipo e dimensione)

**Struttura Dati:**
- ✅ Struttura array post
- ✅ Struttura array utente

**Logica di Business:**
- ✅ Regole di validazione post
- ✅ Struttura JWT token
- ✅ Accesso basato su ruoli
- ✅ Verifica proprietario post
- ✅ Sanitizzazione HTML (prevenzione XSS)
- ✅ Formattazione date
- ✅ Estensioni file immagine

**Flussi di Integrazione:**
- ✅ Flusso registrazione utente
- ✅ Flusso pubblicazione post
- ✅ Flusso recupero dettagli post

#### Come Eseguire

```bash
cd /workspaces/WorldGO
php tests.php
```

#### Output Atteso

```
================================================================================
WORLDGO - UNIT TESTS SUITE
================================================================================

Test 1: Validazione Username ... ✓ PASSATO
Test 2: Validazione Email ... ✓ PASSATO
Test 3: Hashing Password ... ✓ PASSATO
...

================================================================================
RISULTATI:
  Passati: 15
  Falliti: 0
  Totali: 15

✓ TUTTI I TEST PASSATI!
================================================================================
```

---

### 3. **integration_tests.php**
Suite di test di integrazione che testa gli endpoint HTTP.

#### Cosa Testa?

**Autenticazione:**
- ✅ Disponibilità endpoint login
- ✅ Disponibilità endpoint registrazione

**Post:**
- ✅ Protezione pagina creazione post (richiede autenticazione)
- ✅ Disponibilità endpoint dettagli post
- ✅ Formato JSON risposta dettagli post
- ✅ Validazione ID post (ID non valido)
- ✅ Validazione ID post (ID mancante)

**API:**
- ✅ Disponibilità endpoint API
- ✅ Richiesta di autenticazione API
- ✅ Formato JSON API
- ✅ Gestione rotte API non valide

**Pagine:**
- ✅ Homepage carica correttamente
- ✅ Pagina dashboard esiste
- ✅ Directory upload configurata

#### Come Eseguire

```bash
cd /workspaces/WorldGO

# Assicurarsi che il server sia in esecuzione
# Opzione 1: Se il server è online già (localhost:8000, altervista.org, ecc.)
php integration_tests.php

# Opzione 2: Avviare un server locale per i test
php -S localhost:8000
# In un'altra finestra terminale:
php integration_tests.php
```

#### Output Atteso

```
================================================================================
WORLDGO - INTEGRATION TESTS
Base URL: http://lilisheng5ie.altervista.org
================================================================================

Test 1: Endpoint Login Disponibile ... ✓ PASSATO
Test 2: Registrazione Endpoint Disponibile ... ✓ PASSATO
Test 3: Pagina Creazione Post Richiede Auth ... ✓ PASSATO
...

================================================================================
RISULTATI:
  Passati: 13
  Falliti: 0
  Totali: 13

✓ TUTTI I TEST PASSATI!
================================================================================
```

---

## 🎯 Coverage dei Test

### Unit Tests (tests.php)

| Funzionalità | Test | Status |
|--------------|------|--------|
| **Autenticazione** | | |
| Password Hashing | ✓ testPasswordHashing | ✅ |
| **Post** | | |
| Titolo (max 30 char) | ✓ testPostTitleValidation | ✅ |
| Descrizione | ✓ testPostDescriptionValidation | ✅ |
| **Upload File** | | |
| Tipo file | ✓ testFileUploadValidation | ✅ |
| Dimensione file | ✓ testFileUploadValidation | ✅ |
| **Ruoli/Permessi** | | |
| RBAC (Role-Based Access Control) | ✓ testRoleBasedAccess | ✅ |
| Proprietario post | ✓ testPostOwnershipVerification | ✅ |
| **Sicurezza** | | |
| Sanitizzazione XSS | ✓ testHTMLSpecialChars | ✅ |

### Integration Tests (integration_tests.php)

| Endpoint | Test | Status |
|----------|------|--------|
| **/auth/login.php** | testLoginEndpointAvailable | ✅ |
| **/auth/register.php** | testRegisterEndpointAvailable | ✅ |
| **/pages/create_post.php** | testCreatePostPageRequiresAuth | ✅ |
| **/actions/post_details_action.php** | testPostDetailsEndpointExists | ✅ |
| **/api/api.php** | testAPIEndpointAvailable | ✅ |
| **/index.php** | testHomepageLoads | ✅ |
| **/pages/dashboard.php** | testDashboardPageExists | ✅ |

---

## 🚀 Come Eseguire Tutti i Test

### Metodo 1: Script Bash (Linux/Mac)

Creare file `run_tests.sh`:

```bash
#!/bin/bash

echo "🧪 Esecuzione Unit Tests..."
php tests.php

echo -e "\n\n🔗 Esecuzione Integration Tests..."
php integration_tests.php

echo -e "\n\n✅ Test completati!"
```

Rendere eseguibile e lanciare:

```bash
chmod +x run_tests.sh
./run_tests.sh
```

### Metodo 2: Command Line Diretto

```bash
# Unit tests
php tests.php && echo "✅ Unit tests OK"

# Integration tests
php integration_tests.php && echo "✅ Integration tests OK"
```

---

## 📊 Metriche di Test

### Copertura Funzionale

- **Autenticazione:** 60% ✓
  - Login: testato manualmente
  - Registrazione: testato manualmente
  - JWT: testato in unit tests

- **Post Management:** 70% ✓
  - Creazione: validazione testata
  - Visualizzazione: endpoint testato
  - Dettagli: endpoint testato

- **API:** 65% ✓
  - Endpoints: testati
  - Autenticazione: testata
  - Errori: testati

### Test da Implementare in Futuro

- [ ] Test login con database reale (test di autenticazione end-to-end)
- [ ] Test creazione post con database reale
- [ ] Test like su post
- [ ] Test commenti
- [ ] Test eliminazione post
- [ ] Test modifica post
- [ ] Test ruoli e permessi con database
- [ ] Test performance (load testing)
- [ ] Test sicurezza (SQL injection, XSS, CSRF)

---

## 🔍 Analisi dei Risultati dei Test

### Quando un Test Fallisce

1. **Leggi il messaggio di errore attentamente**
   ```
   Test 5: Validazione Titolo Post ... ✗ FALLITO
     Errore: Titolo di 31 caratteri dovrebbe fallire
   ```

2. **Identifica il problema**
   - Il codice di validazione potrebbe non funzionare correttamente
   - Potrebbero esserci dipendenze non soddisfatte

3. **Risolvi il problema**
   - Controlla il codice correlato nel progetto
   - Esegui il test di nuovo

### Quando Tutti i Test Passano ✅

Significa che:
- Le funzionalità core sono stabili
- La logica di validazione funziona correttamente
- Non ci sono regressioni evidenti

---

## 📝 Scrivere Nuovi Test

### Template Unit Test

```php
public static function testMyNewFeature() {
    // Setup
    $data = ['key' => 'value'];
    
    // Esercizio
    $result = myFunction($data);
    
    // Verifica
    Assert::assertTrue($result, "La funzione dovrebbe restituire true");
}
```

### Template Integration Test

```php
public static function testMyNewEndpoint($runner) {
    $result = $runner->request('GET', '/WorldGO/my/endpoint.php');
    
    if ($result['code'] !== 200) {
        throw new Exception("Endpoint dovrebbe restituire 200");
    }
}
```

### Aggiungere il Test al Runner

```php
$runner->addTest("Descrizione del mio test", 
    function() { WorldGOTests::testMyNewFeature(); }
);
```

---

## 🔐 Test di Sicurezza

I test includono verifiche per:

### 1. Iniezione SQL ❌
- Non testato direttamente (usare prepared statements)

### 2. XSS (Cross-Site Scripting) ✅
- `testHTMLSpecialChars()` verifica escapatura HTML

### 3. CSRF (Cross-Site Request Forgery) ❌
- Non testato (implementare token CSRF)

### 4. Password Strength ✅
- `testPasswordHashing()` verifica bcrypt

### 5. JWT Validation ✅
- `testJWTTokenStructure()` verifica struttura token

---

## 📚 Risorse Addizionali

### Per Sviluppatori

- [PHPUnit Documentation](https://phpunit.de/)
- [JWT.io](https://jwt.io/) - JWT Documentation
- [OWASP Security Testing Guide](https://owasp.org/www-project-web-security-testing-guide/)

### Per Amministratori

- Mantieni i test aggiornati con le nuove funzionalità
- Esegui i test prima di ogni deployment
- Monitora la copertura dei test

---

## 💡 Best Practices

1. **Esegui i test spesso**
   - Prima di ogni commit
   - Prima di ogni deploy
   - Dopo ogni modifica importante

2. **Mantieni i test aggiornati**
   - Aggiungi test per nuove funzionalità
   - Aggiorna test quando il comportamento cambia

3. **Usa test names descrittivi**
   - "testUserCanLoginWithValidCredentials" ✅
   - "test1" ❌

4. **Test in isolation**
   - Ogni test dovrebbe essere indipendente
   - Evita dipendenze tra test

5. **Documenta il perché, non solo il cosa**
   - Aggiungi commenti ai test complessi
   - Spiega il comportamento atteso

---

## 🐛 Troubleshooting

### Error: "Token mancante" (integration_tests.php)
- Il test richiede autenticazione
- Inserire credenziali di test valide nel codice

### Error: "Connessione fallita" (integration_tests.php)
- Verificare che l'URL_BASE sia corretto
- Verificare che il server sia online
- Controllare la connessione internet

### Error: "Estensione cURL non caricata"
- Installare php-curl: `apt-get install php-curl`
- Riavviare PHP-CLI

### Parse Error
- Verificare la sintassi PHP: `php -l tests.php`
- Controllare che tutti gli endpoint siano corretti

---

## 📞 Supporto

Per domande o problemi:
- 👨‍💻 Autore: Li Lisheng (ITIS P. Paleocapa 2025/2026)
- 📧 Email: lilisheng5ie@gmail.com
- 🐛 Issues: Segnalare bug nel repository

---

**Ultimo aggiornamento:** Maggio 2026
**Versione:** 1.0
**Status:** ✅ Completato
