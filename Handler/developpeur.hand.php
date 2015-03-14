<?php 
    require '../Model/MDBase_developpeur.mod.php';
    $connect = new MDBase_developpeur();
    switch($_POST['role']){

    	/**

    	Monster Cases
    	
    	**/

    	case "tableMonster":
    		$total = $connect->countMonsters(); 			// Nombre total de résultat
    		$perPage = 10;                   				// Nombre de resultat par page
    		$nbPage = ceil($total[0]['NB_MOB'] / $perPage); // Nombre de page total (ceil permet d'arrondir au nombre supérieur)

    		if(isset($_GET['p']) AND $_GET['p'] > 0 AND $_GET['p'] <= $nbPage)
    		    $currentPage = $_GET['p'];    				// Page courante initialser avec le parametre de la fonction
    		else
    		    $currentPage = 1;            				// Page courante initialiser à 1 par défaut

	    	$monsters = $connect->getMonstersInfos($currentPage, $perPage);
	    	$monstersElements = $connect->getMonstersElementsInfos();
	    	$jsonarray = array("infos" => $monsters, "element" => $monstersElements, "page" => $currentPage, "nbPage" => $nbPage);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;
    	case "infosMonster": 
	    	$monsterInfo = $connect->getMonsterInfos($_POST['id']);
		    $monsterElement = $connect->getMonsterElementsInfos($_POST['id']);
			$jsonarray = array("infos" => $monsterInfo, "element" => $monsterElement);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;
    	case "updateElemMonster":
    		if (!isset($_POST['data'])) {
    		    $_POST['data'] = 0;
    		}
	    	$result = $connect->updateElemMonster($_POST['id'], $_POST['data']);
			$jsonarray = array("result" => $result);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;
    	case "updateMonster":
	    	$result = $connect->updateMonster($_POST['id'], $_POST['data']);
			$jsonarray = array("result" => $result);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;
    	case "deleteMonster":
	    	$result = $connect->deleteMonster($_POST['id']);
			$jsonarray = array("result" => $result);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;
    	case "deleteMultipleMonster":

    		for($i = 0 ; $i < count($_POST['data']) ; ++$i) {
    			$result = $connect->deleteMonster($_POST['data'][$i]);
    		}

			$jsonarray = array("result" => $result);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;
    	case "addMonster":
    		$result = $connect->addMonster($_POST['data']);
    		$result = $connect->updateElemMonster($result, $_POST['elem']);
			$jsonarray = array("result" => $result);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

		/**

		Species Cases

		**/

    	case "tableSpecie":

    		$total = $connect->countSpecies(); 					// Nombre total de résultat
    		$perPage = 20;                   					// Nombre de resultat par page
    		$nbPage = ceil($total[0]['NB_SPECIES'] / $perPage); // Nombre de page total (ceil permet d'arrondir au nombre supérieur)

    		if(isset($_GET['p']) AND $_GET['p'] > 0 AND $_GET['p'] <= $nbPage)
    		    $currentPage = $_GET['p'];    				// Page courante initialser avec le parametre de la fonction
    		else
    		    $currentPage = 1;            				// Page courante initialiser à 1 par défaut

	    	$species = $connect->fillSpecieTable($currentPage, $perPage);
			$jsonarray = array("specie" => $species, "page" => $currentPage, "nbPage" => $nbPage);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

    	case "infosSpecies":
    		$speciesInfos = $connect->getSpecieInfos($_POST['id']);
			$jsonarray = array("specieInfos" => $speciesInfos);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

    	case "updateSpecie":
    		$result = $connect->updateSpecie($_POST['id'], $_POST['data']);
			$jsonarray = array("result" => $result);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

		/**

		Sub Specie Cases

		**/

    	case "tableSubSpecie":

    		$total = $connect->countSubSpecies(); 					// Nombre total de résultat
    		$perPage = 20;                   						// Nombre de resultat par page
    		$nbPage = ceil($total[0]['NB_SUB_SPECIE'] / $perPage); 	// Nombre de page total (ceil permet d'arrondir au nombre supérieur)

    		if(isset($_GET['p']) AND $_GET['p'] > 0 AND $_GET['p'] <= $nbPage)
    		    $currentPage = $_GET['p'];    						// Page courante initialser avec le parametre de la fonction
    		else
    		    $currentPage = 1;            						// Page courante initialiser à 1 par défaut

	    	$subSpecies = $connect->fillSubSpecieTable($currentPage, $perPage);
			$jsonarray = array("subSpecie" => $subSpecies, "page" => $currentPage, "nbPage" => $nbPage);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

    	case "infosSubSpecies":
    		$subSpeciesInfos = $connect->getSubSpecieInfos($_POST['id']);
			$jsonarray = array("subSpecieInfos" => $subSpeciesInfos);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

    	case "updateSubSpecie":
    		$result = $connect->updateSubSpecie($_POST['id'], $_POST['data']);
			$jsonarray = array("result" => $result);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

		/**

		Element Cases

		**/

    	case "tableElement":

    		$total = $connect->countElement(); 						// Nombre total de résultat
    		$perPage = 20;                   						// Nombre de resultat par page
    		$nbPage = ceil($total[0]['NB_ELEMENT'] / $perPage); 	// Nombre de page total (ceil permet d'arrondir au nombre supérieur)

    		if(isset($_GET['p']) AND $_GET['p'] > 0 AND $_GET['p'] <= $nbPage)
    		    $currentPage = $_GET['p'];    						// Page courante initialser avec le parametre de la fonction
    		else
    		    $currentPage = 1;            						// Page courante initialiser à 1 par défaut

	    	$elements = $connect->fillElementTable($currentPage, $perPage);
			$jsonarray = array("element" => $elements, "page" => $currentPage, "nbPage" => $nbPage);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

    	case "infosElements":
    		$elementsInfos = $connect->getElementInfos($_POST['id']);
			$jsonarray = array("elementInfos" => $elementsInfos);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

    	case "updateElement":
    		$result = $connect->updateElement($_POST['id'], $_POST['data']);
			$jsonarray = array("result" => $result);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

    	case "deleteElement":
    		$result = $connect->deleteElement($_POST['id']);
			$jsonarray = array("result" => $result);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

    	case "deleteMultipleElement":
    		for($i = 0 ; $i < count($_POST['data']) ; ++$i) {
    			$result = $connect->deleteElement($_POST['data'][$i]);
    		}

			$jsonarray = array("result" => $result);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

    	case "addElement":
    		$result = $connect->addElement($_POST['data']);
			$jsonarray = array("result" => $result);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

		/**

		Regime Cases

		**/

    	case "tableRegime":

    		$total = $connect->countRegime(); 						// Nombre total de résultat
    		$perPage = 20;                   						// Nombre de resultat par page
    		$nbPage = ceil($total[0]['NB_REGIME'] / $perPage); 	// Nombre de page total (ceil permet d'arrondir au nombre supérieur)

    		if(isset($_GET['p']) AND $_GET['p'] > 0 AND $_GET['p'] <= $nbPage)
    		    $currentPage = $_GET['p'];    						// Page courante initialser avec le parametre de la fonction
    		else
    		    $currentPage = 1;            						// Page courante initialiser à 1 par défaut

	    	$regimes = $connect->fillRegimeTable($currentPage, $perPage);
			$jsonarray = array("regime" => $regimes, "page" => $currentPage, "nbPage" => $nbPage);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

    	case "infosRegimes":
    		$regimesInfos = $connect->getRegimeInfos($_POST['id']);
			$jsonarray = array("regimeInfos" => $regimesInfos);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

    	case "updateRegime":
    		$result = $connect->updateRegime($_POST['id'], $_POST['data']);
			$jsonarray = array("result" => $result);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

		/**

		Maturity Cases

		**/

    	case "tableMaturity":

    		$total = $connect->countMaturity(); 				// Nombre total de résultat
    		$perPage = 20;                   					// Nombre de resultat par page
    		$nbPage = ceil($total[0]['NB_MATURITY'] / $perPage); 	// Nombre de page total (ceil permet d'arrondir au nombre supérieur)

    		if(isset($_GET['p']) AND $_GET['p'] > 0 AND $_GET['p'] <= $nbPage)
    		    $currentPage = $_GET['p'];    						// Page courante initialser avec le parametre de la fonction
    		else
    		    $currentPage = 1;            						// Page courante initialiser à 1 par défaut

	    	$maturity = $connect->fillMaturityTable($currentPage, $perPage);
			$jsonarray = array("maturity" => $maturity, "page" => $currentPage, "nbPage" => $nbPage);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

    	case "infosMaturitys":
    		$maturityInfos = $connect->getMaturityInfos($_POST['id']);
			$jsonarray = array("maturityInfos" => $maturityInfos);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

    	case "updateMaturity":
    		$result = $connect->updateMaturity($_POST['id'], $_POST['data']);
			$jsonarray = array("result" => $result);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

		/**

		getAll() Cases
    	
    	**/

    	case "specie": 
	    	$species = $connect->getAllSpecies();
			$jsonarray = array("specie" => $species);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;
    	case "subSpecie": 
	    	$subSpecies = $connect->getAllSubSpecies();
			$jsonarray = array("subSpecie" => $subSpecies);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;
    	case "maturity": 
	    	$maturity = $connect->getAllMaturityLevels();
			$jsonarray = array("maturity" => $maturity);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;
    	case "regime": 
	    	$regime = $connect->getAllRegimes();
			$jsonarray = array("regime" => $regime);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;
    	case "element": 
	    	$elements = $connect->getAllElements();
			$jsonarray = array("element" => $elements);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;
    }
    
?>