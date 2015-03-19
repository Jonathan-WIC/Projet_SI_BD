<?php
    class MDBase_client extends PDO {


        private static $engine = 'mysql';

        private static $dbName = 'DB_MONSTER_PARK' ;
        private static $dbHost = 'localhost' ;
        private static $dbUsername = 'client';
        private static $dbUserPassword = 'client';
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

                                                NEWS FUNCTIONS

        **/

        public static function countNewspapers()
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT COUNT(ID_NEWSPAPER) AS NB_NEWSPAPER FROM NEWSPAPER WHERE STATUS = 1";
            $qq = $pdo->prepare($query);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

        public static function getAllNewspapers($currentPage, $perPage)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT * FROM NEWSPAPER WHERE STATUS = 1 ORDER BY ID_NEWSPAPER DESC LIMIT :STARTPAGE, :PERPAGE";
            $qq = $pdo->prepare($query);
            $qq->bindValue('STARTPAGE', ($currentPage-1)*$perPage, PDO::PARAM_INT);
            $qq->bindValue('PERPAGE', $perPage, PDO::PARAM_INT);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

        public static function countNewsFromNewspaper($id)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT COUNT(ID_NEWS) AS NB_NEWS FROM NEWS WHERE ID_NEWSPAPER = :ID";
            $qq = $pdo->prepare($query);
            $qq->bindValue('ID', $id, PDO::PARAM_INT);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

        public static function getNewsFromGame($id, $currentPage, $perPage)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT * FROM NEWS WHERE ID_NEWSPAPER = :ID LIMIT :STARTPAGE, :PERPAGE";
            $qq = $pdo->prepare($query);
            $qq->bindValue('ID', $id, PDO::PARAM_INT);
            $qq->bindValue('STARTPAGE', ($currentPage-1)*$perPage, PDO::PARAM_INT);
            $qq->bindValue('PERPAGE', $perPage, PDO::PARAM_INT);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

        /**

                                                    QUESTS FUNCTIONS

        **/

        //count all quest
        public static function countQuests($search)
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

            $query = "SELECT COUNT(ID_QUEST) AS NB_QUESTS FROM QUEST ".$conditions;

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

        //get all quest
        public static function getAllQuests($currentPage, $perPage, $search)
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
   }
?>
