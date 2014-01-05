<?php
    $loader = new Twig_Loader_Filesystem(templates_dir);
    $twig = new Twig_Environment($loader, array(
      'cache' => !debug,
    ));

    $twig->addGlobal('STATIC', static_dir);
    $twig->addGlobal('SCSS', get_scss);
    $twig->addGlobal('COFFEE', get_coffee);
