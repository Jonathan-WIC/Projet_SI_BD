<?php 

	//petite fonction pour filtrer le nom des fichier (remplace les accents et les apostrophes etc...), elle devrait pas se trouver là mais on va faire comme si on avait rien vu :3
	function replace_accents($string){ 
	        return str_replace( array('à','á','â','ã','ä', 'ç', 'è','é','ê','ë', 'ì','í','î','ï', 'ñ', 'ò','ó','ô','õ','ö', 'ù','ú','û','ü', 'ý','ÿ', 'À','Á','Â','Ã','Ä', 'Ç', 'È','É','Ê','Ë', 'Ì','Í','Î','Ï', 'Ñ', 'Ò','Ó','Ô','Õ','Ö', 'Ù','Ú','Û','Ü', 'Ý', '\''), array('a','a','a','a','a', 'c', 'e','e','e','e', 'i','i','i','i', 'n', 'o','o','o','o','o', 'u','u','u','u', 'y','y', 'A','A','A','A','A', 'C', 'E','E','E','E', 'I','I','I','I', 'N', 'O','O','O','O','O', 'U','U','U','U', 'Y', '_'), $string);
	}

    require '../Model/MDBase_developpeur.mod.php';
    $connect = new MDBase_developpeur();
    switch($_POST['role']){

    	/**

    	Monster Cases
    	
    	**/

    	case "tableMonster":
    		$total = $connect->countMonsters($_POST['data']); 			// Nombre total de résultat
    		$perPage = 10;                   				// Nombre de resultat par page
    		$nbPage = ceil($total[0]['NB_MOB'] / $perPage); // Nombre de page total (ceil permet d'arrondir au nombre supérieur)

    		if(isset($_GET['p']) AND $_GET['p'] > 0 AND $_GET['p'] <= $nbPage)
    		    $currentPage = $_GET['p'];    				// Page courante initialser avec le parametre de la fonction
    		else
    		    $currentPage = 1;            				// Page courante initialiser à 1 par défaut

	    	$monsters = $connect->getMonstersInfos($currentPage, $perPage, $_POST['data']);
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

    		$total = $connect->countSpecies($_POST['data']); 					// Nombre total de résultat
    		$perPage = 20;                   					// Nombre de resultat par page
    		$nbPage = ceil($total[0]['NB_SPECIES'] / $perPage); // Nombre de page total (ceil permet d'arrondir au nombre supérieur)

    		if(isset($_GET['p']) AND $_GET['p'] > 0 AND $_GET['p'] <= $nbPage)
    		    $currentPage = $_GET['p'];    					// Page courante initialser avec le parametre de la fonction
    		else
    		    $currentPage = 1;            					// Page courante initialiser à 1 par défaut

	    	$species = $connect->fillSpecieTable($currentPage, $perPage, $_POST['data']);
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

    	case "deleteSpecie":
    		$subSpecie = $connect->selectSubSpecieFromSpecie($_POST['id']);
    		for($i = 0 ; $i < count($subSpecie) ; ++$i)
    		{
    			$connect->deleteSubSpecie($subSpecie[$i]['ID_SUB_SPECIE']);
    		}
    		$connect->deleteMonster(0);
    		$result = $connect->deleteSpecie($_POST['id']);

			$jsonarray = array("result" => $result);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

    	case "addSpecie":
    		$result = $connect->addSpecie($_POST['data']);
			$jsonarray = array("result" => $result);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

		/**

		Sub Specie Cases

		**/

    	case "tableSubSpecie":

    		$total = $connect->countSubSpecies($_POST['data']); 					// Nombre total de résultat
    		$perPage = 20;                   						// Nombre de resultat par page
    		$nbPage = ceil($total[0]['NB_SUB_SPECIE'] / $perPage); 	// Nombre de page total (ceil permet d'arrondir au nombre supérieur)

    		if(isset($_GET['p']) AND $_GET['p'] > 0 AND $_GET['p'] <= $nbPage)
    		    $currentPage = $_GET['p'];    						// Page courante initialser avec le parametre de la fonction
    		else
    		    $currentPage = 1;            						// Page courante initialiser à 1 par défaut

	    	$subSpecies = $connect->fillSubSpecieTable($currentPage, $perPage, $_POST['data']);
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

    	case "deleteSubSpecie":
    		$result = $connect->deleteSubSpecie($_POST['id']);
    		$connect->deleteMonster(0);
			$jsonarray = array("result" => $result);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

    	case "deleteMultipleSubSpecie":
    		for($i = 0 ; $i < count($_POST['data']) ; ++$i) {
    			$result = $connect->deleteSubSpecie($_POST['data'][$i]);
    		}
    		$connect->deleteMonster(0);
			$jsonarray = array("result" => $result);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

    	case "addSubSpecie":
    		$result = $connect->addSubSpecie($_POST['data']);
			$jsonarray = array("result" => $result);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

		/**

		Element Cases

		**/

    	case "tableElement":

    		$total = $connect->countElement($_POST['data']); 						// Nombre total de résultat
    		$perPage = 20;                   						// Nombre de resultat par page
    		$nbPage = ceil($total[0]['NB_ELEMENT'] / $perPage); 	// Nombre de page total (ceil permet d'arrondir au nombre supérieur)

    		if(isset($_GET['p']) AND $_GET['p'] > 0 AND $_GET['p'] <= $nbPage)
    		    $currentPage = $_GET['p'];    						// Page courante initialser avec le parametre de la fonction
    		else
    		    $currentPage = 1;            						// Page courante initialiser à 1 par défaut

	    	$elements = $connect->fillElementTable($currentPage, $perPage, $_POST['data']);
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

    		$total = $connect->countRegime($_POST['data']); 						// Nombre total de résultat
    		$perPage = 20;                   						// Nombre de resultat par page
    		$nbPage = ceil($total[0]['NB_REGIME'] / $perPage); 	// Nombre de page total (ceil permet d'arrondir au nombre supérieur)

    		if(isset($_GET['p']) AND $_GET['p'] > 0 AND $_GET['p'] <= $nbPage)
    		    $currentPage = $_GET['p'];    						// Page courante initialser avec le parametre de la fonction
    		else
    		    $currentPage = 1;            						// Page courante initialiser à 1 par défaut

	    	$regimes = $connect->fillRegimeTable($currentPage, $perPage, $_POST['data']);
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

    	case "deleteRegime":
    		$result = $connect->deleteRegime($_POST['id']);
			$jsonarray = array("result" => $result);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

    	case "deleteMultipleRegime":
    		for($i = 0 ; $i < count($_POST['data']) ; ++$i) {
    			$result = $connect->deleteRegime($_POST['data'][$i]);
    		}

			$jsonarray = array("result" => $result);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

    	case "addRegime":
    		$result = $connect->addRegime($_POST['data']);
			$jsonarray = array("result" => $result);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

		/**

		Maturity Cases

		**/

    	case "tableMaturity":

    		$total = $connect->countMaturity($_POST['data']); 				// Nombre total de résultat
    		$perPage = 20;                   					// Nombre de resultat par page
    		$nbPage = ceil($total[0]['NB_MATURITY'] / $perPage); 	// Nombre de page total (ceil permet d'arrondir au nombre supérieur)

    		if(isset($_GET['p']) AND $_GET['p'] > 0 AND $_GET['p'] <= $nbPage)
    		    $currentPage = $_GET['p'];    						// Page courante initialser avec le parametre de la fonction
    		else
    		    $currentPage = 1;            						// Page courante initialiser à 1 par défaut

	    	$maturity = $connect->fillMaturityTable($currentPage, $perPage, $_POST['data']);
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

    	case "deleteMaturity":
    		$result = $connect->deleteMaturity($_POST['id']);
			$jsonarray = array("result" => $result);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

    	case "deleteMultipleMaturity":
    		for($i = 0 ; $i < count($_POST['data']) ; ++$i) {
    			$result = $connect->deleteMaturity($_POST['data'][$i]);
    		}

			$jsonarray = array("result" => $result);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

    	case "addMaturity":
    		$result = $connect->addMaturity($_POST['data']);
			$jsonarray = array("result" => $result);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

		/**

        Quest Handler
        
        **/

        case "fillItems":
            $result = $connect->fillItemSelect();
            $jsonarray = array("item" => $result);
            $jsonReturned = json_encode($jsonarray);
            echo $jsonReturned;
        break;

        case "tableQuest":
            $total = $connect->countQuests($_POST['data']);                   // Nombre total de résultat
            $perPage = 20;                                      // Nombre de resultat par page
            $nbPage = ceil($total[0]['NB_QUESTS'] / $perPage);  // Nombre de page total (ceil permet d'arrondir au nombre supérieur)

            if(isset($_GET['p']) AND $_GET['p'] > 0 AND $_GET['p'] <= $nbPage)
                $currentPage = $_GET['p'];                  // Page courante initialser avec le parametre de la fonction
            else
                $currentPage = 1;                           // Page courante initialiser à 1 par défaut

            $resultItem = $connect->getAllQuestsItem();
            $result = $connect->getAllQuests($currentPage, $perPage, $_POST['data']);
            $jsonarray = array("quest" => $result, "item" => $resultItem, "page" => $currentPage, "nbPage" => $nbPage);
            $jsonReturned = json_encode($jsonarray);
            echo $jsonReturned;
        break;

        case "infosQuests":
            $resultItem = $connect->getQuestItemInfos($_POST['id']);
            $result = $connect->getQuestInfos($_POST['id']);
            $jsonarray = array("quest" => $result, "item" => $resultItem);
            $jsonReturned = json_encode($jsonarray);
            echo $jsonReturned;
        break;

        case "updateQuest":
            $resultItem = $connect->updateQuestItem($_POST['id'], $_POST['reward']);
            $result = $connect->updateQuest($_POST['id'], $_POST['data']);
            $jsonarray = array("result" => $result, "resultItem" => $resultItem);
            $jsonReturned = json_encode($jsonarray);
            echo $jsonReturned;
        break;

        case "deleteQuest":
            $result = $connect->deleteQuest($_POST['id']);
            $jsonarray = array("result" => $result);
            $jsonReturned = json_encode($jsonarray);
            echo $jsonReturned;
        break;

        case "deleteMultipleQuest":
            $result = $connect->deleteMultipleQuest($_POST['data']);
            $jsonarray = array("result" => $result);
            $jsonReturned = json_encode($jsonarray);
            echo $jsonReturned;
        break;

        case "insertQuest":
            $result = $connect->insertQuest($_POST['data']);
            $resultItem = $connect->insertQuestItem($result, $_POST['data_reward']);
            $jsonarray = array("result" => $result, "result" => $resultItem);
            $jsonReturned = json_encode($jsonarray);
            echo $jsonReturned;
        break;

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

    	News Handler
    	
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

        case "infosNews":
            $result = $connect->getNewsInfo($_POST['id']);
            $jsonarray = array("news" => $result);
            $jsonReturned = json_encode($jsonarray);
            echo $jsonReturned;
        break;

        case "updateNews":

            $repertoireDestination = "../Img/";

            $nomOrigine = $_FILES["updateImage"]["name"];
            $pathImage = "";

            //On check s'il y a une image, s'il y en a une, on la traite
            if(strlen($nomOrigine) != 0){
                
                $elementsChemin = pathinfo($nomOrigine);
                $extensionFichier = $elementsChemin['extension'];
                $sanitizeFileName = replace_accents($_FILES["updateImage"]["name"]);

                $pathImage = $repertoireDestination. $sanitizeFileName;

                    //Check if the size of the image is correct
                if($_FILES["updateImage"]["size"] < 6000000){

                    //Check if the file is correctly moved
                    if (move_uploaded_file($_FILES["updateImage"]["tmp_name"],$pathImage)) {
                        $result = true;
                    } else{
                        $errorType = "Err_UploadFail";
                        return $errorType;
                    }

                }else{
                    $errorType = "Err_FileTooFat";
                    return $errorType;
                }

            }

            $data = array("id" => $_POST['recupNewsId'], "title" => $_POST['updateTitle'], "content" => $_POST['updateContent'], "image" => $pathImage);

            $result = $connect->updateNews($data);
            $jsonarray = array("news" => $result);
            $jsonReturned = json_encode($jsonarray);
            echo $jsonReturned;
        break;

        case "createNews":

            $repertoireDestination = "../Img/";

            $nomOrigine = $_FILES["addImage"]["name"];
            $pathImage = "";

            //On check s'il y a une image, s'il y en a une, on la traite
            if(strlen($nomOrigine) != 0){
                
                $elementsChemin = pathinfo($nomOrigine);
                $extensionFichier = $elementsChemin['extension'];
                $sanitizeFileName = replace_accents($_FILES["addImage"]["name"]);

                $pathImage = $repertoireDestination. $sanitizeFileName;

                    //Check if the size of the image is correct
                if($_FILES["addImage"]["size"] < 6000000){

                    //Check if the file is correctly moved
                    if (move_uploaded_file($_FILES["addImage"]["tmp_name"],$pathImage)) {
                        $result = true;
                    } else{
                        $errorType = "Err_UploadFail";
                        return $errorType;
                    }

                }else{
                    $errorType = "Err_FileTooFat";
                    return $errorType;
                }

            }

            $data = array("id" => $_POST['recupNewspaperId'], "title" => $_POST['addTitle'], "content" => $_POST['addContent'], "image" => $pathImage);

            $result = $connect->insertNews($data);
            $jsonarray = array("news" => $result);
            $jsonReturned = json_encode($jsonarray);
            echo $jsonReturned;
        break;

        case "deleteNews":
            $result = $connect->deleteNews($_POST['id']);
            $jsonarray = array("news" => $result);
            $jsonReturned = json_encode($jsonarray);
            echo $jsonReturned;
        break; 

		/**

		Account Cases

		**/

    	case "tableAccount":

    		$total = $connect->countAccount($_POST['dataTable']); 					// Nombre total de résultat
    		$perPage = 20;                   					// Nombre de resultat par page
    		$nbPage = ceil($total[0]['NB_ACCOUNT'] / $perPage); // Nombre de page total (ceil permet d'arrondir au nombre supérieur)

    		if(isset($_GET['p']) AND $_GET['p'] > 0 AND $_GET['p'] <= $nbPage)
    		    $currentPage = $_GET['p'];    				// Page courante initialser avec le parametre de la fonction
    		else
    		    $currentPage = 1;            				// Page courante initialiser à 1 par défaut

	    	$accounts = $connect->fillAccountTable($currentPage, $perPage, $_POST['dataTable']);
	    	$persos = $connect->getPersoAccount($accounts);

			$jsonarray = array("account" => $accounts, "perso" => $persos, "page" => $currentPage, "nbPage" => $nbPage);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

    	case "infosAccounts":
    		$accountsInfos = $connect->getAccountInfos($_POST['id']);
			$jsonarray = array("accountInfos" => $accountsInfos);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

    	case "updateAccount":
    		$result = $connect->updateAccount($_POST['id'], $_POST['data']);
			$jsonarray = array("result" => $result);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

    	case "deleteAccount":
    		$perso = $connect->selectPersoFromAccount($_POST['id']);
    		for($i = 0 ; $i < count($perso) ; ++$i)
    		{
    			$connect->deletePlayer($perso[$i]['ID_PERSO']);
    		}
    		$result = $connect->deleteAccount($_POST['id']);	
			$jsonarray = array("result" => $result);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

    	case "addAccount":
    		$result = $connect->addAccount($_POST['data']);
			$jsonarray = array("result" => $result);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

		/**

		PLAYER Cases

		**/

    	case "tablePlayer":

    		$total = $connect->countPlayer($_POST['data']); 					// Nombre total de résultat
    		$perPage = 20;                   					// Nombre de resultat par page
    		$nbPage = ceil($total[0]['NB_PERSO'] / $perPage); // Nombre de page total (ceil permet d'arrondir au nombre supérieur)

    		if(isset($_GET['p']) AND $_GET['p'] > 0 AND $_GET['p'] <= $nbPage)
    		    $currentPage = $_GET['p'];    				// Page courante initialser avec le parametre de la fonction
    		else
    		    $currentPage = 1;            				// Page courante initialiser à 1 par défaut

	    	$player = $connect->fillPlayerTable($currentPage, $perPage, $_POST['data']);
	    	$quest = $connect->getPlayerQuest($player);
	    	$park = $connect->getPlayerpark($player);
	    	$monster = $connect->getPlayerMonster($player);
	    	$item = $connect->getPlayerItem($player);

			$jsonarray = array("player" => $player, "quest" => $quest, "park" => $park, "monster" => $monster, "item" => $item, "page" => $currentPage, "nbPage" => $nbPage);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

    	case "infosPlayers":
    		$playerInfos = $connect->getPlayerInfos($_POST['id']);
			$jsonarray = array("playerInfos" => $playerInfos);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

    	case "updatePlayer":
    		$result = $connect->updatePlayer($_POST['id'], $_POST['data']);
			$jsonarray = array("result" => $result);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

    	case "deletePlayer":
    		$result = $connect->deletePlayer($_POST['id']);
			$jsonarray = array("result" => $result);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

    	case "deleteMultiplePlayer":
    		for($i = 0 ; $i < count($_POST['data']) ; ++$i) {
    			$result = $connect->deletePlayer($_POST['data'][$i]);
    		}

			$jsonarray = array("result" => $result);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

    	case "addPlayer":
    		$result = $connect->addPlayer($_POST['data']);
			$jsonarray = array("result" => $result);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

		/**

		Park Cases

		**/

    	case "tablePark":

    		$total = $connect->countPark($_POST['data']); 					// Nombre total de résultat
    		$perPage = 20;                   					// Nombre de resultat par page
    		$nbPage = ceil($total[0]['NB_PARK'] / $perPage); // Nombre de page total (ceil permet d'arrondir au nombre supérieur)

    		if(isset($_GET['p']) AND $_GET['p'] > 0 AND $_GET['p'] <= $nbPage)
    		    $currentPage = $_GET['p'];    				// Page courante initialser avec le parametre de la fonction
    		else
    		    $currentPage = 1;            				// Page courante initialiser à 1 par défaut

	    	$park = $connect->fillParkTable($currentPage, $perPage, $_POST['data']);
	    	$enclosure = $connect->getEnclosurePark();

			$jsonarray = array("park" => $park, "enclosure" => $enclosure, "page" => $currentPage, "nbPage" => $nbPage);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

    	case "infosParks":
    		$parkInfos = $connect->getParkInfos($_POST['id']);
			$jsonarray = array("parkInfos" => $parkInfos);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

    	case "updatePark":
    		$result = $connect->updatePark($_POST['id'], $_POST['data']);
			$jsonarray = array("result" => $result);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

    	case "deletePark":
    		$result = $connect->deletePark($_POST['id']);
			$jsonarray = array("result" => $result);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

    	case "deleteMultiplePark":
    		for($i = 0 ; $i < count($_POST['data']) ; ++$i) {
    			$result = $connect->deletePark($_POST['data'][$i]);
    		}

			$jsonarray = array("result" => $result);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

    	case "addPark":
    		$result = $connect->addPark($_POST['data']);
			$jsonarray = array("result" => $result);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

		/**

		Enclosure Cases

		**/

    	case "tableEnclosure":

    		$total = $connect->countEnclosure($_POST['data']); 					// Nombre total de résultat
    		$perPage = 20;                   					// Nombre de resultat par page
    		$nbPage = ceil($total[0]['NB_ENCLOSURE'] / $perPage); // Nombre de page total (ceil permet d'arrondir au nombre supérieur)

    		if(isset($_GET['p']) AND $_GET['p'] > 0 AND $_GET['p'] <= $nbPage)
    		    $currentPage = $_GET['p'];    				// Page courante initialser avec le parametre de la fonction
    		else
    		    $currentPage = 1;            				// Page courante initialiser à 1 par défaut

	    	$enclosure = $connect->fillEnclosureTable($currentPage, $perPage, $_POST['data']);

			$jsonarray = array("enclosure" => $enclosure, "page" => $currentPage, "nbPage" => $nbPage);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

    	case "infosEnclosures":
    		$enclosureInfos = $connect->getEnclosureInfos($_POST['id']);
			$jsonarray = array("enclosureInfos" => $enclosureInfos);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

    	case "updateEnclosure":
    		$result = $connect->updateEnclosure($_POST['id'], $_POST['data']);
			$jsonarray = array("result" => $result);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

    	case "deleteEnclosure":
    		$result = $connect->deleteEnclosure($_POST['id']);
			$jsonarray = array("result" => $result);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

    	case "deleteMultipleEnclosure":
    		for($i = 0 ; $i < count($_POST['data']) ; ++$i) {
    			$result = $connect->deleteEnclosure($_POST['data'][$i]);
    		}

			$jsonarray = array("result" => $result);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

    	case "addEnclosure":
    		$result = $connect->addEnclosure($_POST['data']);
			$jsonarray = array("result" => $result);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

		/**

		Item Cases

		**/

    	case "tableItem":

    		$total = $connect->countItem($_POST['data']); 					// Nombre total de résultat
    		$perPage = 20;                   					// Nombre de resultat par page
    		$nbPage = ceil($total[0]['NB_ITEM'] / $perPage); // Nombre de page total (ceil permet d'arrondir au nombre supérieur)

    		if(isset($_GET['p']) AND $_GET['p'] > 0 AND $_GET['p'] <= $nbPage)
    		    $currentPage = $_GET['p'];    				// Page courante initialser avec le parametre de la fonction
    		else
    		    $currentPage = 1;            				// Page courante initialiser à 1 par défaut

	    	$item = $connect->fillItemTable($currentPage, $perPage, $_POST['data']);

			$jsonarray = array("item" => $item, "page" => $currentPage, "nbPage" => $nbPage);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

    	case "infosItems":
    		$itemInfos = $connect->getItemInfos($_POST['id']);
			$jsonarray = array("itemInfos" => $itemInfos);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

    	case "updateItem":
    		$result = $connect->updateItem($_POST['id'], $_POST['data']);
			$jsonarray = array("result" => $result);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

    	case "deleteItem":
    		$result = $connect->deleteItem($_POST['id']);
			$jsonarray = array("result" => $result);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

    	case "deleteMultipleItem":
    		for($i = 0 ; $i < count($_POST['data']) ; ++$i) {
    			$result = $connect->deleteItem($_POST['data'][$i]);
    		}

			$jsonarray = array("result" => $result);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;

    	case "addItem":
    		$result = $connect->addItem($_POST['data']);
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
    	case "park": 
	    	$park = $connect->getAllPark();
			$jsonarray = array("park" => $park);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;
    	case "account": 
	    	$account = $connect->getAllAccount();
			$jsonarray = array("account" => $account);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;
    	case "perso": 
	    	$perso = $connect->getAllPerso();
			$jsonarray = array("perso" => $perso);
			$jsonReturned = json_encode($jsonarray);
			echo $jsonReturned;
		break;


    } // Switch
    
?>