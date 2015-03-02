<?php
    class MDBase_specialiste extends PDO {


        private static $engine = 'mysql';

        private static $dbName = 'DB_MONSTER_PARK' ;
        private static $dbHost = 'localhost' ;
        private static $dbUsername = 'specialiste';
        private static $dbUserPassword = 'spec';
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
        get informations about all monsters and their elements
        **/

        public static function countMonsters()
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "SELECT COUNT(M.ID_MONSTER) AS NB_MOB
                      FROM MONSTER M, MATURITY MA, SUB_SPECIE SSP, SPECIE SP, REGIME R
                      WHERE M.ID_MATURITY = MA.ID_MATURITY
                      AND M.ID_SUB_SPECIE = SSP.ID_SUB_SPECIE
                      AND M.ID_REGIME = R.ID_REGIME
                      AND SSP.ID_SPECIE = SP.ID_SPECIE"; 
            $qq = $pdo->prepare($query);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

        public static function getMonstersInfos($currentPage, $perPage)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "SELECT M.*, MA.*, R.LIB_REGIME, SSP.LIB_SUB_SPECIE, SSP.LIB_HABITAT, SP.LIB_SPECIE
                      FROM MONSTER M, MATURITY MA, SUB_SPECIE SSP, SPECIE SP, REGIME R
                      WHERE M.ID_MATURITY = MA.ID_MATURITY
                      AND M.ID_SUB_SPECIE = SSP.ID_SUB_SPECIE
                      AND M.ID_REGIME = R.ID_REGIME
                      AND SSP.ID_SPECIE = SP.ID_SPECIE
                      LIMIT :STARTPAGE, :PERPAGE";
            $qq = $pdo->prepare($query);
            $qq->bindValue('PERPAGE', $perPage, PDO::PARAM_INT);
            $qq->bindValue('STARTPAGE', ($currentPage-1)*$perPage, PDO::PARAM_INT);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            
            return $data;
        }

        public static function getMonstersElementsInfos()
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT M.ID_MONSTER, E.LIB_ELEMENT
                      FROM MONSTER M, ASSOC_MONSTER_ELEMENT AME, ELEMENT E
                      WHERE M.ID_MONSTER = AME.ID_MONSTER
                      AND AME.ID_ELEMENT = E.ID_ELEMENT";
            $qq = $pdo->prepare($query);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

         /**
        get informations about 1 monster and his elements
        **/

        public static function getMonsterInfos($id)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT M.*, MA.*, R.LIB_REGIME, SSP.LIB_SUB_SPECIE, SSP.LIB_HABITAT
                      FROM MONSTER M, MATURITY MA, SUB_SPECIE SSP, REGIME R
                      WHERE M.ID_MATURITY = MA.ID_MATURITY
                      AND M.ID_SUB_SPECIE = SSP.ID_SUB_SPECIE
                      AND M.ID_REGIME = R.ID_REGIME
                      AND M.ID_MONSTER = :ID";
            $qq = $pdo->prepare($query);
            $qq->bindValue('ID', $id, PDO::PARAM_INT);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

        public static function getMonsterElementsInfos($id)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT E.*
                      FROM MONSTER M, ASSOC_MONSTER_ELEMENT AME, ELEMENT E
                      WHERE M.ID_MONSTER = AME.ID_MONSTER
                      AND AME.ID_ELEMENT = E.ID_ELEMENT
                      AND M.ID_MONSTER = :ID";
            $qq = $pdo->prepare($query);
            $qq->bindValue('ID', $id, PDO::PARAM_INT);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }


        /**
            getAll function (used to fill dropdown on alteration's modal)
        **/
            

        public static function getAllElements()
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT * FROM ELEMENT";
            $qq = $pdo->prepare($query);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }


        //get all maturity level
        public static function getAllMaturityLevels()
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT * FROM MATURITY";
            $qq = $pdo->prepare($query);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }


        public static function getAllSpecies()
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT * FROM SPECIE";
            $qq = $pdo->prepare($query);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

        public static function getAllSubSpecies()
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT * FROM SUB_SPECIE";
            $qq = $pdo->prepare($query);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }
        
        //get all regime of monster
        public static function getAllRegimes()
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT * FROM REGIME";
            $qq = $pdo->prepare($query);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

        /**
        Update of monsters
        **/

        public static function updateMonster($id, $infos)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "  UPDATE MONSTER
                        SET  NAME = :NAME,
                             GENDER = :GENDER,
                             AGE = :AGE,
                             WEIGHT = :WEIGHT,
                             DANGER_SCALE = :DANGER_SCALE,
                             HEALTH_STATE = :HEALTH_STATE,
                             HUNGER_STATE = :HUNGER_STATE,
                             CLEAN_SCALE = :CLEAN_SCALE,
                             ID_SUB_SPECIE = :ID_SUB_SPECIE,
                             ID_MATURITY = :ID_MATURITY,
                             ID_REGIME = :ID_REGIME
                        WHERE ID_MONSTER = :ID";

            $qq = $pdo->prepare($query);

            $qq->bindValue('ID', $id, PDO::PARAM_INT);
            $qq->bindValue('NAME', $infos['NAME'], PDO::PARAM_STR);
            $qq->bindValue('GENDER', $infos['GENDER'], PDO::PARAM_STR);
            $qq->bindValue('AGE', $infos['AGE'], PDO::PARAM_INT);
            $qq->bindValue('WEIGHT', $infos['WEIGHT'], PDO::PARAM_INT);
            $qq->bindValue('DANGER_SCALE', $infos['DANGER_SCALE'], PDO::PARAM_STR);
            $qq->bindValue('HEALTH_STATE', $infos['HEALTH_STATE'], PDO::PARAM_INT);
            $qq->bindValue('HUNGER_STATE', $infos['HUNGER_STATE'], PDO::PARAM_INT);
            $qq->bindValue('CLEAN_SCALE', $infos['CLEAN_SCALE'], PDO::PARAM_INT);
            $qq->bindValue('ID_SUB_SPECIE', $infos['ID_SUB_SPECIE'], PDO::PARAM_INT);
            $qq->bindValue('ID_MATURITY', $infos['ID_MATURITY'], PDO::PARAM_INT);
            $qq->bindValue('ID_REGIME', $infos['ID_REGIME'], PDO::PARAM_INT);
            $result = $qq->execute();
            return $result;
        }

        public static function updateElemMonster($id, $infos)
        {

            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query  = "DELETE FROM ASSOC_MONSTER_ELEMENT WHERE ID_MONSTER = :ID;";
            $qq = $pdo->prepare($query);
            $qq->bindValue('ID', $id, PDO::PARAM_INT);
            $result = $qq->execute();

            if($infos != 0){
                $query = "INSERT INTO ASSOC_MONSTER_ELEMENT (ID_MONSTER, ID_ELEMENT) VALUES (:ID, :ELEMENTID);";
                
                $qq = $pdo->prepare($query);
                $qq->bindValue('ID', $id, PDO::PARAM_INT);

                for($i = 0 ; $i < count($infos) ; ++$i)
                {
                    $qq->bindValue('ELEMENTID', $infos[$i], PDO::PARAM_INT);
                    $result = $qq->execute();
                }
            }

            return $result;
        }

   }
?>
