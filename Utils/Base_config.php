<?php
/*
    Les configurations présentées ici sont utile au bon fonctionement de la solution.
    Vous devez les modifiers en connaissance de cause et à vos risques et périles.
*/

 /* * * * * * * * * * * * * * * *\
|      Configuration de base      |
 \* * * * * * * * * * * * * * * */

// La solution est en mode DEBUG
 define('debug', true);



 /* * * * * * * * * * * * * * * *\
|      Configuration de Twig      |
 \* * * * * * * * * * * * * * * */

// Dossier contenant les templates
 define('templates_dir', 'Templates/');

// Dossier contenant les fichiers statiques
 define('static_dir', templates_dir.'Static/');



 /* * * * * * * * * * * * * * * *\
|    Chargement des dépendances   |
 \* * * * * * * * * * * * * * * */

// Appel des loaders des dépendances
 require_once 'Dependencies/autoload.php';

// Initialisation de Twig
 require_once 'Utils/Twig_init.php';


