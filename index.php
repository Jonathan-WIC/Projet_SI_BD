<?php

    require('Inc/require.inc.php');
    require('Inc/globals.inc.php');

    session_start();

    $EX = isset($_REQUEST['EX']) ? $_REQUEST['EX'] : 'home';

    switch($EX)
    {
        case 'home':        home();         break;
        case 'quest':       quest();        break;
        case 'parks':       parks();        break;
        case 'monsters':    monsters();     break;
        case 'news':        news();         break;
        case 'items':       items();        break;
        case 'logadmin':    logadmin();     break;
        /*case 'failLog':     failLog();      break;
        case 'failLog':     failLog();      break;*/
        case 'logspec':     logspec();      break;
        /*case 'failLog':     failLog();      break;
        case 'failLog':     failLog();      break;*/
        case 'logclient':   logclient();    break;
        case 'failLog':     failLog();      break;
        default : error();
    }

    require('./View/layout.view.php');

    function home()
    {

        session_unset ();
        session_destroy ();

        global $page;
        $page['title'] = 'Home';
        $page['class'] = 'VHtml';
        $page['method'] = 'showHtml';
        $page['arg'] = 'Html/home.php';
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

    function news()
    {
        global $page;
        $page['title'] = 'News';
        $page['class'] = 'VHtml';
        $page['method'] = 'showHtml';
        $page['arg'] = 'Html/news.php';
    }

    function items()
    {
        global $page;
        $page['title'] = 'Items';
        $page['class'] = 'VHtml';
        $page['method'] = 'showHtml';
        $page['arg'] = 'Html/items.php';
    }

    function logadmin()
    {
        global $page;
        $page['MDBase'] = 'administrateur';
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
    }
    
    function failLog()
    {
        global $page;
        $page['title'] = 'Home';
        $page['class'] = 'VHtml';
        $page['method'] = 'showHtml';
        $page['arg'] = 'Html/home.php';
        $page['errorMethod'] = 'showErrorLogin';
        $page['script'] = 'Js/showErrorLogin.js';
    }*/
    
    function logspec()
    {
        global $page;
        $_SESSION['model'] = 'MDBase_specialiste';
        monsters();
    }
    /*
    function failLog()
    {
        global $page;
        $page['title'] = 'Home';
        $page['class'] = 'VHtml';
        $page['method'] = 'showHtml';
        $page['arg'] = 'Html/home.php';
        $page['errorMethod'] = 'showErrorLogin';
        $page['script'] = 'Js/showErrorLogin.js';
    }
    
    function failLog()
    {
        global $page;
        $page['title'] = 'Home';
        $page['class'] = 'VHtml';
        $page['method'] = 'showHtml';
        $page['arg'] = 'Html/home.php';
        $page['errorMethod'] = 'showErrorLogin';
        $page['script'] = 'Js/showErrorLogin.js';
    }*/

    function logclient()
    {
        global $page;
        $_SESSION['model'] = 'MDBase_client';
        news();
    }
    
    function failLog()
    {
        global $page;
        $page['title'] = 'Home';
        $page['class'] = 'VHtml';
        $page['method'] = 'showHtml';
        $page['arg'] = 'Html/home.php';
        $page['errorMethod'] = 'showErrorLogin';
        $page['script'] = 'Js/showErrorLogin.js';
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