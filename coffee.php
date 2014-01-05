<?php
// Cette vue spécial permet de retourner le fichier coffee au format js
header("Content-type: application/javascript");

require_once 'Utils/Base_config.php';

if(isset($_GET['s']) && $_GET['s'] != "") {
    if(file_exists(coffee_dir.$_GET['s'])) {
        $file = file_get_contents(coffee_dir.$_GET['s']);
        echo CoffeeScript\Compiler::compile($file, 
                                            array('filename' => $_GET['s'],
                                                  'header' => ''));
    }
    else {
        echo "//Le fichier spécifié n'existe pas ou est introuvable.";
    }
}
else {
    echo '//Aucun fichier Coffee spécifié.';
}
