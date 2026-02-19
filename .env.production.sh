# .env.production (pour Vercel - À GARDER SECRET)
APP_NAME="NewsPro Admin"
APP_ENV=production
APP_KEY=base64:VOTRE_NOUVELLE_CLE_GENEREE
APP_DEBUG=false
APP_URL=https://votre-app.vercel.app

# Base de données (Vercel Postgres ou autre)
DB_CONNECTION=pgsql
DB_HOST=ep-xyz.eu-central-1.aws.neon.tech
DB_PORT=5432
DB_DATABASE=neondb
DB_USERNAME=username
DB_PASSWORD=password

# Session
SESSION_DRIVER=file
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=.vercel.app

# Cache
CACHE_STORE=file

# Mail (en production)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=votre-email@gmail.com
MAIL_PASSWORD="votre-mot-de-passe-app"
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@votre-app.com"
MAIL_FROM_NAME="${APP_NAME}"

# Vercel specific
VERCEL=1
