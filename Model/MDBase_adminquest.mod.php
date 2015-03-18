<?php
    class MDBase_adminquest extends PDO {

        private static $engine = 'mysql';

        private static $dbName = 'DB_MONSTER_PARK' ;
        private static $dbHost = 'localhost' ;
        private static $dbUsername = 'adminquest';
        private static $dbUserPassword = 'quest';
        private static $cont  = null;

        public function __construct(){
            $dns = self::$engine.':dbname='.self::$dbName.";host=".self::$dbHost;
            parent::__construct( $dns, self::$dbUsername, self::$dbUserPassword );
        }

        public function __destruct(){}

        /**
        connect's function
        **/

        public static function connect()
        {
            // One connection through whole application
            if ( null == self::$cont ){
                try{
                    self::$cont =  new PDO( "mysql:host=".self::$dbHost.";"."dbname=".self::$dbName, self::$dbUsername, self::$dbUserPassword);
                }
                catch(PDOException $e){
                    die($e->getMessage());
                }
            }
            return self::$cont;
        }

        /**

                                                ITEMS REQUESTS

        **/

        public static function fillItemSelect()
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT ID_ITEM, LIB_ITEM FROM ITEM ORDER BY TYPE_ITEM";

            $qq = $pdo->prepare($query);

            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

        //get all quest's Items
        public static function getAllQuestsItem()
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT Q.ID_QUEST, I.LIB_ITEM
                        FROM QUEST Q, QUEST_REWARD_ITEM QRI, ITEM I
                       WHERE Q.ID_QUEST = QRI.ID_QUEST
                         AND QRI.ID_ITEM = I.ID_ITEM";

            $qq = $pdo->prepare($query);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

        public static function getQuestItemInfos($id)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT * FROM QUEST_REWARD_ITEM WHERE ID_QUEST = :ID";

            $qq = $pdo->prepare($query);
            $qq->bindValue('ID', $id, PDO::PARAM_INT);

            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

        public static function updateQuestItem($questId, $itemId)
        {

            //before insert, we delete all Item binding to the selected quest
            self::deleteQuestItem($questId);

            $result = self::insertQuestItem($questId, $itemId);

            return $result;
        }

        public static function deleteQuestItem($questId)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "DELETE FROM QUEST_REWARD_ITEM WHERE ID_QUEST = :ID_QUEST";
            $qq = $pdo->prepare($query);
            $qq->bindValue('ID_QUEST', $questId, PDO::PARAM_INT);
            $result = $qq->execute();

            return $result;
        }

        public static function insertQuestItem($questId, $itemId)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "INSERT INTO QUEST_REWARD_ITEM (ID_QUEST, ID_ITEM) VALUES (:ID_QUEST, :ID_ITEM)";
            $qq = $pdo->prepare($query);

            $result = false;
            $qq->bindValue('ID_QUEST', $questId, PDO::PARAM_INT);
            for($i = 0 ; $i < count($itemId) ; ++$i)
            {
                if($itemId[$i] != 'null'){
                    $qq->bindValue('ID_ITEM', $itemId[$i], PDO::PARAM_INT);
                    $result = $qq->execute();
                }
            }

            return $result;
        }

        /**

                                                QUEST REQUESTS

        **/

        public static function countQuests()
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT COUNT(ID_QUEST) AS NB_QUESTS FROM QUEST";

            $qq = $pdo->prepare($query);

            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

        public static function getAllQuests($currentPage, $perPage)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
             $condition = "";
            if($search['NAME'] != "")
                $condition .= " WHERE NAME LIKE '".$search['NAME']."%' ";
            if($search['DATE_DEB'] != "")
                if($condition == "")
                $condition .= " WHERE DATE_DEB > ".$search['DATE_DEB'];
                else
                $condition .= " AND DATE_DEB > ".$search['DATE_DEB'];
            if($search['DURATION'] != "")
                if($condition == "")
                $condition .= " WHERE DURATION >= ".$search['DURATION'];
                else
                $condition .= " AND DURATION >= ".$search['DURATION'];
            if($search['FEE'] != "")
                if($condition == "")
                $condition .= " WHERE FEE >= ".$search['FEE'];
                else
                $condition .= " AND FEE >= ".$search['FEE'];

            $query = "SELECT * FROM QUEST ".$condition." ORDER BY ID_QUEST DESC LIMIT :STARTPAGE, :PERPAGE";

            $qq = $pdo->prepare($query);
            $qq->bindValue('STARTPAGE', ($currentPage-1)*$perPage, PDO::PARAM_INT);
            $qq->bindValue('PERPAGE', $perPage, PDO::PARAM_INT);

            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

        public static function getQuestInfos($id)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT * FROM QUEST WHERE ID_QUEST = :ID";

            $qq = $pdo->prepare($query);
            $qq->bindValue('ID', $id, PDO::PARAM_INT);

            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

        public static function updateQuest($id, $infos)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "  UPDATE QUEST
                        SET  NAME = :NAME,
                             DATE_DEB = :DATE_DEB,
                             DURATION = :DURATION,
                             FEE = :FEE
                        WHERE ID_QUEST  = :ID";

            $qq = $pdo->prepare($query);
            $qq->bindValue('ID',        $id,                PDO::PARAM_INT);
            $qq->bindValue('NAME',      $infos['NAME'],     PDO::PARAM_STR);
            $qq->bindValue('DATE_DEB',  $infos['DATE_DEB'], PDO::PARAM_STR);
            $qq->bindValue('DURATION',  $infos['DURATION'], PDO::PARAM_INT);
            $qq->bindValue('FEE',       $infos['FEE'],      PDO::PARAM_INT);

            $result = $qq->execute();
            return $result;
        }

        public static function deleteQuest($id)
        {

            //before, we delete all Item binding to the selected quest
            self::deleteQuestItem($id);

            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "DELETE FROM QUEST WHERE ID_QUEST = :ID";

            $qq = $pdo->prepare($query);
            $qq->bindValue('ID', $id, PDO::PARAM_INT);

            $result = $qq->execute();
            return $result;
        }

        public static function deleteMultipleQuest($data)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //Suppression des items associés aux quêtes
            $query = "DELETE FROM QUEST_REWARD_ITEM WHERE ID_QUEST IN (";
            for($i = 0 ; $i < count($data) ; ++$i) {
                $query .= $data[$i].",";    // boucle les ID des quêtes que l'on veux supprimer
            }
            $query = substr($query, 0, -1); // Suppression de la derniere virgule
            $query .= ");"; // ferme la parenthese du IN

            $qq = $pdo->prepare($query);
            $result = $qq->execute();
            
            //Suppression des quêtes
            $query = "DELETE FROM QUEST WHERE ID_QUEST IN (";
            for($i = 0 ; $i < count($data) ; ++$i) {
                $query .= $data[$i].",";    // boucle les ID des quêtes que l'on veux supprimer
            }
            $query = substr($query, 0, -1); // Suppression de la derniere virgule
            $query .= ");"; // ferme la parenthese du IN

            $qq = $pdo->prepare($query);

            $result = $qq->execute();
            return $result;
        }

        public static function insertQuest($infos)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "INSERT INTO QUEST (NAME, DATE_DEB, DURATION, FEE) VALUES (:NAME, :DATE_DEB, :DURATION, :FEE)";

            $qq = $pdo->prepare($query);
            $qq->bindValue('NAME',      $infos['NAME'],     PDO::PARAM_STR);
            $qq->bindValue('DATE_DEB',  $infos['DATE_DEB'], PDO::PARAM_STR);
            $qq->bindValue('DURATION',  $infos['DURATION'], PDO::PARAM_INT);
            $qq->bindValue('FEE',       $infos['FEE'],      PDO::PARAM_INT);

            $result = $qq->execute();
            
            //$temp return the ID of the last row inserted
            $temp = $pdo->lastInsertId();

            return $temp;
        }
    }

?>