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
