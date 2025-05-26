# Mon API Laravel – Environnement Dockerisé 🚀

Ce projet est une API Laravel entièrement dockerisée, conçue pour un déploiement rapide, une configuration propre et une portabilité maximale entre les environnements.

## 🔧 Technologies utilisées

- Laravel 11
- MySQL (via Docker)
- Docker & Docker Compose

## 🚀 Lancer le projet

### 1. Cloner le dépôt

git clone https://github.com/dannywilsonGit/api-test-cse.git  
cd dossier-projet

### 2. Lancer les conteneurs

docker-compose up -d

### 3. Installer les dépendances PHP

docker-compose exec app composer install

### 4. Générer la clé Laravel

docker-compose exec app php artisan key:generate

### 5. Migrer la base de données

docker-compose exec app php artisan migrate

### 6. Accéder à l'application

- Laravel : http://localhost:8080
    - Serveur : `db`
    - Utilisateur : `root`
    - Mot de passe : `root`

## ⚙️ Fichier .env 

DB_CONNECTION=mysql  
DB_HOST=db  
DB_PORT=3306  
DB_DATABASE=laravel  
DB_USERNAME=root  
DB_PASSWORD=root

## ✅ Avantage de ma dockerisation

- Prêt pour le développement collaboratif
- Compatible Windows, macOS, Linux
- Structure claire pour une montée en charge ou un hébergement futur

---

