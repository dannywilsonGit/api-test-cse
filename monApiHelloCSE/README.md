# Mon API Laravel – Environnement Dockerisé 🚀

Ce projet est une API Laravel entièrement dockerisée, conçue pour un déploiement rapide, une configuration propre et une portabilité maximale entre les environnements.

## 🔧 Technologies utilisées

- github
- phpStorm
- php 8.2
- Laravel 11
- MySQL (via Docker)
- Docker & Docker Compose
- POSTMAN
- Diagramme (langage UML) fichier plantuml plugin intégré à phpStorm (à retrouver dans Models/2TUP/)

## 🚀 Lancer le projet

### 1. Cloner le dépôt

git clone https://github.com/dannywilsonGit/api-test-cse.git  
cd dossier-projet

### 2. Lancer les conteneurs

docker-compose up -d

### 3. Installer les dépendances PHP

docker-compose exec app composer install

### 4. Copier le fichier.env

docker-compose exec app cp .env.example .env

## ⚙️ Remplacer dans le Fichier .env

DB_CONNECTION=mysql  
DB_HOST=db  
DB_PORT=3306  
DB_DATABASE=laravel  
DB_USERNAME=root  
DB_PASSWORD=root

## 5. Générer la clé Laravel

docker-compose exec app php artisan key:generate

### 6. Migrer la base de données

docker-compose exec app php artisan migrate

### 7. Recréer le dossier tests/unit

docker-compose exec app mkdir -p tests/Unit

### 8. Lancer les tests

docker-compose exec app php artisan test --env=testing --stop-on-failure

### 9. Test phpStan (Niveau de sécurité à modifier à souhait dans phpstan.neon)

docker-compose exec app ./vendor/bin/phpstan analyse -c phpstan.neon --memory-limit=1G

### 10. Accéder à l'application

- Laravel : http://localhost:8080
    - Serveur : `db`
    - Utilisateur : `root`
    - Mot de passe : `root`

### 11. Test POSTMAN

A regarder dans le dossier Models/2TUP/dossiers tests image


## ✅ Avantage de ma dockerisation

- Prêt pour le développement collaboratif
- Compatible Windows, macOS, Linux
- Structure claire pour une montée en charge ou un hébergement futur

---
