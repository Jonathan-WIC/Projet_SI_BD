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

                                                PERSO PERSO

        **/

        public static function countPlayers()
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT COUNT(ID_PERSO) AS NB_PERSOS FROM PERSO";

            $qq = $pdo->prepare($query);

            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

        public static function getAllPlayers($currentPage, $perPage)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT * FROM PERSO ORDER BY ID_PERSO DESC LIMIT :STARTPAGE, :PERPAGE";

            $qq = $pdo->prepare($query);
            $qq->bindValue('STARTPAGE', ($currentPage-1)*$perPage, PDO::PARAM_INT);
            $qq->bindValue('PERPAGE', $perPage, PDO::PARAM_INT);

            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

        public static function getPlayerInfos($id)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT * FROM PERSO WHERE ID_PERSO = :ID";

            $qq = $pdo->prepare($query);
            $qq->bindValue('ID', $id, PDO::PARAM_INT);

            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

        public static function updatePlayer($id, $infos)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "  UPDATE PERSO
                        SET  NAME = :NAME,
                             DATE_DEB = :DATE_DEB,
                             DURATION = :DURATION,
                             FEE = :FEE
                        WHERE ID_PERSO  = :ID";

            $qq = $pdo->prepare($query);
            $qq->bindValue('ID',        $id,                PDO::PARAM_INT);
            $qq->bindValue('NAME',      $infos['NAME'],     PDO::PARAM_STR);
            $qq->bindValue('DATE_DEB',  $infos['DATE_DEB'], PDO::PARAM_STR);
            $qq->bindValue('DURATION',  $infos['DURATION'], PDO::PARAM_INT);
            $qq->bindValue('FEE',       $infos['FEE'],      PDO::PARAM_INT);

            $result = $qq->execute();
            return $result;
        }

        public static function deletePlayer($id)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "DELETE FROM PERSO WHERE ID_PERSO = :ID";

            $qq = $pdo->prepare($query);
            $qq->bindValue('ID', $id, PDO::PARAM_INT);

            $result = $qq->execute();
            return $result;
        }

        public static function deleteMultiplePlayer($data)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "DELETE FROM PERSO WHERE ID_PERSO IN (";
            for($i = 0 ; $i < count($data) ; ++$i) {
                $query .= $data[$i].",";    // boucle les ID des quêtes que l'on veux supprimer
            }
            $query = substr($query, 0, -1); // Suppression de la derniere virgule
            $query .= ");"; // ferme la parenthese du IN

            $qq = $pdo->prepare($query);

            $result = $qq->execute();
            return $result;
        }

        public static function insertPlayer($infos)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "INSERT INTO PERSO (NAME, DATE_DEB, DURATION, FEE) VALUES (:NAME, :DATE_DEB, :DURATION, :FEE)";

            $qq = $pdo->prepare($query);
            $qq->bindValue('NAME',      $infos['NAME'],     PDO::PARAM_STR);
            $qq->bindValue('DATE_DEB',  $infos['DATE_DEB'], PDO::PARAM_STR);
            $qq->bindValue('DURATION',  $infos['DURATION'], PDO::PARAM_INT);
            $qq->bindValue('FEE',       $infos['FEE'],      PDO::PARAM_INT);

            $result = $qq->execute();
            return $result;
        }
    }

?>