<?php

    $_GET['setComponents'] = 'develop';
    require_once("/var/www/vhosts/gekophetweb.nl/components/init.php");


    use Games\Controller\View;

    $view = new View();
    $view->display();