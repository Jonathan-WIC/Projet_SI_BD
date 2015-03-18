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

        case 'park':            park();         break;
        case 'parkDev':         parkDev();      break;

        case 'enclosure':       enclosure();    break;
        case 'enclosureDev':    enclosureDev(); break;

        case 'player':          player();       break;
        case 'playerDev':       playerDev();    break;

        case 'account':         account();      break;
        case 'accountDev':      accountDev();   break;

        case 'monsters':        monsters();     break;
        case 'monstersSpec':    monstersSpec(); break;
        case 'monstersDev':     monstersDev();  break;

        case 'specieSpec':      specieSpec();   break;
        case 'specieDev':       specieDev();    break;

        case 'subSpecieSpec':   subSpecieSpec();break;
        case 'subSpecieDev':    subSpecieDev(); break;

        case 'elementsSpec':    elementsSpec(); break;
        case 'elementsDev':     elementsDev();  break;

        case 'regimeSpec':      regimeSpec();   break;
        case 'regimeDev':       regimeDev();    break;

        case 'maturitySpec':    maturitySpec(); break;
        case 'maturityDev':     maturityDev();  break;

        case 'news':            news();         break;
        case 'newsClient':      newsClient();   break;
        case 'newsEdit':        newsEdit();     break;

        case 'items':           items();        break;
        case 'itemDev':         itemDev();      break;

        case 'logadmin':        logadmin();     break;
        case 'logdev':          logdev();       break;
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
        $page['script'] = 'Js/verifConnection.js';
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

    //Admin and dev can use this function to admin quest
    function questAdminQ()
    {
        $_SESSION['script'] = 'Js/questAdminQ.js';
        quest();
    }

    /**
    Access to park pages
    **/

    function park()
    {
        global $page;
        $page['title'] = 'parks';
        $page['class'] = 'VHtml';
        $page['method'] = 'showHtml';
        $page['arg'] = 'Html/park.php';

    }

    function parkDev()
    {
        $_SESSION['script'] = 'Js/parkDev.js';
        park();
    }

    /**
    Access to enclosure pages
    **/

    function enclosure()
    {
        global $page;
        $page['title'] = 'enclosure';
        $page['class'] = 'VHtml';
        $page['method'] = 'showHtml';
        $page['arg'] = 'Html/enclosure.php';

    }

    function enclosureDev()
    {
        $_SESSION['script'] = 'Js/enclosureDev.js';
        enclosure();
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

    function playerDev()
    {
        $_SESSION['script'] = 'Js/playerDev.js';
        player();
    }

    /**
    Access to Account pages
    **/

    function account()
    {
        global $page;
        $page['title'] = 'Account';
        $page['class'] = 'VHtml';
        $page['method'] = 'showHtml';
        $page['arg'] = 'Html/account.php';

    }

    function accountDev()
    {
        $_SESSION['script'] = 'Js/account.js';
        account();
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

    function monstersDev()
    {
        $_SESSION['script'] = 'Js/monstersDev.js';
        monsters();
    }

    /**
    Access to species pages
    **/

    function specieSpec(){
        $_SESSION['script'] = 'Js/specieSpec.js';
        global $page;
        $page['title'] = 'Species';
        $page['class'] = 'VHtml';
        $page['method'] = 'showHtml';
        $page['arg'] = 'Html/specie.php';
    }         

    function specieDev(){
        $_SESSION['script'] = 'Js/specieDev.js';
        global $page;
        $page['title'] = 'Species';
        $page['class'] = 'VHtml';
        $page['method'] = 'showHtml';
        $page['arg'] = 'Html/specie.php';
    }         

    /**
    Access to subSpecies pages
    **/

    function subSpecieSpec(){
        $_SESSION['script'] = 'Js/subSpecieSpec.js';
        global $page;
        $page['title'] = 'Sub Species';
        $page['class'] = 'VHtml';
        $page['method'] = 'showHtml';
        $page['arg'] = 'Html/subSpecie.php';
    }   

    function subSpecieDev(){
        $_SESSION['script'] = 'Js/subSpecieDev.js';
        global $page;
        $page['title'] = 'Sub Species';
        $page['class'] = 'VHtml';
        $page['method'] = 'showHtml';
        $page['arg'] = 'Html/subSpecie.php';
    }   

    /**
    Access to elements pages
    **/

    function elementsSpec(){
        $_SESSION['script'] = 'Js/elementSpec.js';
        global $page;
        $page['title'] = 'Elements';
        $page['class'] = 'VHtml';
        $page['method'] = 'showHtml';
        $page['arg'] = 'Html/element.php';
    }     

    function elementsDev(){
        $_SESSION['script'] = 'Js/elementDev.js';
        global $page;
        $page['title'] = 'Elements';
        $page['class'] = 'VHtml';
        $page['method'] = 'showHtml';
        $page['arg'] = 'Html/element.php';
    }     

    /**
    Access to regime pages
    **/

    function regimeSpec(){
        $_SESSION['script'] = 'Js/regimeSpec.js';
        global $page;
        $page['title'] = 'Regimes';
        $page['class'] = 'VHtml';
        $page['method'] = 'showHtml';
        $page['arg'] = 'Html/regime.php';
    }         

    function regimeDev(){
        $_SESSION['script'] = 'Js/regimeDev.js';
        global $page;
        $page['title'] = 'Regimes';
        $page['class'] = 'VHtml';
        $page['method'] = 'showHtml';
        $page['arg'] = 'Html/regime.php';
    }         

    /**
    Access to maturity pages
    **/

    function maturitySpec(){
        $_SESSION['script'] = 'Js/maturitySpec.js';
        global $page;
        $page['title'] = 'Maturity';
        $page['class'] = 'VHtml';
        $page['method'] = 'showHtml';
        $page['arg'] = 'Html/maturity.php';
    } 

    function maturityDev(){
        $_SESSION['script'] = 'Js/maturityDev.js';
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

    function itemDev()
    {
        $_SESSION['script'] = 'Js/itemDev.js';
        items();
    }


    /**

    Login functions
    
    **/

    function logadmin()
    {
        $_SESSION['model'] = 'MDBase_administrateur';
        monstersDev();
    }
    
    function logdev()
    {
        $_SESSION['model'] = 'MDBase_developpeur';
        monstersDev();
    }
    
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