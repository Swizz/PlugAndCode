<?php
/* Copyright (c) 2014 GERODEL Quentin (aka Swizz540)

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE. */

/*
    Les configurations présentées ici sont utile au bon fonctionement de la solution.
    Vous devez les modifiers en connaissance de cause et à vos risques et périles.
*/

 /* * * * * * * * * * * * * * * *\
|      Configuration de base      |
 \* * * * * * * * * * * * * * * */

// La solution est en mode DEBUG
 define('debug', true);

// Chaine de connection à la base de données
 define('BDDstring', 'mysql:host=localhost;dbname=XXXXX');

// Nom de connection à la base de données
 define('BDDpseudo', '');

// Mot de passe de connection à la base données
 define('BDDpass', '');



 /* * * * * * * * * * * * * * * *\
|      Configuration de Twig      |
 \* * * * * * * * * * * * * * * */

// Dossier contenant les templates
 define('templates_dir', 'Templates/');

// Dossier contenant les fichiers statiques
 define('static_dir', templates_dir.'Static/');



 /* * * * * * * * * * * * * * * *\
|      Configuration de SCSS      |
 \* * * * * * * * * * * * * * * */

// Accesseur
 define('get_scss', 'scss.php?s');

// Dossier contenant les fichiers SCSS
 define('scss_dir', static_dir.'SCSS/');

// Format de sortie
 define('scss_format', 'scss_formatter_nested');



 /* * * * * * * * * * * * * * * *\
|  Configuration de CoffeeScript  |
 \* * * * * * * * * * * * * * * */

// Accesseur
 define('get_coffee', 'coffee.php?s');

// Dossier contenant les fichiers SCSS
 define('coffee_dir', static_dir.'JS/');

 /* * * * * * * * * * * * * * * *\
|    Chargement des dépendances   |
 \* * * * * * * * * * * * * * * */

// Si autoload est authorisé
if(!defined('autoload') || autoload) {

// Appel des loaders des dépendances
 require_once 'Dependencies/autoload.php';

// Initialisation de Twig
 require_once 'Utils/Twig_init.php';

// Initialisation de SCSS
 require_once 'Utils/SCSS_init.php';
}

