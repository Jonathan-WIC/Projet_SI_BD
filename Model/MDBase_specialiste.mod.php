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

                                                REQUESTS ABOUT MONSTERS

        **/

        /**
        get informations about all monsters and their elements
        **/

        public static function countMonsters($search)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $condition = "";
            if($search['NAME'] != "")
                $condition .= " AND M.NAME LIKE '".$search['NAME']."%' ";
            if($search['GENDER'] != "")
                $condition .= " AND M.GENDER LIKE '".$search['GENDER']."%' ";
            if($search['DANGER_SCALE'] != "")
                $condition .= " AND M.DANGER_SCALE LIKE '".$search['DANGER_SCALE']."%' ";
            if($search['LIB_SPECIE'] != "")
                $condition .= " AND SP.LIB_SPECIE LIKE '".$search['LIB_SPECIE']."%' ";
            if($search['LIB_SUB_SPECIE'] != "")
                $condition .= " AND SSP.LIB_SUB_SPECIE LIKE '".$search['LIB_SUB_SPECIE']."%' ";
            if($search['LIB_MATURITY'] != "")
                $condition .= " AND MA.LIB_MATURITY LIKE '".$search['LIB_MATURITY']."%' ";
            if($search['LIB_REGIME'] != "")
                $condition .= " AND R.LIB_REGIME LIKE '".$search['LIB_REGIME']."%' ";
            if($search['CLEAN_SCALE'] != "")
                $condition .= " AND M.CLEAN_SCALE >= ". $search['CLEAN_SCALE'];
            if($search['HEALTH_STATE'] != "")
                $condition .= " AND M.HEALTH_STATE >= ". $search['HEALTH_STATE'];
            if($search['HUNGER_STATE'] != "")
                $condition .= " AND M.HUNGER_STATE >= ". $search['HUNGER_STATE'];
            if($search['AGE'] != "")
                $condition .= " AND M.AGE >= ". $search['AGE'];
            if($search['WEIGHT'] != "")
                $condition .= " AND M.WEIGHT >= ". $search['WEIGHT'];

            $query = "SELECT COUNT(ID_MONSTER) AS NB_MOB FROM MONSTER ".$condition; 
            $qq = $pdo->prepare($query);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

        public static function getMonstersInfos($currentPage, $perPage, $search)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $condition = "";
            if($search['NAME'] != "")
                $condition .= " AND M.NAME LIKE '".$search['NAME']."%' ";
            if($search['GENDER'] != "")
                $condition .= " AND M.GENDER LIKE '".$search['GENDER']."%' ";
            if($search['DANGER_SCALE'] != "")
                $condition .= " AND M.DANGER_SCALE LIKE '".$search['DANGER_SCALE']."%' ";
            if($search['LIB_SPECIE'] != "")
                $condition .= " AND SP.LIB_SPECIE LIKE '".$search['LIB_SPECIE']."%' ";
            if($search['LIB_SUB_SPECIE'] != "")
                $condition .= " AND SSP.LIB_SUB_SPECIE LIKE '".$search['LIB_SUB_SPECIE']."%' ";
            if($search['LIB_MATURITY'] != "")
                $condition .= " AND MA.LIB_MATURITY LIKE '".$search['LIB_MATURITY']."%' ";
            if($search['LIB_REGIME'] != "")
                $condition .= " AND R.LIB_REGIME LIKE '".$search['LIB_REGIME']."%' ";
            if($search['CLEAN_SCALE'] != "")
                $condition .= " AND M.CLEAN_SCALE >= ". $search['CLEAN_SCALE'];
            if($search['HEALTH_STATE'] != "")
                $condition .= " AND M.HEALTH_STATE >= ". $search['HEALTH_STATE'];
            if($search['HUNGER_STATE'] != "")
                $condition .= " AND M.HUNGER_STATE >= ". $search['HUNGER_STATE'];
            if($search['AGE'] != "")
                $condition .= " AND M.AGE >= ". $search['AGE'];
            if($search['WEIGHT'] != "")
                $condition .= " AND M.WEIGHT >= ". $search['WEIGHT'];

            $query = "SELECT M.*, MA.*, R.LIB_REGIME, SSP.LIB_SUB_SPECIE, SSP.LIB_HABITAT, SP.LIB_SPECIE
                      FROM MONSTER M, MATURITY MA, SUB_SPECIE SSP, SPECIE SP, REGIME R
                      WHERE M.ID_MATURITY = MA.ID_MATURITY
                      AND M.ID_SUB_SPECIE = SSP.ID_SUB_SPECIE
                      AND M.ID_REGIME = R.ID_REGIME
                      AND SSP.ID_SPECIE = SP.ID_SPECIE ";
            $query.= $condition." ORDER BY ID_MONSTER LIMIT :STARTPAGE, :PERPAGE";

            $qq = $pdo->prepare($query);
            $qq->bindValue('STARTPAGE', ($currentPage-1)*$perPage, PDO::PARAM_INT);
            $qq->bindValue('PERPAGE', $perPage, PDO::PARAM_INT);
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
        Update 1 monster
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


        /**

                                                REQUEST ABOUT SPECIES
    
        **/
            
        public static function countSpecies($search)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $condition = "";
            if($search['LIB_SPECIE'] != "")
                $condition .= " AND LIB_SPECIE LIKE'". $search['LIB_SPECIE']."%' "; 

            $query = "SELECT COUNT(ID_SPECIE) AS NB_SPECIES FROM SPECIE WHERE ID_SPECIE <> 0 ".$condition;
            $qq = $pdo->prepare($query);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }
    
        public static function fillSpecieTable($currentPage, $perPage, $search)
        {

            $condition = "";
            if($search['LIB_SPECIE'] != "")
                $condition .= " AND LIB_SPECIE LIKE'". $search['LIB_SPECIE']."%' "; 

            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "SELECT * FROM SPECIE WHERE ID_SPECIE <> 0 ".$condition." LIMIT :STARTPAGE, :PERPAGE";
            
            $qq = $pdo->prepare($query);
            $qq->bindValue('STARTPAGE', ($currentPage-1)*$perPage, PDO::PARAM_INT);
            $qq->bindValue('PERPAGE', $perPage, PDO::PARAM_INT);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }
    
        public static function getSpecieInfos($id)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "SELECT * FROM SPECIE WHERE ID_SPECIE = :ID";

            $qq = $pdo->prepare($query);
            $qq->bindValue('ID', $id, PDO::PARAM_INT);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }


        public static function updateSpecie($id, $infos)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "  UPDATE SPECIE SET LIB_SPECIE = :NAME WHERE ID_SPECIE = :ID";

            $qq = $pdo->prepare($query);

            $qq->bindValue('ID', $id, PDO::PARAM_INT);
            $qq->bindValue('NAME', $infos['NAME'], PDO::PARAM_STR);
            $result = $qq->execute();
            return $result;
        }


        /**

                                                REQUEST ABOUT SUB_SPECIES
    
        **/
            
        public static function countSubSpecies($search)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $condition = "";
            if($search['LIB_SUB_SPECIE'] != "")
                $condition .= " AND SSP.LIB_SUB_SPECIE LIKE '".$search['LIB_SUB_SPECIE']."%' ";
            if($search['LIB_SPECIE'] != "")
                $condition .= " AND SP.LIB_SPECIE LIKE '".$search['LIB_SPECIE']."%' ";
            if($search['LIB_HABITAT'] != "")
                $condition .= " AND LIB_HABITAT LIKE '".$search['LIB_HABITAT']."%' ";

            $query = "SELECT COUNT(ID_SUB_SPECIE) AS NB_SUB_SPECIE FROM SUB_SPECIE WHERE ID_SUB_SPECIE <> 0 ".$condition;
            $qq = $pdo->prepare($query);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }
    
        public static function fillSubSpecieTable($currentPage, $perPage, $search)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $condition = "";
            if($search['LIB_SUB_SPECIE'] != "")
                $condition .= " AND SSP.LIB_SUB_SPECIE LIKE '".$search['LIB_SUB_SPECIE']."%' ";
            if($search['LIB_SPECIE'] != "")
                $condition .= " AND SP.LIB_SPECIE LIKE '".$search['LIB_SPECIE']."%' ";
            if($search['LIB_HABITAT'] != "")
                $condition .= " AND LIB_HABITAT LIKE '".$search['LIB_HABITAT']."%' ";

            $query = "SELECT SSP.*, SP.LIB_SPECIE
                      FROM SUB_SPECIE SSP, SPECIE SP
                      WHERE SSP.ID_SPECIE = SP.ID_SPECIE
                        AND ID_SUB_SPECIE <> 0 ";
            $query .= $condition." LIMIT :STARTPAGE, :PERPAGE";

            $qq = $pdo->prepare($query);
            $qq->bindValue('STARTPAGE', ($currentPage-1)*$perPage, PDO::PARAM_INT);
            $qq->bindValue('PERPAGE', $perPage, PDO::PARAM_INT);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }
   
        public static function getSubSpecieInfos($id)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "SELECT SSP.*, SP.LIB_SPECIE
                      FROM SUB_SPECIE SSP, SPECIE SP
                      WHERE SSP.ID_SUB_SPECIE = :ID
                      AND SSP.ID_SPECIE = SP.ID_SPECIE";

            $qq = $pdo->prepare($query);
            $qq->bindValue('ID', $id, PDO::PARAM_INT);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

        public static function updateSubSpecie($id, $infos)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "  UPDATE SUB_SPECIE
                        SET  LIB_SUB_SPECIE  = :NAME,
                             ID_SPECIE   = :ID_SPECIE,
                             LIB_HABITAT = :HABITAT
                        WHERE ID_SUB_SPECIE  = :ID";

            $qq = $pdo->prepare($query);

            $qq->bindValue('ID',        $id,                 PDO::PARAM_INT);
            $qq->bindValue('NAME',      $infos['NAME'],      PDO::PARAM_STR);
            $qq->bindValue('ID_SPECIE', $infos['ID_SPECIE'], PDO::PARAM_INT);
            $qq->bindValue('HABITAT',   $infos['HABITAT'],   PDO::PARAM_STR);
            $result = $qq->execute();
            return $result;
        }


        /**

                                                REQUEST ABOUT ELEMENTS
    
        **/
            
        public static function countElement($search)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $condition = "";
            if($search['LIB_ELEMENT'] != "")
                $condition .= " WHERE LIB_ELEMENT LIKE '". $search['LIB_ELEMENT'] ."%' ";

            $query = "SELECT COUNT(ID_ELEMENT) AS NB_ELEMENT FROM ELEMENT ".$condition;
            $qq = $pdo->prepare($query);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }
    
        public static function fillElementTable($currentPage, $perPage, $search)
        {
            $condition = "";
            if($search['LIB_ELEMENT'] != "")
                $condition .= " WHERE LIB_ELEMENT LIKE '". $search['LIB_ELEMENT'] ."%' ";

            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "SELECT * FROM ELEMENT ".$condition." LIMIT :STARTPAGE, :PERPAGE";

            $qq = $pdo->prepare($query);
            $qq->bindValue('STARTPAGE', ($currentPage-1)*$perPage, PDO::PARAM_INT);
            $qq->bindValue('PERPAGE', $perPage, PDO::PARAM_INT);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }
   
        public static function getElementInfos($id)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "SELECT * FROM ELEMENT WHERE ID_ELEMENT = :ID";

            $qq = $pdo->prepare($query);
            $qq->bindValue('ID', $id, PDO::PARAM_INT);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

        public static function updateElement($id, $infos)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "  UPDATE ELEMENT SET LIB_ELEMENT = :NAME WHERE ID_ELEMENT = :ID";

            $qq = $pdo->prepare($query);

            $qq->bindValue('ID',    $id,             PDO::PARAM_INT);
            $qq->bindValue('NAME',  $infos['NAME'],  PDO::PARAM_STR);
            $result = $qq->execute();
            return $result;
        }


        /**

                                                REQUEST ABOUT REGIME
    
        **/
            
        public static function countRegime($search)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $condition = "";
            if($search['LIB_REGIME'] != "")
                $condition .= " AND LIB_REGIME LIKE '".$search['LIB_REGIME']."%' ";

            $query = "SELECT COUNT(ID_REGIME) AS NB_REGIME FROM REGIME WHERE ID_REGIME <> 0 ".$condition;
            $qq = $pdo->prepare($query);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }
    
        public static function fillRegimeTable($currentPage, $perPage, $search)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $condition = "";
            if($search['LIB_REGIME'] != "")
                $condition .= " AND LIB_REGIME LIKE '".$search['LIB_REGIME']."%' ";

            $query = "SELECT * FROM REGIME WHERE ID_REGIME <> 0 ".$condition." LIMIT :STARTPAGE, :PERPAGE";

            $qq = $pdo->prepare($query);
            $qq->bindValue('STARTPAGE', ($currentPage-1)*$perPage, PDO::PARAM_INT);
            $qq->bindValue('PERPAGE', $perPage, PDO::PARAM_INT);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }
   
        public static function getRegimeInfos($id)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "SELECT * FROM REGIME WHERE ID_REGIME = :ID";

            $qq = $pdo->prepare($query);
            $qq->bindValue('ID', $id, PDO::PARAM_INT);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

        public static function updateRegime($id, $infos)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "  UPDATE REGIME SET LIB_REGIME = :NAME WHERE ID_REGIME = :ID";

            $qq = $pdo->prepare($query);

            $qq->bindValue('ID',    $id,            PDO::PARAM_INT);
            $qq->bindValue('NAME',  $infos['NAME'], PDO::PARAM_STR);
            $result = $qq->execute();
            return $result;
        }


        /**

                                                REQUEST ABOUT MATURITY
    
        **/
            
        public static function countMaturity($search)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

             $condition = "";
            if($search['LIB_MATURITY'] != "")
                $condition .= " AND LIB_MATURITY LIKE '".$search['LIB_MATURITY']."%' ";

            $query = "SELECT COUNT(ID_MATURITY) AS NB_MATURITY FROM MATURITY WHERE ID_MATURITY <> 0 ".$condition;
            $qq = $pdo->prepare($query);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }
   
        public static function fillMaturityTable($currentPage, $perPage, $search)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $condition = "";
            if($search['LIB_MATURITY'] != "")
                $condition .= " AND LIB_MATURITY LIKE '".$search['LIB_MATURITY']."%' ";

            $query = "SELECT * FROM MATURITY WHERE ID_MATURITY <> 0 ".$condition." LIMIT :STARTPAGE, :PERPAGE";


            $qq = $pdo->prepare($query);
            $qq->bindValue('STARTPAGE', ($currentPage-1)*$perPage, PDO::PARAM_INT);
            $qq->bindValue('PERPAGE', $perPage, PDO::PARAM_INT);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }
    
        public static function getMaturityInfos($id)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "SELECT * FROM MATURITY WHERE ID_MATURITY = :ID";

            $qq = $pdo->prepare($query);
            $qq->bindValue('ID', $id, PDO::PARAM_INT);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

        public static function updateMaturity($id, $infos)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "  UPDATE MATURITY SET LIB_MATURITY = :NAME WHERE ID_MATURITY = :ID";

            $qq = $pdo->prepare($query);

            $qq->bindValue('ID',    $id,            PDO::PARAM_INT);
            $qq->bindValue('NAME',  $infos['NAME'], PDO::PARAM_STR);
            $result = $qq->execute();
            return $result;
        }


        /**

                            getAll functions (used to fill dropdown on alteration's modal)

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
            $query = "SELECT * FROM MATURITY WHERE ID_MATURITY <> 0";
            $qq = $pdo->prepare($query);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }


        public static function getAllSpecies()
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT * FROM SPECIE WHERE ID_SPECIE <> 0";
            $qq = $pdo->prepare($query);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

        public static function getAllSubSpecies()
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT * FROM SUB_SPECIE WHERE ID_SUB_SPECIE <> 0";
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
            $query = "SELECT * FROM REGIME WHERE ID_REGIME <> 0";
            $qq = $pdo->prepare($query);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

   }
?>
