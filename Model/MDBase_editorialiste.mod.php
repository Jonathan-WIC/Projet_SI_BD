<?php
    class MDBase_editorialiste extends PDO {

        private static $engine = 'mysql';

        private static $dbName = 'DB_MONSTER_PARK' ;
        private static $dbHost = 'localhost' ;
        private static $dbUsername = 'editorialiste';
        private static $dbUserPassword = 'edit';
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

                                                NEWSPAPER REQUESTS

        **/

        public static function countNewspapers()
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT COUNT(ID_NEWSPAPER) AS NB_NEWSPAPER FROM NEWSPAPER";

            $qq = $pdo->prepare($query);

            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

        public static function getAllNewspapers($currentPage, $perPage)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT * FROM NEWSPAPER ORDER BY ID_NEWSPAPER DESC LIMIT :STARTPAGE, :PERPAGE";

            $qq = $pdo->prepare($query);
            $qq->bindValue('STARTPAGE', ($currentPage-1)*$perPage, PDO::PARAM_INT);
            $qq->bindValue('PERPAGE', $perPage, PDO::PARAM_INT);

            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

        public static function getNewspaperInfos($id)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT SUMMARY, STATUS FROM NEWSPAPER WHERE ID_NEWSPAPER = :ID";

            $qq = $pdo->prepare($query);
            $qq->bindValue('ID', $id, PDO::PARAM_INT);

            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

        public static function updateNewspaper($id, $infos)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "  UPDATE NEWSPAPER
                        SET  SUMMARY = :SUMMARY
                        WHERE ID_NEWSPAPER  = :ID";

            $qq = $pdo->prepare($query);
            $qq->bindValue('ID',            $id,                    PDO::PARAM_INT);
            $qq->bindValue('SUMMARY',  $infos['SUMMARY'], PDO::PARAM_STR);

            $result = $qq->execute();
            return $result;
        }

        public static function publishNewspaper($id)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "  UPDATE NEWSPAPER
                           SET STATUS = 1,
                               PUBLICATION = :PUBLICATION
                         WHERE ID_NEWSPAPER  = :ID";

            $qq = $pdo->prepare($query);
            $qq->bindValue('ID', $id, PDO::PARAM_INT);
            $qq->bindValue('PUBLICATION', date("Y-m-d"), PDO::PARAM_STR);

            $result = $qq->execute();
            return $result;
        }

        public static function deleteNewspaper($id)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "DELETE FROM NEWS WHERE ID_NEWSPAPER = :ID;
                      DELETE FROM NEWSPAPER WHERE ID_NEWSPAPER = :ID;";

            $qq = $pdo->prepare($query);
            $qq->bindValue('ID', $id, PDO::PARAM_INT);

            $result = $qq->execute();
            return $result;
        }

        public static function deleteMultipleNewspaper($data)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "DELETE FROM NEWSPAPER WHERE ID_NEWSPAPER IN (";
            for($i = 0 ; $i < count($data) ; ++$i) {
                $query .= $data[$i].",";    // boucle les ID des newspaper que l'on veux supprimer
            }
            $query = substr($query, 0, -1); // Suppression de la derniere virgule
            $query .= ");"; // ferme la parenthese du IN

            $qq = $pdo->prepare($query);

            //$qq->bindValue('ID', $id, PDO::PARAM_INT);
            $result = $qq->execute();
            return $result;
        }

        public static function insertNewspaper($infos)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "INSERT INTO NEWSPAPER (SUMMARY) VALUES (:SUMMARY)";

            $qq = $pdo->prepare($query);
            $qq->bindValue('SUMMARY',  $infos['SUMMARY'], PDO::PARAM_STR);

            $result = $qq->execute();
            return $result;
        }


        /**

                                                        NEWS REQUESTS

        **/


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

        public static function getNewsInfo($id)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT * FROM NEWS WHERE ID_NEWS = :ID";
            $qq = $pdo->prepare($query);
            $qq->bindValue('ID', $id, PDO::PARAM_INT);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

        public static function updateNews($data)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "  UPDATE NEWS
                        SET TITLE = :TITLE,
                            CONTENT = :CONTENT ";

            if(strlen($data['image']) != 0){
                $query .= ", PICTURE = :PICTURE ";
            }
                            
            $query .= "WHERE ID_NEWS  = :ID;";

            $qq = $pdo->prepare($query);
            $qq->bindValue('ID',      $data['id'],      PDO::PARAM_INT);
            $qq->bindValue('TITLE',   $data['title'],   PDO::PARAM_STR);
            $qq->bindValue('CONTENT', $data['content'], PDO::PARAM_STR);

            if(strlen($data['image']) != 0){
                $qq->bindValue('PICTURE', $data['image'],   PDO::PARAM_STR);
            }

            $result = $qq->execute();
            return $result;
        }

        public static function insertNews($data)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = " INSERT INTO NEWS (TITLE, CONTENT, PICTURE, ID_NEWSPAPER) VALUES (:TITLE, :CONTENT, :PICTURE, :ID)";
            $qq = $pdo->prepare($query);
            $qq->bindValue('ID',   $data['id'],   PDO::PARAM_STR);
            $qq->bindValue('TITLE',   $data['title'],   PDO::PARAM_STR);
            $qq->bindValue('CONTENT', $data['content'], PDO::PARAM_STR);
            $qq->bindValue('PICTURE', $data['image'],   PDO::PARAM_STR);

            $result = $qq->execute();
            return $result;
        }

        public static function deleteNews($id)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "DELETE FROM NEWS WHERE ID_NEWS = :ID";

            $qq = $pdo->prepare($query);

            $qq->bindValue('ID', $id, PDO::PARAM_INT);
            $result = $qq->execute();
            return $result;
        }

        public static function deleteMultipleNews($data)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "DELETE FROM NEWS WHERE ID_NEWSPAPER IN (";
            for($i = 0 ; $i < count($data) ; ++$i) {
                $query .= $data[$i].",";    // boucle les ID des newspaper que l'on veux supprimer
            }
            $query = substr($query, 0, -1); // Suppression de la derniere virgule
            $query .= ");"; // ferme la parenthese du IN

            $qq = $pdo->prepare($query);

            //$qq->bindValue('ID', $id, PDO::PARAM_INT);
            $result = $qq->execute();
            return $result;
        }

    }
?>
