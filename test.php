<?php
// Cette vue permet de tester la configuration minimale
require_once 'Utils/Base_config.php';

echo $twig->render('test.html', array('var_test' => 42));
