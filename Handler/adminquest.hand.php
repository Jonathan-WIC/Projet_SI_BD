<?php 

    require '../Model/MDBase_adminquest.mod.php';
    $connect = new MDBase_adminquest();
    switch($_POST['role']){

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
            $total = $connect->countQuests();                   // Nombre total de résultat
            $perPage = 20;                                      // Nombre de resultat par page
            $nbPage = ceil($total[0]['NB_QUESTS'] / $perPage);  // Nombre de page total (ceil permet d'arrondir au nombre supérieur)

            if(isset($_GET['p']) AND $_GET['p'] > 0 AND $_GET['p'] <= $nbPage)
                $currentPage = $_GET['p'];                  // Page courante initialser avec le parametre de la fonction
            else
                $currentPage = 1;                           // Page courante initialiser à 1 par défaut

            $resultItem = $connect->getAllQuestsItem();
            $result = $connect->getAllQuests($currentPage, $perPage);
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
    }
?>