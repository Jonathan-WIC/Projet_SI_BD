<?php
    class MDBase extends PDO {


        private static $engine = 'mysql';

        private static $dbName = 'db_Monster_Park' ;
        private static $dbHost = 'localhost' ;
        private static $dbUsername = 'root';
        private static $dbUserPassword = '';
        private static $cont  = null;


        public function __construct(){
            $dns = self::$engine.':dbname='.self::$dbName.";host=".self::$dbHost;
            parent::__construct( $dns, self::$dbUsername, self::$dbUserPassword );
        }

        //TEMPLATE pour faire des getAll
        public static function getAllUsers()
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT * FROM user";
            $qq = $pdo->prepare($query);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

    }
?>
