<?php

    require 'Inc/require.inc.php';
    require 'Inc/globals.inc.php';

    session_start();

    $EX = isset($_REQUEST['EX']) ? $_REQUEST['EX'] : 'home';

    switch($EX)
    {
        case 'home':            home();         break;
        case 'quest':           quest();        break;
        case 'questClient':     questClient();  break;
        case 'questAdminQ':     questAdminQ();  break;
        case 'parks':           parks();        break;
        case 'player':          player();       break;
        case 'playerModo':      playerModo();   break;
        case 'monsters':        monsters();     break;
        case 'monstersSpec':    monstersSpec(); break;
        case 'specieSpec':      specieSpec();   break;
        case 'subSpecieSpec':   subSpecieSpec();break;
        case 'elementsSpec':    elementsSpec(); break;
        case 'regimeSpec':      regimeSpec();   break;
        case 'maturitySpec':    maturitySpec(); break;
        case 'news':            news();         break;
        case 'newsClient':      newsClient();   break;
        case 'newsEdit':        newsEdit();     break;
        case 'items':           items();        break;
        case 'logadmin':        logadmin();     break;
        /*case 'failLog':       failLog();      break;*/
        case 'logmod':          logmod();       break;
        case 'logspec':         logspec();      break;
        case 'logquest':        logquest();     break;
        case 'logedit':         logedit();      break;
        case 'logclient':       logclient();    break;
        case 'failLog':         failLog();      break;
        default :               error();
    }

    require './View/layout.view.php';

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

    function questClient()
    {
        $_SESSION['script'] = 'Js/questClient.js';
        quest();
    }

    function questAdminQ()
    {
        $_SESSION['script'] = 'Js/questAdminQ.js';
        quest();
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
    Access to Player pages
    **/

    function player()
    {
        global $page;
        $page['title'] = 'player';
        $page['class'] = 'VHtml';
        $page['method'] = 'showHtml';
        $page['arg'] = 'Html/player.php';

    }

    function playerModo()
    {
        $_SESSION['script'] = 'Js/playerModo.js';
        player();
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

    function newsClient()
    {
        $_SESSION['script'] = 'Js/newsClient.js';
        news();
    }

    function newsEdit()
    {
        $_SESSION['script'] = 'Js/newsEdit.js';
        news();
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
    }*/
    
    function logmod()
    {
        $_SESSION['model'] = 'MDBase_moderateur';
        playerModo();
    }
    
    function logspec()
    {
        $_SESSION['model'] = 'MDBase_specialiste';
        monstersSpec();
    }

    function logquest()
    {
        $_SESSION['model'] = 'MDBase_adminquest';
        questAdminQ();
    }
    
    function logedit()
    {
        $_SESSION['model'] = 'MDBase_editorialiste';
        newsEdit();
    }

    function logclient()
    {
        $_SESSION['model'] = 'MDBase_client';
        newsClient();
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