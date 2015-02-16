<?php

    require('Inc/require.inc.php');
    require('Inc/globals.inc.php');

    $EX = isset($_REQUEST['EX']) ? $_REQUEST['EX'] : 'home';

    switch($EX)
    {
        case 'home'     : home(); break;
        case 'header'   : head(); break;
        default : error();
    }

    require('./View/layout.view.php');

    function home()
    {
        global $page;
        $page['title'] = 'Home';
        $page['class'] = 'VHome';
        $page['method'] = 'showHtml';
        $page['arg'] = 'Html/home.php';
    }

    function head()
    {
        global $page;
        $page['class'] = 'VHeader';
        $page['method'] = 'showHtml';
        $page['arg'] = 'Html/header.php';
    }

    function error()
    {
        global $page;
        $page['title'] = 'Erreur 404 !';
        $page['class'] = 'VHtml';
        $page['method'] = 'showHtml';
        $page['arg'] = 'Html/unknown.html';
    }

?>