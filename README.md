# Message Board
Message Board est une application permettant aux utilisateurs de poster des messages dans différents salons. Les utilisateurs peuvent créer des salons et consulter les messages de tous les salons.

Le code est écrit en PHP natif sans l'utilisation d'un framework. Les tests unitaires sont écrits avec PHPUnit et les tests Behat avec Behat.

## Installation
Cloner le dépôt: git clone https://github.com/HyziOne/TestUnitairePHP.git

Installer les dépendances: ``` composer install```

Exécuter les tests: vendor/bin/phpunit et vendor/bin/behat

Utiliser la commande suivante pour initialiser le php au front :
```
php -S localhost:8000 ./public/routeur.php
```
## Fonctionnnalités
### Utilisation
Pour verifier que l'installation est prête : ```http://localhost:8000```

L'application utilise un ORM fictif pour stocker les données. 

Les données sont stockées en mémoire pendant l'exécution de l'application.

### Messages
Message représente un message posté par un utilisateur dans un salon.

Les messages doivent avoir au moins 2 caractères et au maximum 2048 caractères.

Les utilisateurs ne peuvent pas poster deux messages consécutifs sauf si leur dernier message date de plus de 24 heures.

Les messages peuvent être ajoutés avec ORM::addMessage.

Les messages peuvent être récupérés par id avec ORM::getMessageById.

Les messages peuvent être récupérés pour une salle donnée avec ORM::getMessagesByRoomId.

Les messages peuvent être récupérés par utilisateur avec ORM::getMessagesByUserId.

Message a les propriétés suivantes: id, user_id, room_id, content et timestamp.
### Utilisateurs
User représente un utilisateur.

Les utilisateurs peuvent être ajoutés avec ORM::addUser.

Les utilisateurs peuvent être récupérés par id avec ORM::getUserById.

Les utilisateurs peuvent être récupérés par nom d'utilisateur avec ORM::getUserByUsername.

User a les propriétés suivantes: id et username.
### Salons
Room représente un salon.
* Les salons peuvent être ajoutés avec ORM::addRoom.
* Les salons peuvent être récupérés par id avec ORM::getRoomById.
* Les salons peuvent être récupérés par nom avec ORM::getRoomByName.
* Les salons ont les propriétés suivantes: id et name.
# Tests unitaires
Les tests unitaires sont écrits avec PHPUnit. 

Les tests couvrent les cas d'utilisation suivants:

* Ajouter un utilisateur
* Récupérer un utilisateur par id
* Récupérer un utilisateur par nom d'utilisateur
* Ajouter un salon
* Récupérer un salon par id
* Récupérer un salon par nom
* Ajouter un message
* Récupérer un message par id
* Récupérer les messages pour une salle donnée
* Récupérer les messages pour un utilisateur donné
* Vérifier que les utilisateurs ne peuvent pas poster deux messages consécutifs sauf si leur dernier message date de plus de 24 heures
Les tests peuvent être exécutés avec :
```
./vendor/bin/phpunit tests
```
## Tests Behat

Les tests couvrent les scénarios suivants:
* Créer et récupérer des utilisateurs
* Créer et récupérer des salles
* Créer et récupérer des messages
* Récupérer des messages dans une salle
Les tests peuvent être exécutés avec :
```
vendor/bin/behat 
```
