<?php
// Cette vue spécial permet de retourner le fichier scss au format css
header("Content-type: text/css");

require_once 'Utils/Base_config.php';

if(isset($_GET['s']) && $_GET['s'] != "") {
    if(file_exists(scss_dir.$_GET['s'])) {
        echo $scss->compile('@import "'. $_GET['s'] .'"');
    }
    else {
        echo "//Le fichier spécifié n'existe pas ou est introuvable.";
    }
}
else {
    echo '//Aucun fichier SCSS spécifié.';
}
