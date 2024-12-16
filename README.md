# Planty
![Alt text](https://github.com/AllabouchAnas/planty/blob/main/screenshots/screen.png)

Ce projet WordPress utilise WooCommerce pour créer une boutique en ligne spécialisée dans la vente de plantes. Le site est conçu pour offrir une expérience d'achat fluide et agréable aux utilisateurs intéressés par des plantes d'intérieur et d'extérieur.

## Thème utilisé
Lustria : Un thème moderne et responsive, conçu spécifiquement pour les sites de commerce en ligne. Il offre une présentation claire et soignée des produits avec des options de personnalisation avancées.

## Plugins utilisés
- 1.WooCommerce : Plugin principal pour la gestion de la boutique en ligne, la gestion des produits, des commandes et des paiements.
- 2.Contact Form 7 : Plugin pour la gestion des formulaires de contact sur le site. Il permet aux utilisateurs de poser des questions ou de demander des informations sur les plantes.
- 3.Elementor : Page Builder visuel pour créer et personnaliser des pages avec une interface glisser-déposer, simplifiant ainsi le design du site.
- 4.Elementor Pro : Version premium d'Elementor, offrant des fonctionnalités supplémentaires pour la création de pages plus avancées et personnalisées.
- 5.Envato Market : Permet d'installer et de gérer facilement des thèmes et des plugins premium achetés sur le marché Envato.
- 6.G5 Install Demo : Plugin pour importer facilement une démo de site préconfigurée, ce qui permet de mettre en place rapidement une version de base du site.
- 7.G5Plus Post Like : Plugin pour permettre aux utilisateurs d'aimer les produits, ce qui peut être utile pour les recommandations de produits populaires.
- 8.Lustria Framework : Framework qui complète le thème Lustria, offrant des fonctionnalités avancées pour personnaliser les pages et les sections du site.

## Prérequis
1. **XAMPP installé sur votre machine** :
   Vous pouvez télécharger XAMPP à partir du [site officiel](https://www.apachefriends.org/download.html) et l'installer selon votre système d'exploitation.

2. **Le projet WordPress** :
   Assurez-vous d'avoir tous les fichiers du projet WordPress (y compris les fichiers `wp-content`, `wp-config.php`, et autres fichiers essentiels) prêts à être installés.

## Étapes d'installation

### 1. Démarrer XAMPP

- Ouvrez **XAMPP** et démarrez les services **Apache** et **MySQL**.
  - Cliquez sur le bouton **Start** à côté de **Apache** (serveur web).
  - Cliquez sur le bouton **Start** à côté de **MySQL** (base de données).

### 2. Placer le projet WordPress dans le répertoire XAMPP

- Copiez le contenu depuis le dossier `app` extrait de `Planty.zip` et placez-le dans le répertoire **htdocs** de XAMPP (généralement situé à `C:\xampp\htdocs` sur Windows).

### 3. Créer une base de données MySQL

- Accédez à **phpMyAdmin** en ouvrant votre navigateur et en allant à l'adresse suivante :
- Connectez-vous avec les informations par défaut (généralement `root` pour le nom d'utilisateur et aucun mot de passe).
- Créez une nouvelle base de données pour votre projet WordPress :
- Cliquez sur **Base de données** dans le menu.
- Saisissez un nom pour votre base de données (par exemple, `planty`) et cliquez sur **Créer**.

### 4. Importer la base de données exportée

1. Après avoir créé la base de données, cliquez sur le nom de la base de données dans la liste de gauche.
2. Cliquez sur l'onglet **Importer** en haut.
3. Cliquez sur le bouton **Choisir un fichier**, puis sélectionnez votre fichier `.sql` exporté.
4. Cliquez sur **Exécuter** pour importer la base de données.

### 5. Modifier le fichier `wp-config.php`

Si ce fichier n'existe pas dans votre projet, vous devrez en créer un en copiant le fichier `wp-config-sample.php` et en le renommant `wp-config.php`.

Ouvrez le fichier `wp-config.php` dans un éditeur de texte et modifiez les lignes suivantes avec les informations de votre base de données :

```php
/** Le nom de la base de données de WordPress */
define('DB_NAME', 'planty');  // Remplacez par le nom de votre base de données

/** Votre identifiant MySQL */
define('DB_USER', 'root');           // Utilisez 'root' par défaut avec XAMPP

/** Le mot de passe de votre identifiant MySQL */
define('DB_PASSWORD', '');          // Laissez vide pour XAMPP par défaut

/** Adresse de l’hôte MySQL */
define('DB_HOST', 'localhost');
```
### 6. Mettre à jour les URLs du site

Si vous avez importé une base de données provenant d'un autre environnement, vous devrez peut-être mettre à jour les URLs du site pour qu'elles pointent vers votre installation locale.

- Connectez-vous à votre base de données via phpMyAdmin.
- Allez dans la table `wp_options`.
- Modifiez les valeurs de `siteurl` et `home` pour qu'elles pointent vers votre installation locale, par exemple :

  - `siteurl` = `http://localhost`
  - `home` = `http://localhost`

### 7. Accéder à votre site WordPress
1. Ouvrez votre navigateur et allez à `http://localhost`.
2. Vous devriez voir votre site WordPress en fonctionnement.

## Identifiants Administrateur

Voici les identifiants de connexion pour l'admin et un utilisateur standard :

### Admin
- **Nom d'utilisateur** : admin
- **Mot de passe** : admin

### Contributeur
- **Nom d'utilisateur** : userc
- **Mot de passe** : userc

### Éditeur
- **Nom d'utilisateur** : usere
- **Mot de passe** : usere

## Conclusion
Votre projet WordPress est maintenant installé et prêt à être utilisé sur XAMPP !