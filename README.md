# Projet TogetherAtDisney
TogetherAtDisney est une application web développée avec Symfony qui permet aux utilisateurs de créer un profil sur l'univers Disney. Les utilisateurs peuvent partager des photos en rapport avec Disney, ajouter d'autres utilisateurs en ami et échanger des messages privés.

## Fonctionnalités
Gestion de photos avec Cloudinary: Les utilisateurs peuvent télécharger des photos liées à Disney, qui sont stockées et gérées via l'API de Cloudinary.
Réseau d'amis: Les utilisateurs peuvent ajouter d'autres utilisateurs en tant qu'amis et voir leurs publications dans un flux dédié.
Messagerie privée: Les utilisateurs peuvent échanger des messages privés avec leurs amis.

## Prérequis
Avant de commencer à utiliser DisneyBlog, assurez-vous d'avoir les éléments suivants installés :

PHP 7.4 ou supérieur
Composer
Symfony CLI
Une clé d'API Cloudinary

## Installation
Clonez ce dépôt sur votre machine locale
Installez les dépendances PHP avec Composer
Configurez votre base de données dans le fichier .env 

Créez la base de données et exécutez les migrations :
- php bin/console doctrine:database:create
- php bin/console doctrine:migrations:migrate

Démarrez le serveur Symfony



![Capture d'écran 2024-04-18 152623](https://github.com/jezeville/togetherAtDisney/assets/151575442/96d5a584-a8f2-4dc2-a37f-a5cb32046a2d)
![Capture d'écran 2024-04-18 152846](https://github.com/jezeville/togetherAtDisney/assets/151575442/def6f544-f6a9-46fe-9af4-54f0dcc1b174)
![Capture d'écran 2024-04-18 152906](https://github.com/jezeville/togetherAtDisney/assets/151575442/319651e6-ae88-4f28-aa23-13859af1a928)

