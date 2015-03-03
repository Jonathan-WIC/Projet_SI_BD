<?php

    require('Inc/require.inc.php');
    require('Inc/globals.inc.php');

    session_start();

    $EX = isset($_REQUEST['EX']) ? $_REQUEST['EX'] : 'home';

    switch($EX)
    {
        case 'home':            home();         break;
        case 'quest':           quest();        break;
        case 'parks':           parks();        break;
        case 'monsters':        monsters();     break;
        case 'monstersSpec':    monstersSpec(); break;
        case 'specieSpec':      specieSpec();   break;
        case 'subSpecieSpec':   subSpecieSpec();break;
        case 'elementsSpec':    elementsSpec(); break;
        case 'regimeSpec':      regimeSpec();   break;
        case 'maturitySpec':    maturitySpec(); break;
        case 'news':            news();         break;
        case 'items':           items();        break;
        case 'logadmin':        logadmin();     break;
        /*case 'failLog':       failLog();      break;
        case 'failLog':         failLog();      break;*/
        case 'logspec':         logspec();      break;
        /*case 'failLog':       failLog();      break;
        case 'failLog':         failLog();      break;*/
        case 'logclient':       logclient();    break;
        case 'failLog':         failLog();      break;
        default :               error();
    }

    require('./View/layout.view.php');


    /**

    Pages functions
    
    **/


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

    /**
    Access to quest pages
    **/

    function quest()
    {
        global $page;
        $page['title'] = 'Quests';
        $page['class'] = 'VHtml';
        $page['method'] = 'showHtml';
        $page['arg'] = 'Html/quest.php';
    }

    /**
    Access to park pages
    **/

    function parks()
    {
        global $page;
        $page['title'] = 'parks';
        $page['class'] = 'VHtml';
        $page['method'] = 'showHtml';
        $page['arg'] = 'Html/parks.php';

    }

    /**
    Access to monsters pages
    **/

    function monsters()
    {
        global $page;
        $page['title'] = 'monsters';
        $page['class'] = 'VHtml';
        $page['method'] = 'showHtml';
        $page['arg'] = 'Html/monsters.php';
    }

    function monstersSpec()
    {
        $_SESSION['script'] = 'Js/monstersSpec.js';
        monsters();
    }

    function specieSpec(){
        $_SESSION['script'] = 'JS/specieSpec.js';
        global $page;
        $page['title'] = 'Species';
        $page['class'] = 'VHtml';
        $page['method'] = 'showHtml';
        $page['arg'] = 'Html/specie.php';
    }         


    function subSpecieSpec(){
        $_SESSION['script'] = 'JS/subSpecieSpec.js';
        global $page;
        $page['title'] = 'Sub Species';
        $page['class'] = 'VHtml';
        $page['method'] = 'showHtml';
        $page['arg'] = 'Html/subSpecie.php';
    }   


    function elementsSpec(){
        $_SESSION['script'] = 'JS/elementSpec.js';
        global $page;
        $page['title'] = 'Elements';
        $page['class'] = 'VHtml';
        $page['method'] = 'showHtml';
        $page['arg'] = 'Html/element.php';
    }     


    function regimeSpec(){
        $_SESSION['script'] = 'JS/regimeSpec.js';
        global $page;
        $page['title'] = 'Regimes';
        $page['class'] = 'VHtml';
        $page['method'] = 'showHtml';
        $page['arg'] = 'Html/regime.php';
    }         


    function maturitySpec(){
        $_SESSION['script'] = 'JS/maturitySpec.js';
        global $page;
        $page['title'] = 'Maturity';
        $page['class'] = 'VHtml';
        $page['method'] = 'showHtml';
        $page['arg'] = 'Html/maturity.php';
    }     

    /**
    Access to news pages
    **/

    function news()
    {
        global $page;
        $page['title'] = 'News';
        $page['class'] = 'VHtml';
        $page['method'] = 'showHtml';
        $page['arg'] = 'Html/news.php';
    }

    /**
    Access to item pages
    **/

    function items()
    {
        global $page;
        $page['title'] = 'Items';
        $page['class'] = 'VHtml';
        $page['method'] = 'showHtml';
        $page['arg'] = 'Html/items.php';
    }

    /**

    Login functions
    
    **/

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
        monstersSpec();
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
        $_SESSION['model'] = 'MDBase_client';
        news();
    }
    

    /**

    Error functions
    
    **/


    function failLog()
    {
        global $page;
        $page['title'] = 'Home';
        $page['class'] = 'VHtml';
        $page['method'] = 'showHtml';
        $page['arg'] = 'Html/home.php';
        $page['errorMethod'] = 'showErrorLogin';
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