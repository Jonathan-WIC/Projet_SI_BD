<?php 

    //petite fonction pour filtrer le nom des fichier (remplace les accent et les apostrophes etc...), elle devrait pas se trouver là mais on va faire comme si on avait rien vu :3
    function replace_accents($string){ 
            return str_replace( array('à','á','â','ã','ä', 'ç', 'è','é','ê','ë', 'ì','í','î','ï', 'ñ', 'ò','ó','ô','õ','ö', 'ù','ú','û','ü', 'ý','ÿ', 'À','Á','Â','Ã','Ä', 'Ç', 'È','É','Ê','Ë', 'Ì','Í','Î','Ï', 'Ñ', 'Ò','Ó','Ô','Õ','Ö', 'Ù','Ú','Û','Ü', 'Ý', '\''), array('a','a','a','a','a', 'c', 'e','e','e','e', 'i','i','i','i', 'n', 'o','o','o','o','o', 'u','u','u','u', 'y','y', 'A','A','A','A','A', 'C', 'E','E','E','E', 'I','I','I','I', 'N', 'O','O','O','O','O', 'U','U','U','U', 'Y', '_'), $string);
    }

    require '../Model/MDBase_editorialiste.mod.php';
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

    }
?>