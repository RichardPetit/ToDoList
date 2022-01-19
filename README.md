ToDoList
========

Base du projet #8 : Améliorez un projet existant

https://openclassrooms.com/projects/ameliorer-un-projet-existant-1


#Prérequis

Ce projet necessite l'environnement suivant:

PHP >= 7.4

Symfony >= 5.3

MySQL >= 5.6

Composer

#Installation

Cloner le repository Github: https://github.com/RichardPetit/TodoList

#Bibliothèques externe

Afin d'installer les librairies du projet, vous devez lancer la commande suivante: composer install

#Variables d'environnement

Afin de déclarer vos variables d'environnement (configuration base de données et email) vous devez copier le fichier .env.example vers un fichier .env à la racine du projet. Vous devez personaliser ce fichier .env avec vos propres valeurs.

#Base de données

Créez la base de données avec la commande ci-dessous:

php bin/console doctrine:database:create

Puis mettez à jour la structure de la base de données avec la commande:
 
php bin/console doctrine:migrations:migrate

#Envoi d'email

Vous devez configurer les valeurs SMTP dans le fichier .env afin de configurer l'envoi d'email.




#Contexte

Vous venez d’intégrer une startup dont le cœur de métier est une application permettant de gérer ses tâches quotidiennes. L’entreprise vient tout juste d’être montée, et l’application a dû être développée à toute vitesse pour permettre de montrer à de potentiels investisseurs que le concept est viable (on parle de Minimum Viable Product ou MVP).

Le choix du développeur précédent a été d’utiliser le framework PHP Symfony, un framework que vous commencez à bien connaître !

Bonne nouvelle ! ToDo & Co a enfin réussi à lever des fonds pour permettre le développement de l’entreprise et surtout de l’application.

Votre rôle ici est donc d’améliorer la qualité de l’application. La qualité est un concept qui englobe bon nombre de sujets : on parle souvent de qualité de code, mais il y a également la qualité perçue par l’utilisateur de l’application ou encore la qualité perçue par les collaborateurs de l’entreprise, et enfin la qualité que vous percevez lorsqu’il vous faut travailler sur le projet.

Ainsi, pour ce dernier projet de spécialisation, vous êtes dans la peau d’un développeur expérimenté en charge des tâches suivantes :

    l’implémentation de nouvelles fonctionnalités ;
    la correction de quelques anomalies ;
    et l’implémentation de tests automatisés.

Il vous est également demandé d’analyser le projet grâce à des outils vous permettant d’avoir une vision d’ensemble de la qualité du code et des différents axes de performance de l’application.

Il ne vous est pas demandé de corriger les points remontés par l’audit de qualité de code et de performance. Cela dit, si le temps vous le permet, ToDo & Co sera ravi que vous réduisiez la dette technique de cette application.

#Description du besoin
Corrections d'anomalies
Une tâche doit être attachée à un utilisateur

Actuellement, lorsqu’une tâche est créée, elle n’est pas rattachée à un utilisateur. Il vous est demandé d’apporter les corrections nécessaires afin qu’automatiquement, à la sauvegarde de la tâche, l’utilisateur authentifié soit rattaché à la tâche nouvellement créée.

Lors de la modification de la tâche, l’auteur ne peut pas être modifié.

Pour les tâches déjà créées, il faut qu’elles soient rattachées à un utilisateur “anonyme”.
Choisir un rôle pour un utilisateur

Lors de la création d’un utilisateur, il doit être possible de choisir un rôle pour celui-ci. Les rôles listés sont les suivants :

    rôle utilisateur (ROLE_USER) ;
    rôle administrateur (ROLE_ADMIN).

Lors de la modification d’un utilisateur, il est également possible de changer le rôle d’un utilisateur.

#
