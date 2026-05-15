# 📖 WorldGO - Manuale Utente

**Dove vuoi, come vuoi**

---

## 📋 Indice
1. [Introduzione](#introduzione)
2. [Avvio dell'Applicazione](#avvio-dellapplicazione)
3. [Registrazione](#registrazione)
4. [Accesso](#accesso)
5. [Dashboard](#dashboard)
6. [Creare un Post di Viaggio](#creare-un-post-di-viaggio)
7. [Visualizzare i Post](#visualizzare-i-post)
8. [Interagire con i Post](#interagire-con-i-post)
9. [Logout](#logout)
10. [Risoluzione Problemi](#risoluzione-problemi)

---

## 🌍 Introduzione

**WorldGO** è una piattaforma community-based che ti permette di:
- 🧳 Pubblicare i tuoi itinerari di viaggio dettagliati
- ✈️ Scoprire nuove destinazioni e attività
- 👥 Condividere esperienze reali con altri viaggiatori
- ❤️ Valutare e apprezzare i post di altri utenti
- 💬 Interagire con la community globale di viaggiatori

### Target di WorldGO
- Viaggiatori occasionali in cerca di ispirazione
- Travel addicted che desiderano condividere esperienze
- Gruppi di amici che pianificano itinerari collaborativi
- Creatori di contenuti travel
- Chiunque cerchi idee reali e affidabili per il prossimo viaggio

---

## 🚀 Avvio dell'Applicazione

### Accesso Web
Visita il link della piattaforma nel tuo browser:
```
https://lilisheng5ie.altervista.org/
```

### Primo Accesso
Se è la tua prima volta su WorldGO, segui i passaggi di **Registrazione**.

---

## 📝 Registrazione

### Passaggi:
1. Clicca su **"Registrati"** nella navbar in alto a destra
2. Compila i seguenti campi obbligatori:
   - **Username**: Il tuo nome utente univoco (come desideri essere identificato nella community)
   - **Email**: Un indirizzo email valido (usato per il recupero dell'account)
   - **Password**: Una password sicura (minimo 8 caratteri consigliati)

### Requisiti:
- ✅ **Username**: Massimo 30 caratteri, unico (non può esserci un altro utente con lo stesso nome)
- ✅ **Email**: Deve essere in formato email valido (es. nome@esempio.com)
- ✅ **Password**: Consigliato almeno 8 caratteri per sicurezza

### Errori Comuni:
| Errore | Soluzione |
|--------|-----------|
| "Username già presente" | Scegli un altro nome utente non ancora registrato |
| "Email non valida" | Inserisci un'email nel formato corretto (nome@dominio.com) |
| "Campi obbligatori mancanti" | Compila tutti i campi richiesti |

### Dopo la Registrazione
Una volta registrato con successo, sarai reindirizzato alla pagina di accesso. Usa le credenziali appena create per entrare.

---

## 🔐 Accesso

### Passaggi:
1. Clicca su **"Accedi"** nella navbar
2. Inserisci:
   - **Username**: Lo username scelto durante la registrazione
   - **Password**: La password scelta durante la registrazione
3. Clicca su **"Accedi"**

### Cosa succede dopo?
- ✅ Se le credenziali sono corrette, accederai alla homepage
- ✅ Vedrai la tua identità nella navbar (ora avrai accesso a "Pubblica" e "Dashboard")
- ✅ Un token JWT verrà salvato in modo sicuro nel tuo browser per mantenere la sessione

### Errori di Accesso:
| Errore | Soluzione |
|--------|-----------|
| "Credenziali non valide" | Controlla username e password; ricorda che distinguono maiuscole/minuscole |
| "Username non trovato" | Verifica l'username o registrati se non hai ancora un account |
| "Password errata" | Controlla che la password sia corretta |

### Sicurezza della Sessione
- Il tuo token JWT ha durata limitata (10 minuti)
- Per motivi di sicurezza, la sessione scade dopo un periodo di inattività
- Effettua il login di nuovo per continuare

---

## 📊 Dashboard

La **Dashboard** è il tuo spazio personale dove puoi monitorare il tuo profilo.

### Accesso
Clicca su **"Dashboard"** nella navbar (visibile solo se sei loggato)

### Cosa Vedi?

#### 1. Dati Utente
Visualizzi le tue informazioni di profilo:
- **Username**: Il tuo nome identificativo
- **User ID**: Il tuo identificativo univoco nel sistema
- **Data di Creazione**: Quando ti sei registrato

#### 2. Ruoli e Permessi
La sezione mostra i ruoli assegnati al tuo account e i relativi permessi:

**Ruoli Disponibili:**
- 👤 **User**: Ruolo base per tutti gli utenti (può commentare e ricevere permessi)
- 👤 **CRUD**: Ruolo con permessi di pubblicazione e gestione contenuti
- 👑 **Admin**: Ruolo amministratore con accesso a tutte le funzioni

**Permessi Comuni:**
- 📝 **pubblica_post**: Permesso di creare nuovi post di viaggio
- 💬 **commento**: Permesso di commentare i post
- 🛠️ **CRUD_permissions**: Permesso di gestire utenti e contenuti

---

## ✈️ Creare un Post di Viaggio

### Accesso
Clicca su **"Pubblica"** nella navbar (disponibile solo se loggato)

### Compilazione del Modulo

#### 📌 Titolo del Viaggio
- **Campo**: Titolo del viaggio
- **Limite**: Massimo 30 caratteri
- **Descrizione**: Dagli un titolo accattivante e breve
- **Esempi**: "Roma in 3 giorni", "Trekking nelle Dolomiti", "Weekend a Firenze"

#### 📝 Descrizione
- **Campo**: Descrizione dettagliata del viaggio
- **Limite**: Nessun limite di caratteri
- **Suggerimenti**:
  - Descrivi l'itinerario giorno per giorno
  - Includi info su trasporti, alloggi, ristoranti consigliati
  - Aggiungi costi stimati
  - Consigli su cosa portare
  - Periodi migliori per visitare

#### 🖼️ Immagine
Puoi aggiungere un'immagine in due modi:

**Opzione 1: URL Esterno**
- Incolla l'URL di un'immagine da internet
- Formato: `https://esempio.com/immagine.jpg`
- Utile se hai l'immagine già online

**Opzione 2: Carica un File**
- Clicca su "Scegli file"
- Seleziona un'immagine dal tuo computer
- Formati supportati: **JPG, JPEG, PNG, GIF**
- Dimensione massima: **5MB**
- L'immagine verrà caricata sui nostri server

**Importante**: Se non carichi né inserisci un'immagine, verrà usata un'immagine placeholder di default.

### Validazione File Immagine

| Problema | Messaggio di Errore | Soluzione |
|----------|-------------------|-----------|
| File troppo grande | "Errore: Il file è troppo grande (X MB). Massimo: 5MB" | Comprimi l'immagine prima di caricare |
| Formato non supportato | "Errore: Formato non supportato. Usa JPG, PNG o GIF" | Converti l'immagine nel formato corretto |
| Upload fallito | "Errore durante il caricamento del file" | Riprova; se persiste, contatta l'assistenza |

### Pubblicazione

1. Clicca su **"Pubblica"** per inviare il tuo post
2. Il post sarà visibile immediatamente sulla piattaforma
3. Riceverai una conferma della pubblicazione

### Dopo la Pubblicazione
- ✅ Il post comparirà nella homepage per tutti gli utenti
- ✅ Potrai modificare o eliminare il post dalla pagina dei dettagli (se sei il proprietario)
- ✅ Gli altri utenti potranno mettervi like e commentare

---

## 👁️ Visualizzare i Post

### Homepage
Nella pagina principale (clicca su **"WorldGO"** nel logo), puoi browsare i post della community.

### Dettagli di un Post

Clicca su qualsiasi post per visualizzare i dettagli completi:

#### Informazioni Visibili:
- **Titolo**: Il titolo accattivante del viaggio
- **Autore**: Username di chi ha pubblicato il post
- **Data**: Quando è stato pubblicato
- **Descrizione**: Il testo completo del viaggio
- **Immagine**: La foto principale del viaggio
- **Like**: Numero totale di persone che hanno apprezzato il post

#### Se sei il Proprietario del Post:
Se hai pubblicato il post, vedrai due pulsanti aggiuntivi:
- **Modifica** 🔧: Modifica il contenuto del post (in sviluppo)
- **Elimina** 🗑️: Rimuovi il post dalla piattaforma (chiederà conferma)

#### Se non sei Loggato:
Potrai visualizzare tutti i dettagli del post, ma non potrai compiere azioni come mettere like.

---

## ❤️ Interagire con i Post

### Like
- Clicca il pulsante ❤️ per mettere like a un post
- Il contatore di like aumenterà immediatamente
- Potrai vedere il numero totale di persone che hanno apprezzato il viaggio

### Commenti
- La funzione commenti è ancora in sviluppo
- Prossimamente potrai scrivere e leggere commenti dettagliati sui post

### Salvare Post
- Funzione in sviluppo: potrai salvare i tuoi post preferiti nella sezione "Salvati"

---

## 🚪 Logout

### Come Effettuare il Logout

1. Clicca su **"Esci"** nella navbar in alto a destra
2. La tua sessione sarà terminata
3. Il token JWT verrà eliminato dal tuo browser
4. Verrai reindirizzato alla homepage

### Dopo il Logout
- ✅ Non potrai più accedere alle funzioni protette (Pubblica, Dashboard)
- ✅ Il tuo account rimane intatto e puoi effettuare un nuovo login quando vuoi
- ✅ I tuoi post rimangono visibili agli altri utenti

---

## 🔧 Risoluzione Problemi

### Non riesco a registrarmi
**Problema**: Ricevo sempre un errore di registrazione
**Soluzioni**:
1. Assicurati che l'username non sia già in uso
2. Verifica che l'email sia nel formato corretto (nome@dominio.com)
3. Svuota la cache del browser (Ctrl+Shift+Delete su Chrome/Firefox)
4. Prova con un browser diverso

### Non riesco ad accedere
**Problema**: Credenziali non valide
**Soluzioni**:
1. Controlla che username e password siano corretti (distinguono maiuscole/minuscole)
2. Se hai dimenticato la password, contatta l'amministratore
3. Verifica che il browser accetti i cookie (necessari per il token JWT)
4. Svuota i cookie e i dati della cache

### L'immagine del post non si carica
**Problema**: L'immagine del post mostra un errore 404
**Soluzioni**:
1. Se hai usato un URL esterno, verifica che il link sia ancora valido
2. Se hai caricato un file, assicurati che la dimensione sia minore di 5MB
3. Prova a ricaricare la pagina (Ctrl+R o Cmd+R)
4. Usa un'immagine in un formato diverso (JPG invece di PNG, ecc.)

### Il post non viene pubblicato
**Problema**: Cliccando "Pubblica" nulla accade
**Soluzioni**:
1. Assicurati di essere loggato (verifica che vedi "Esci" nella navbar)
2. Compila tutti i campi obbligatori (titolo e descrizione)
3. Verifica che il titolo non superi 30 caratteri
4. Verifica la connessione internet
5. Apri la console del browser (F12) per eventuali messaggi di errore

### Token JWT Scaduto
**Problema**: La sessione è scaduta e devo fare login di nuovo
**Cause**: 
- Inattività per più di 10 minuti
- Browser chiuso
- Cache svuotata

**Soluzione**: Effettua un nuovo login

### Problema generico / Errore 500
**Soluzioni**:
1. Aggiorna la pagina (Ctrl+R)
2. Svuota la cache del browser
3. Prova in una finestra di navigazione privata/incognito
4. Contatta l'amministratore del sito

---

## 📞 Supporto

Per domande o problemi non risolti in questo manuale, puoi:
- 📧 Contattare lo sviluppatore: Li Lisheng (ITIS P. Paleocapa 2025/2026)
- 🐛 Segnalare bug nella sezione dedicata
- 💬 Scrivere nella community

---

## 📜 Note sulla Privacy e Sicurezza

- ✅ La tua password è crittografata usando l'algoritmo **bcrypt**
- ✅ Il tuo token JWT è salvato in un cookie **HttpOnly** (protetto da XSS)
- ✅ Tutte le connessioni dovrebbero usare **HTTPS** (per la versione di produzione)
- ✅ I tuoi dati personali non vengono mai condivisi con terze parti
- ⚠️ Non condividere mai la tua password con nessuno
- ⚠️ Fai sempre logout da computer non tuoi

---

## 🎯 Suggerimenti per i Migliori Post

Per creare post di viaggio che la community apprezzerà:

1. **Titolo Accattivante**: Sii descrittivo ma conciso
   - ❌ "Viaggio"
   - ✅ "Viaggio in Giappone: 10 giorni tra templi e città"

2. **Descrizione Dettagliata**: Fornisci informazioni pratiche
   - Costi stimati
   - Periodo migliore per visitare
   - Durata consigliata
   - Consigli pratici (cosa portare, documenti, ecc.)
   - Ristoranti e attrazioni consigliate

3. **Buona Immagine**: Una foto attraente e di qualità
   - Evita immagini sfocate o di bassa qualità
   - Scegli foto rappresentative della destinazione
   - Dimensione ideale: almeno 800x600px

4. **Sincerità**: Condividi sia gli aspetti positivi che negativi
   - Cosa è andato bene
   - Cosa potrebbe migliorare
   - Sorprese e scoperte inaspettate

---

**Buon viaggio e benvenuto su WorldGO! 🌍✈️**

*Dove vuoi, come vuoi - Scopri il mondo attraverso le esperienze reali di altri viaggiatori.*
