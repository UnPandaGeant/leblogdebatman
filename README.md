# Projet Le Blog de Batman

## Installation

### Cloner le projet

```
git clone https://github.com/Anthony-Dmn/leblogdebatman.git
```

### Modifier les paramètres d'environnement dans le fichier .env (changer user_db, password_db, clés Google Recaptcha)

### Déplacer le terminal dans le dossier cloné
```
cd leblogdebatman
```

### Taper les commandes suivantes :

```
composer install
symfony console doctrine:database:create
symfony console make:migration
symfony console doctrine:migrations:migrate
symfony console doctrine:fixtures:load
symfony console assets:install public
```

Les fixtures créeront :
* Un compte admin (email: admin@a.a , password : aaaaaaaaA7/ )
* 50 comptes utilisateurs (email aléatoire, password : aaaaaaaaA7/ )
* 200 articles
* entre 0 et 10 commentaires par article