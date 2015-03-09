<?php 

    require '../Model/MDBase_moderateur.mod.php';
    $connect = new MDBase_moderateur();
    switch($_POST['role']){

        /**

        Player Handler
        
        **/

        case "tablePlayer":
            $total = $connect->countPlayers();                   // Nombre total de résultat
            $perPage = 20;                                       // Nombre de resultat par page
            $nbPage = ceil($total[0]['NB_PLAYERS'] / $perPage);  // Nombre de page total (ceil permet d'arrondir au nombre supérieur)

            if(isset($_GET['p']) AND $_GET['p'] > 0 AND $_GET['p'] <= $nbPage)
                $currentPage = $_GET['p'];      // Page courante initialser avec le parametre de la fonction
            else
                $currentPage = 1;               // Page courante initialiser à 1 par défaut

            $result = $connect->getAllPlayers($currentPage, $perPage);
            $jsonarray = array("quest" => $result, "page" => $currentPage, "nbPage" => $nbPage);
            $jsonReturned = json_encode($jsonarray);
            echo $jsonReturned;
        break;

        case "infosPlayers":
            $result = $connect->getPlayerInfos($_POST['id']);
            $jsonarray = array("quest" => $result);
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
            $result = $connect->deleteMultiplePlayer($_POST['data']);
            $jsonarray = array("result" => $result);
            $jsonReturned = json_encode($jsonarray);
            echo $jsonReturned;
        break;

        case "insertPlayer":
            $result = $connect->insertPlayer($_POST['data']);
            $jsonarray = array("result" => $result);
            $jsonReturned = json_encode($jsonarray);
            echo $jsonReturned;
        break;
    }
?>