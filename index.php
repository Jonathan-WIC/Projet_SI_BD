<?php

    require('Inc/require.inc.php');
    require('Inc/globals.inc.php');

    $EX = isset($_REQUEST['EX']) ? $_REQUEST['EX'] : 'home';

    switch($EX)
    {
        case 'home':        home();         break;
        case 'connect':     connect();      break;
        case 'quest':       quest();        break;
        case 'parks':       parks();        break;
        case 'monsters':    monsters();     break;
        case 'items':       items();        break;
        case 'store':       store();        break;
        //case 'failLog':     failLog();      break;
        default : error();
    }

    require('./View/layout.view.php');

    function home()
    {
        global $page;
        $page['title'] = 'Home';
        $page['class'] = 'VHtml';
        $page['method'] = 'showHtml';
        $page['arg'] = 'Html/home.php';
    }

    function connect()
    {
        global $page;

    /**
    TODO
    *   Faire la condition de vérification de login. les résultats sont fonctionnels.
    **/
        if($logSuccess){
            $page['title'] = 'connect';
            $page['class'] = 'VHtml';
            $page['method'] = 'showHtml';
            $page['arg'] = 'Html/connect.php';
        } else{
            $page['title'] = 'Home';
            $page['class'] = 'VHtml';
            $page['method'] = 'showHtml';
            $page['arg'] = 'Html/home.php';
            $page['errorMethod'] = 'showErrorLogin';
            $page['script'] = 'Js/showErrorLogin.js';
        }
    }

    function quest()
    {
        global $page;
        $page['title'] = 'Quests';
        $page['class'] = 'VHtml';
        $page['method'] = 'showHtml';
        $page['arg'] = 'Html/quest.php';
    }

    function parks()
    {
        global $page;
        $page['title'] = 'parks';
        $page['class'] = 'VHtml';
        $page['method'] = 'showHtml';
        $page['arg'] = 'Html/parks.php';

    }

    function monsters()
    {
        global $page;
        $page['title'] = 'monsters';
        $page['class'] = 'VHtml';
        $page['method'] = 'showHtml';
        $page['arg'] = 'Html/monsters.php';
    }

    function items()
    {
        global $page;
        $page['title'] = 'Items';
        $page['class'] = 'VHtml';
        $page['method'] = 'showHtml';
        $page['arg'] = 'Html/items.php';
    }

    function error()
    {
        global $page;
        $page['title'] = 'Erreur 404 !';
        $page['class'] = 'VHtml';
        $page['method'] = 'showHtml';
        $page['arg'] = 'Html/unknown.html';
    }

/*    function failLog()
    {
        global $page;
        $page['title'] = 'Home';
        $page['class'] = 'VHtml';
        $page['method'] = 'showHtml';
        $page['arg'] = 'Html/home.php';
        $page['errorMethod'] = 'showErrorLogin';
        $page['script'] = 'Js/showErrorLogin.js';
    }*/
?>