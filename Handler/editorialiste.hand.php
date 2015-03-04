<?php 
    require('../Model/MDBase_editorialiste.mod.php');
    $connect = new MDBase_editorialiste();
    switch($_POST['role']){

        /**

        Newspaper Handler
        
        **/

        case "newspaper":
            $total = $connect->countNewspapers();                   // Nombre total de résultat
            $perPage = 10;                                          // Nombre de resultat par page
            $nbPage = ceil($total[0]['NB_NEWSPAPER'] / $perPage);   // Nombre de page total (ceil permet d'arrondir au nombre supérieur)

            if(isset($_GET['p']) AND $_GET['p'] > 0 AND $_GET['p'] <= $nbPage)
                $currentPage = $_GET['p'];                  // Page courante initialser avec le parametre de la fonction
            else
                $currentPage = 1;                           // Page courante initialiser à 1 par défaut

            $result = $connect->getAllNewspapers($currentPage, $perPage);
            $jsonarray = array("newspaper" => $result, "page" => $currentPage, "nbPage" => $nbPage);
            $jsonReturned = json_encode($jsonarray);
            echo $jsonReturned;
        break;

        case "infosNewspapers":
            $result = $connect->getNewspaperInfos($_POST['id']);
            $jsonarray = array("newspaper" => $result);
            $jsonReturned = json_encode($jsonarray);
            echo $jsonReturned;
        break;

        case "updateNewspaper":
            $result = $connect->updateNewspaper($_POST['id'], $_POST['data']);
            $jsonarray = array("result" => $result);
            $jsonReturned = json_encode($jsonarray);
            echo $jsonReturned;
        break;

        case "publishNewspaper":
            $result = $connect->publishNewspaper($_POST['id']);
            $jsonarray = array("result" => $result);
            $jsonReturned = json_encode($jsonarray);
            echo $jsonReturned;
        break;

        case "deleteNewspaper":
            $result = $connect->deleteNews($_POST['id']);
            $result = $connect->deleteNewspaper($_POST['id']);
            $jsonarray = array("result" => $result);
            $jsonReturned = json_encode($jsonarray);
            echo $jsonReturned;
        break;

        case "deleteMultipleNewspaper":
            $result = $connect->deleteMultipleNews($_POST['data']);
            $result = $connect->deleteMultipleNewspaper($_POST['data']);
            $jsonarray = array("result" => $result);
            $jsonReturned = json_encode($jsonarray);
            echo $jsonReturned;
        break;

        case "insertNewspaper":
            $result = $connect->insertNewspaper($_POST['data']);
            $jsonarray = array("result" => $result);
            $jsonReturned = json_encode($jsonarray);
            echo $jsonReturned;
        break;
 

    	/**

    	NewsHandler
    	
    	**/


        case "news":
            $total = $connect->countNewsFromNewspaper($_POST['id']);                    // Nombre total de résultat
            $perPage = 1;                                           // Nombre de resultat par page
            $nbPage = ceil($total[0]['NB_NEWS'] / $perPage);    // Nombre de page total (ceil permet d'arrondir au nombre supérieur)

            if(isset($_GET['p']) AND $_GET['p'] > 0 AND $_GET['p'] <= $nbPage)
                $currentPage = $_GET['p'];                  // Page courante initialser avec le parametre de la fonction
            else
                $currentPage = 1;                           // Page courante initialiser à 1 par défaut

            $result = $connect->getNewsFromGame($_POST['id'], $currentPage, $perPage);
            $jsonarray = array("news" => $result, "newspaper"=>$_POST['id'], "page" => $currentPage, "nbPage" => $nbPage);
            $jsonReturned = json_encode($jsonarray);
            echo $jsonReturned;
        break; 

        case "deleteNews":
            $result = $connect->deleteNews($_POST['id']);
            $jsonarray = array("news" => $result);
            $jsonReturned = json_encode($jsonarray);
            echo $jsonReturned;
        break; 

    	/*case "infosNews":
    		$result = $connect->getNewsInfo($_POST['id'], $currentPage, $perPage);
	    	$jsonarray = array("news" => $result, "newspaper"=>$_POST['id'], "page" => $currentPage, "nbPage" => $nbPage);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;*/

    }
?>