<?php 
    require('../Model/MDBase_client.mod.php');
    $connect = new MDBase_client();
    switch($_POST['role']){

    	/**

    	News Handler
    	
    	**/

    	case "newspaper":
    		$total = $connect->countNewspapers(); 					// Nombre total de résultat
    		$perPage = 10;                   						// Nombre de resultat par page
    		$nbPage = ceil($total[0]['NB_NEWSPAPER'] / $perPage); 	// Nombre de page total (ceil permet d'arrondir au nombre supérieur)

    		if(isset($_GET['p']) AND $_GET['p'] > 0 AND $_GET['p'] <= $nbPage)
    		    $currentPage = $_GET['p'];    				// Page courante initialser avec le parametre de la fonction
    		else
    		    $currentPage = 1;            				// Page courante initialiser à 1 par défaut

	    	$result = $connect->getAllNewspapers($currentPage, $perPage);
	    	$jsonarray = array("newspaper" => $result, "page" => $currentPage, "nbPage" => $nbPage);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

    	case "news":
    		$total = $connect->countNewsFromNewspaper($_POST['id']); 					// Nombre total de résultat
    		$perPage = 1;                   						// Nombre de resultat par page
    		$nbPage = ceil($total[0]['NB_NEWS'] / $perPage); 	// Nombre de page total (ceil permet d'arrondir au nombre supérieur)

    		if(isset($_GET['p']) AND $_GET['p'] > 0 AND $_GET['p'] <= $nbPage)
    		    $currentPage = $_GET['p'];    				// Page courante initialser avec le parametre de la fonction
    		else
    		    $currentPage = 1;            				// Page courante initialiser à 1 par défaut

	    	$result = $connect->getNewsFromGame($_POST['id'], $currentPage, $perPage);
	    	$jsonarray = array("news" => $result, "newspaper"=>$_POST['id'], "page" => $currentPage, "nbPage" => $nbPage);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;  
?>