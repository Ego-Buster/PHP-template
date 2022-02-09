	/********************************/
	/*								*/
	/*	   Structure du projet		*/
	/*  écrit par D!m!tr! Bl@ck  	*/
	/*                              */
	/********************************/

	1) dossier /bd
	Contient le fichier SQL de la base de données exportée et le fichier de connexion au serveur

	2) dossier /class
	Contient toutes les classes relatives aux fonctionnalités du projet

	3) dossier /dashboard
	On trouve ici toute la partie réservée au contenue du dashboard (les pages étant organisées comme au numéro 7)

	4) dossier /files
	Tous les fichiers générés et/ou enregistrés sur le serveur

	5) dossier /images
	Toutes les images utilisées pour le front end

	6) dossier /js
	Contient tous les scripts javaScript globaux (importés par la plupart ou toutes les pages)

	7) dossier /pages
	Contient toutes les pages du projet... sachant que chaque page est constituée :
	- d'un fichier index qui sera le point d'entrée de la page
	- d'un fichier ayant le même nom que son dossier parent et qui représente le contenu de la page
	- d'un fichier css qui contient le style de la page
	- d'un fichier js qui contient son script JavaScript

	Exemple: pour le dossier home, on aura
	- index.php
	- home.php
	- home.css
	- home.js


	8) dossier /style
	Contient tous les styles css globaux (importés par la plupart ou toutes les pages)

	9) dossier /tools
	Il contient :
	- Un dossier "frameworks" qui regroupe l'ensemble des frameworks utilisés par le projet
	- Un dossier "init_functions" qui regroupe l'ensemble des fonctions php d'initialisation du projet
	- Un dossier "modules" qui regroupe l'ensemble des modules supplémentaires intégrés au projet
