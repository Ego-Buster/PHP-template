<?php

//Nom du dossier du projet
$project_name="HIV-app";
  //Chemins par defaut du projet;
$root_path = $_SERVER["DOCUMENT_ROOT"]."/".$project_name."/";
  define('_APP_PATH', $root_path); // Pour les liens PHP
  define('_ROOT_PATH', "/".$project_name."/"); // Pour les liens HTML, JS et CSS
  ?>
