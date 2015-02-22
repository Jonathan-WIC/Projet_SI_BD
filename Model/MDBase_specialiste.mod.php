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
        get informations about monsters
        **/

        public static function getMonsterInfos()
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT M.*, MA.*, SSP.LIB_SUB_SPECIE, SSP.LIB_HABITAT, SP.LIB_SPECIE
                      FROM MONSTER M, MATURITY MA, SUB_SPECIE SSP, SPECIE SP
                      WHERE M.ID_MATURITY = MA.ID_MATURITY
                      AND M.ID_SUB_SPECIE = SSP.ID_SUB_SPECIE
                      AND SSP.ID_SPECIE = SP.ID_SPECIE";
            $qq = $pdo->prepare($query);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

        public static function getMonsterElementsInfos()
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT E.LIB_ELEMENT
                      FROM MONSTER M, ASSOC_MONSTER_ELEMENT AME, ELEMENT E
                      WHERE M.ID_MONSTER = AME.ID_MONSTER
                      AND AME.ID_ELEMENT = E.ID_ELEMENT";
            $qq = $pdo->prepare($query);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }
   }
?>
