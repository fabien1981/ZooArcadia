# ZooArcadia

**Application web pour la gestion et la consultation des données d'un zoo écologique.**

---

## Mise en place de l'environnement de travail

### 1. Installation des outils de développement

#### Visual Studio Code
- **Description** : Éditeur de code léger et puissant.
- **Installation** :
  - [Téléchargez Visual Studio Code](https://code.visualstudio.com/).
  - Installez les extensions recommandées :
    - `PHP Intelephense` (pour l'auto-complétion et la syntaxe PHP).
    - `Prettier` (formatage automatique du code).
    - `Live Server` (prévisualisation locale).

#### PHP
- **Description** : Langage de développement côté serveur.
- **Installation** :
  - [Téléchargez PHP](https://www.php.net/downloads).
  - Vérifiez l'installation avec la commande suivante :
    ```bash
    php -v
    ```

#### XAMPP
- **Description** : Fournit un environnement de développement local complet (Apache, MySQL, PHP, Perl).
- **Installation** :
  - [Téléchargez XAMPP](https://www.apachefriends.org/index.html).
  - Démarrez les services Apache et MySQL via le panneau de contrôle XAMPP.

#### Node.js
- **Description** : Exécute des scripts côté serveur et gère les dépendances (comme Bootstrap).
- **Installation** :
  - [Téléchargez Node.js](https://nodejs.org/).
  - Vérifiez l'installation :
    ```bash
    node -v
    npm -v
    ```

#### MongoDB
- **Description** : Utilisé pour stocker les consultations des animaux.
- **Installation** :
  - [Téléchargez MongoDB Community Edition](https://www.mongodb.com/try/download/community).
  - Installez MongoDB Compass (interface graphique pour MongoDB).

---

## 2. Téléchargement et configuration du projet

### Cloner le dépôt Git
- Clonez le dépôt depuis GitHub :
  ```bash
  git clone https://github.com/fabien1981/ZooArcadia.git


# Configuration de l'environnement

## Installation des dépendances Node.js (Bootstrap, etc.)

Copier le code
npm install

## Configuration de PHP
Activez l'extension pdo_mysql dans le fichier php.ini.
Modifiez la variable date.timezone pour correspondre à votre fuseau horaire (exemple : Europe/Paris).


# Création de la base de données

## Importez le fichier SQL fourni (zooarcadia.sql) dans votre base MySQL locale :
Accédez à phpMyAdmin via http://localhost/phpmyadmin.
Créez une base de données appelée zooarcadia.
Importez le fichier SQL via l'onglet Importer.

# Connexion à MongoDB
Configurez MongoDB pour accepter les connexions locales (par défaut).

# Lancement du projet
## Démarrage du serveur
Lancez XAMPP et démarrez Apache et MySQL.
Accédez à l'application dans le navigateur à l'adresse suivante :
http://localhost/ZooArcadia

## Compilation des fichiers CSS 

Copier le code
npm run sass


## En cas de problème
Problèmes courants
Erreur : Serveur introuvable

Assurez-vous que XAMPP est démarré et que les services Apache et MySQL sont actifs.
# Erreur : Fichier CSS ou JS manquant

Vérifiez la structure des fichiers et réexécutez :
Copier le code
npm run sass
