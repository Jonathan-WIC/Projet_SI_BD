<?php

    require('Inc/require.inc.php');
    require('Inc/globals.inc.php');

    $EX = isset($_REQUEST['EX']) ? $_REQUEST['EX'] : 'home';

    switch($EX)
    {
        case 'home':        home();         break;
        case 'actus':       actus();        break;
        case 'quest':       quest();        break;
        case 'myParks':     myParks();      break;
        case 'myMonsters':  myMonsters();   break;
        case 'myItems':     myItems();      break;
        case 'store':       store();        break;
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

    function actus()
    {
        global $page;
        $page['title'] = 'Actus';
        $page['class'] = 'VHtml';
        $page['method'] = 'showHtml';
        $page['arg'] = 'Html/actus.php';
    }

    function quest()
    {
        global $page;
        $page['title'] = 'Quests';
        $page['class'] = 'VHtml';
        $page['method'] = 'showHtml';
        $page['arg'] = 'Html/quest.php';
    }

    function myParks()
    {
        global $page;
        $page['title'] = 'Parks';
        $page['class'] = 'VHtml';
        $page['method'] = 'showHtml';
        $page['arg'] = 'Html/myParks.php';
    }

    function myMonsters()
    {
        global $page;
        $page['title'] = 'Monsters';
        $page['class'] = 'VHtml';
        $page['method'] = 'showHtml';
        $page['arg'] = 'Html/myMonsters.php';
    }

    function myItems()
    {
        global $page;
        $page['title'] = 'Items';
        $page['class'] = 'VHtml';
        $page['method'] = 'showHtml';
        $page['arg'] = 'Html/myItems.php';
    }

    function store()
    {
        global $page;
        $page['title'] = 'Items';
        $page['class'] = 'VHtml';
        $page['method'] = 'showHtml';
        $page['arg'] = 'Html/store.php';
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