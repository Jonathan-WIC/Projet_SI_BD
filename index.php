<?php

    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 'on');
    header ('Content-Type: text/html; charset=utf-8');
    require('Inc/require.inc.php');
    require('Inc/globals.inc.php');
    $EX = isset($_REQUEST['EX']) ? $_REQUEST['EX'] : 'home';
    if(isset($_REQUEST['idPrev'])){
        $idPrev= $_REQUEST['idPrev'];
        $idNext= $_REQUEST['idNext'];
    }

    switch($EX)
    {
        case 'home'      : home();       break;
        case 'recup'     : recuperation(); break; // Presentation de la vue
        default : check($EX);
    }

    require('./View/layout.view.php');

    function check($EX)
    {
        require('Class/CRecMP.class.php'); // Appelle les méthodes de la classe pour verifier les données dans la BD
        global $eml; // Variable global pour afficher le mail dans le deuxième formulaire (où l'user changera son mot de passe)
        $dbverf = new CRecMP(); // Instantiation de la Classe CRecMP
        $value = $dbverf->selectMD5($EX); // Verification de la chaine de l'URL
        if(count($value)==0){ // Si le resultat de la request est 0 montre la page d'erreur
            error();
        }else{ // Sinon s'affichera le mail dans le formulaire de changement 
            $var = $dbverf->searchMail($EX);
            $eml = $var[0]["MAIL"];
            rec(); // Formulaire de changement 
        }
    }
    function home()
    {
        global $page;
        $page['title'] = 'Test';
        $page['class'] = 'VHome';
        $page['method'] = 'showHome';
        $page['arg'] = 'Html/accueil.php';
        $page['css'] = 'Css/accueil.css';
    }


    function error()
    {

        global $page;
        $page['title'] = 'Erreur 404 !';
        $page['class'] = 'VHtml';
        $page['method'] = 'showHtml';
        $page['arg'] = 'Html/unknown.php';
    }


?>
