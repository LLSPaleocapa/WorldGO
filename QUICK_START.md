# ⚡ WorldGO - Guida Rapida 5 Minuti

> Leggi questo prima di leggere la documentazione completa

---

## 🌍 Cos'è WorldGO?

**WorldGO** è un'app per condividere itinerari di viaggio con altri viaggiatori.

**Tagline:** "Dove vuoi, come vuoi"

---

## 👤 Per Utenti Finali

### Cosa Posso Fare?
1. **Registrarsi** - Crea un account con username, email e password
2. **Fare Login** - Accedi con le tue credenziali
3. **Creare Post** - Pubblica i tuoi itinerari di viaggio
4. **Visualizzare Post** - Scopri i viaggi di altri utenti
5. **Mettere Like** - Apprezza i post che ti piacciono
6. **Visualizzare Profilo** - Vedi i tuoi dati nella dashboard

### Come Iniziare?
```
1. Vai su https://lilisheng5ie.altervista.org/
2. Clicca "Registrati"
3. Compila il form
4. Clicca "Accedi" con le tue credenziali
5. Clicca "Pubblica" per condividere un viaggio
```

### Documenti Utili
📖 **[MANUALE_UTENTE.md](./MANUALE_UTENTE.md)** - Leggi questo per una guida completa

---

## 👨‍💻 Per Developer

### Tech Stack
- **Backend:** PHP 8.x + MySQL
- **Frontend:** HTML5 + Bootstrap 5 + Vanilla JavaScript
- **Autenticazione:** JWT (JSON Web Tokens)
- **Password:** bcrypt hashing

### Come Settare l'Ambiente?
```bash
# 1. Clonare
git clone https://github.com/LLSPaleocapa/WorldGO.git
cd WorldGO

# 2. Composer
composer install

# 3. Database
# Modifica WorldGO/config/config.php con tue credenziali
mysql < my_lilisheng5ie.sql

# 4. Tester
php tests.php               # Unit tests
php integration_tests.php   # Integration tests

# 5. Server
php -S localhost:8000
```

### Struttura Cartelle
```
WorldGO/
├── auth/              # Login/Registrazione
├── pages/             # HTML pages (login, dashboard, etc)
├── actions/           # Backend logic
├── api/               # API endpoints
├── config/            # Database config
├── css/ + js/         # Frontend
└── vendor/            # Dipendenze (Composer)
```

### Test Rapidi
```bash
# Unit test (validazioni, logica, sicurezza)
php tests.php

# Integration test (HTTP endpoints)
php integration_tests.php

# Risultato atteso: All tests passed ✅
```

### Documenti Utili
👨‍💻 **[DEVELOPER_GUIDE.md](./DEVELOPER_GUIDE.md)** - Guida tecnica completa  
🧪 **[TEST_DOCUMENTATION.md](./TEST_DOCUMENTATION.md)** - Info sui test

---

## 🗄️ Database (30 secondi)

### Tabelle Principali
```sql
WorldGO_users        # Utenti (username, email, password)
WorldGO_posts        # Post di viaggio (titolo, descrizione, immagine)
WorldGO_likes        # Like sugli post
WorldGO_commenti     # Commenti (in sviluppo)
WorldGO_roles        # Ruoli (admin, CRUD, user)
WorldGO_permissions  # Permessi (pubblica_post, commento, etc)
```

---

## 🔐 Sicurezza (30 secondi)

✅ Password hashing con bcrypt  
✅ SQL injection prevention (prepared statements)  
✅ XSS prevention (HTML sanitization)  
✅ JWT authentication con expiration (10 minuti)  
✅ Role-Based Access Control (RBAC)  

---

## 🚀 Avvio Rapido Sviluppo

```bash
# 1. Setup
cd /workspaces/WorldGO
composer install

# 2. Config database in: WorldGO/config/config.php
nano WorldGO/config/config.php

# 3. Importa DB
mysql -u user -p database < my_lilisheng5ie.sql

# 4. Test
php tests.php

# 5. Esegui
php -S localhost:8000

# 6. Visita
open http://localhost:8000/WorldGO/index.php
```

---

## 📝 File Documentazione

| File | Per Chi | Tempo | Cosa Contiene |
|------|---------|-------|---------------|
| **MANUALE_UTENTE.md** | Utenti | 20 min | Come usare l'app |
| **DEVELOPER_GUIDE.md** | Dev | 30 min | Architettura, DB, API |
| **TEST_DOCUMENTATION.md** | QA/Dev | 15 min | Come eseguire test |
| **tests.php** | Dev | - | 15+ unit test |
| **integration_tests.php** | Dev | - | 13+ integration test |

---

## ✨ Feature Principali

| Feature | Status | Chi | Come |
|---------|--------|-----|------|
| Registrazione | ✅ | Utente | Form + DB |
| Login | ✅ | Utente | JWT token |
| Creare Post | ✅ | Utente registrato | Form + file upload |
| Visualizzare Post | ✅ | Tutti | API GET |
| Like | ✅ | Utente registrato | Pulsante ❤️ |
| Commenti | 🔨 | Utente registrato | In sviluppo |
| Dashboard | ✅ | Utente | Dati profilo |
| Admin Panel | 🔨 | Admin | In sviluppo |

---

## 🔗 Links Importanti

| Link | Descrizione |
|------|-------------|
| https://lilisheng5ie.altervista.org/ | Live site |
| https://github.com/LLSPaleocapa/WorldGO | Repository |
| [DOCUMENTAZIONE.md](./DOCUMENTAZIONE.md) | Index documentazione |
| [MANUALE_UTENTE.md](./MANUALE_UTENTE.md) | Per utenti finali |
| [DEVELOPER_GUIDE.md](./DEVELOPER_GUIDE.md) | Per sviluppatori |
| [TEST_DOCUMENTATION.md](./TEST_DOCUMENTATION.md) | Guida test |

---

## ❓ Domande Frequenti

### Posso usare WorldGO?
**Sì!** Registrati su https://lilisheng5ie.altervista.org/

### Come creo un post?
1. Login
2. Clicca "Pubblica"
3. Compila titolo + descrizione + immagine
4. Clicca "Pubblica"

### Quali browser sono supportati?
Chrome, Firefox, Safari, Edge (versioni recenti)

### Posso modificare un post?
Sì, se sei l'autore. Clicca sul post e vedi il pulsante "Modifica"

### Chi ha creato WorldGO?
Li Lisheng - ITIS P. Paleocapa (2025/2026)

### Dove trovo il codice?
https://github.com/LLSPaleocapa/WorldGO

---

## 🎯 Prossimi Passi

### Se sei un **Utente**
→ Leggi [MANUALE_UTENTE.md](./MANUALE_UTENTE.md)

### Se sei uno **Sviluppatore**
→ Leggi [DEVELOPER_GUIDE.md](./DEVELOPER_GUIDE.md)

### Se vuoi **Testare**
→ Esegui:
```bash
php tests.php
php integration_tests.php
```

---

## 🏆 Status Progetto

**Status:** ✅ **PRODUZIONE PRONTO**

- Funzionalità core: ✅ Completate
- Test: ✅ 28+
- Documentazione: ✅ Completa
- Sicurezza: ✅ Implementata
- Performance: ✅ Ottimizzata

---

**Ultimo Update:** Maggio 2026  
**Versione:** 1.0  
**Mantainer:** Li Lisheng

*"Dove vuoi, come vuoi" - Scopri il mondo attraverso le esperienze reali di altri viaggiatori.* 🌍✈️
