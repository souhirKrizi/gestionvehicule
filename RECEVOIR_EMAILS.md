# 📧 RECEVOIR LES EMAILS D'ACCEPTATION

## 🔴 Problème Actuel

**Situation**: Les emails ne sont pas reçus  
**Raison**: Le système envoie juste les logs, pas les emails réels  
**Configuration**: `MAIL_MAILER=log` dans le `.env`

---

## ✅ Solution Rapide (5 minutes)

### Option 1: Gmail (Recommandé)

**Étape 1: Activer App Password Google**

1. Aller à: https://myaccount.google.com/apppasswords
2. Sélectionner "Mail" et "Windows Computer"
3. Google crée un mot de passe: `xxxx xxxx xxxx xxxx`
4. **Copier ce mot de passe**

**Étape 2: Éditer le fichier `.env`**

Trouver ces lignes (ligne 51-58):
```
MAIL_MAILER=log
MAIL_SCHEME=null
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
```

Les remplacer par:
```
MAIL_MAILER=smtp
MAIL_SCHEME=null
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=votre_email@gmail.com
MAIL_PASSWORD=xxxx xxxx xxxx xxxx
MAIL_ENCRYPTION=tls
```

**Étape 3: Exécuter**

```bash
php artisan config:clear
php artisan optimize
```

**Étape 4: Tester**

Admin approuve un utilisateur → Email reçu! ✅

---

### Option 2: Mailtrap (Service Cloud)

1. Créer compte: https://mailtrap.io
2. Copier credentials
3. Ajouter à `.env`:
```
MAIL_MAILER=smtp
MAIL_HOST=live.smtp.mailtrap.io
MAIL_PORT=465
MAIL_USERNAME=username
MAIL_PASSWORD=token
MAIL_ENCRYPTION=tls
```
4. Les emails apparaissent sur: https://mailtrap.io/dashboard

---

### Option 3: MailHog (Local)

1. Télécharger: https://github.com/mailhog/MailHog/releases
2. Lancer `MailHog_windows_amd64.exe`
3. Ajouter à `.env`:
```
MAIL_MAILER=smtp
MAIL_HOST=127.0.0.1
MAIL_PORT=1025
MAIL_USERNAME=
MAIL_PASSWORD=
```
4. Voir les emails: http://localhost:8025

---

## 🎯 APRÈS CONFIGURATION

Quand l'admin approuve un utilisateur:

1. ✅ L'utilisateur reçoit un **email réel**
2. ✅ Email contient un **lien pour accéder l'app**
3. ✅ Utilisateur peut se **connecter et utiliser l'app**

---

## 📚 Documentation Complète

Voir: `CONFIGURER_EMAILS.md`
