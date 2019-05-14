---
author: NOFFABEL  
title: WeatherFences-API
---

# WeatherFences Rest API (utilisant slim framework 3)

Mise en place d'une ***API REST PHP***. Avec les configurations nous pourrons accéder à cet API depuis un mobile Android.  

## Outils et installations  

Liste des outils :  

* [WampServer](http://www.wampserver.com/): Qui nous servira d'hébergeur local  
* [Insomnia](https://insomnia.rest/download/#windows): pour l'exécution des requètes HTTP de l'API REST en developpement  

## Installation et configuration  

1. Installer WampServer et la base de données
2. Cloner le dépos de l'API
3. exécuter les commandes `cd <path>` pour se positionner dans le dossier `composer install` pour installer les dépendances du projet .
4. Créer la base de données. Il suffira d'importer le fichier sql dans le repertoire DB du projet.

### Creation d'un *Virtual Host*

***Un Virtual Host*** est un **DNS** (nom de domaine) sur le serveur local. ``WampServer version 3+`` offre un assistant de création de VirtualHost.  
![Add a Virtual Host sous wampServer](img/01.png)  

Le formulaire suivant s'affiche :  
![formulaire VHost Wamp](img/02.png)  

Une fois validé, ouvrez le fichier **`C:/wamp/bin/apache/apache2.4.17/conf/extra/httpd-vhosts.conf`**  

    <VirtualHost *:80>  
      ServerName api.weatherfences.com  
      DocumentRoot c:/wamp/www/my-site/weatherfences/public  
      ErrorLog "c:/wamp/www/my-site/weatherfences/logs/wf_err.log"  
      CustomLog "c:/wamp/www/my-site/weatherfences/logs/wf_acc.log" common  
      <Directory  "c:/wamp/www/my-site/weatherfences/public/">  
        Options Indexes FollowSymLinks MultiViews  
        AllowOverride All  
        Allow from all  
        Require all granted  
      </Directory>  
    </VirtualHost>

***ServerName*** le nom du serveur renseigné dans le formulaire.  
***DocumentRoot*** le chemin "du point d'entrer de l'api". Ici il s'agit du fichier index.php dans le repertoire public.  
***ErrorLog*** chemin du fichier d'erreur. Toutes les erreurs seront logger dans ce fichier. Redirection des log d'erreur apache  
***CustomLog*** le chemin du fichier de log. dans ce fichier seront loggé toutes les actions faites sur ce server. redirection des log d'acces apache.  

Puis dans le fichier **``C:\WINDOWS\system32\drivers\etc\hosts``**  

    127.0.0.1		api.weatherfences.com  
    ::1			api.weatherfences.com  

### Demarrage de l'API  

Pour demarrer l'API il faut exécuté la commande ``composer start`` à la racine du projet.
Cette commande va lire la section **"scripts"** du fichier **composer.json** et exécuté la commande **"start"**.  
Comment se présente mon fichier composer.json à la fin.  
![fichier composer.json](img/03.png)  

N.B: Assurez vous que la commande **"start"** soit correct. Si vous vous utiliser un numéro de **port** autre que le **80** dans les configurations VHost, qu'il soit le même ici.  

#### Exécution d'une requête *POST*  

![POST request](img/04.png)

#### Exécution d'une requète *GET*  

![GET request](img/06.png)

#### Exécution Erronée *Mauvaise route*

![Bad Route](img/05.png)

#### Les logs en console

![Console Log](img/07.png)

N.B: dans les requete j'utilise le **ServerName**. Le résultat serai le même avec l'adresse locale **127.0.0.1** ou **localhost**. Si le port n'est pas le **80** on ajouterai le numéro de port sur l'url tel que suit : **``[url]:<port>``** ex: **``localhost:8088``** se connectera à l'adresse locale sur le port 8088.

## Acces depuis un mobile

Afin de facilité l'accés à un mobile,  

1. Assurez vous de ne pas avoir deux applications qui tournent sur le même port.  
1. Connectez le mobile et le serveur (PC) au même WiFi public (IP au format 192.168.X.Y)
1. Pour acceder à votre API, utilisé l'adresse IP (et uniquement l'IP) du serveur (PC) et le port (si différent de 80). On aura: **``[server IP]:<port>/{route}``**.  
    Ex: **``192.168.43.80:8088/v1/user/``**

Et voilà !!!
