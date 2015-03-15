<?php
    class MDBase_developpeur extends PDO {

        private static $engine = 'mysql';

        private static $dbName = 'DB_MONSTER_PARK' ;
        private static $dbHost = 'localhost' ;
        private static $dbUsername = 'developpeur';
        private static $dbUserPassword = 'dev';
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
            // One connection through whole application (avoid to log 2 accounts at the same time)
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
                      ORDER BY ID_MONSTER
                      LIMIT :STARTPAGE, :PERPAGE";
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

        public static function deleteMonster($id)
        {
            self::deleteElemMonster($id);

            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "DELETE FROM MONSTER WHERE ID_MONSTER = :ID";

            $qq = $pdo->prepare($query);
            $qq->bindValue('ID', $id, PDO::PARAM_INT);
            
            $result = $qq->execute();
            return $result;
        }

        public static function addMonster($infos)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "  INSERT INTO MONSTER (
                                        NAME,
                                        GENDER,
                                        AGE,
                                        WEIGHT,
                                        DANGER_SCALE,
                                        HEALTH_STATE,
                                        HUNGER_STATE,
                                        CLEAN_SCALE,
                                        ID_SUB_SPECIE,
                                        ID_MATURITY,
                                        ID_REGIME
                                    )
                             VALUES (
                                        :NAME,
                                        :GENDER,
                                        :AGE,
                                        :WEIGHT,
                                        :DANGER_SCALE,
                                        :HEALTH_STATE,
                                        :HUNGER_STATE,
                                        :CLEAN_SCALE,
                                        :ID_SUB_SPECIE,
                                        :ID_MATURITY,
                                        :ID_REGIME
                                    )";

            $qq = $pdo->prepare($query);

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

            //$temp return the ID of the last row inserted
            $temp = $pdo->lastInsertId();

            return $temp;
        }

        public static function updateElemMonster($id, $infos)
        {

            self::deleteElemMonster($id);

            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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

        public static function deleteElemMonster($id)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query  = "DELETE FROM ASSOC_MONSTER_ELEMENT WHERE ID_MONSTER = :ID;";
            $qq = $pdo->prepare($query);
            $qq->bindValue('ID', $id, PDO::PARAM_INT);
            $result = $qq->execute();

            return $result;
        }


        /**

                                                REQUEST ABOUT SPECIES
    
        **/
            
        public static function countSpecies()
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT COUNT(ID_SPECIE) AS NB_SPECIES FROM SPECIE";
            $qq = $pdo->prepare($query);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }
    
        public static function fillSpecieTable($currentPage, $perPage)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "SELECT * FROM SPECIE LIMIT :STARTPAGE, :PERPAGE";

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

        public static function deleteSpecie($id)
        {
            // necessary, it's a foreign key constraint (but it's very dirty cause some monsters can have their Specie to NULL)
            self::removeSpecieFromSubSpecie($id); 

            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = " DELETE FROM SPECIE WHERE ID_SPECIE = :ID";

            $qq = $pdo->prepare($query);

            $qq->bindValue('ID', $id, PDO::PARAM_INT);
            $result = $qq->execute();
            return $result;
        }

        public static function addSpecie($data)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query  = "INSERT INTO SPECIE (LIB_SPECIE) VALUES (:LIB_SPECIE)";
            $qq = $pdo->prepare($query);
            $qq->bindValue('LIB_SPECIE', $data['NAME'], PDO::PARAM_STR);
            $result = $qq->execute();

            return $result;
        }

        public static function removeSpecieFromSubSpecie($id)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query  = "UPDATE SUB_SPECIE SET ID_SUB_SPECIE = 0  WHERE ID_SPECIE = :ID";
            $qq = $pdo->prepare($query);
            $qq->bindValue('ID', $id, PDO::PARAM_INT);
            $result = $qq->execute();

            return $result;
        }


        /**

                                                REQUEST ABOUT SUB_SPECIES
    
        **/
            
        public static function countSubSpecies()
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT COUNT(ID_SUB_SPECIE) AS NB_SUB_SPECIE FROM SUB_SPECIE";
            $qq = $pdo->prepare($query);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }
    
        public static function fillSubSpecieTable($currentPage, $perPage)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "SELECT SSP.*, SP.LIB_SPECIE
                      FROM SUB_SPECIE SSP, SPECIE SP
                      WHERE SSP.ID_SPECIE = SP.ID_SPECIE
                      LIMIT :STARTPAGE, :PERPAGE";

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

        public static function deleteSubSpecie($id)
        {
            // necessary, it's a foreign key constraint (but it's very dirty cause some monsters can have their SubSpecie to NULL)
            self::removeSubSpecieFromMonster($id); 

            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = " DELETE FROM SUB_SPECIE WHERE ID_SUB_SPECIE = :ID";

            $qq = $pdo->prepare($query);

            $qq->bindValue('ID', $id, PDO::PARAM_INT);
            $result = $qq->execute();
            return $result;
        }

        public static function addSubSpecie($data)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query  = "INSERT INTO SUB_SPECIE (LIB_SUB_SPECIE, LIB_HABITAT, ID_SPECIE) VALUES (:LIB_SUB_SPECIE, :LIB_HABITAT, :ID_SPECIE)";
            $qq = $pdo->prepare($query);
            $qq->bindValue('LIB_SUB_SPECIE', $data['NAME'], PDO::PARAM_STR);
            $qq->bindValue('LIB_HABITAT', $data['HABITAT'], PDO::PARAM_STR);
            $qq->bindValue('ID_SPECIE', $data['ID_SPECIE'], PDO::PARAM_INT);
            $result = $qq->execute();

            return $result;
        }

        public static function removeSubSpecieFromMonster($id)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query  = "UPDATE SUB_SPECIE SET ID_SUB_SPECIE = 0  WHERE ID_SPECIE = :ID";
            $qq = $pdo->prepare($query);
            $qq->bindValue('ID', $id, PDO::PARAM_INT);
            $result = $qq->execute();

            return $result;
        }


        /**

                                                REQUEST ABOUT ELEMENTS
    
        **/
            
        public static function countElement()
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT COUNT(ID_ELEMENT) AS NB_ELEMENT FROM ELEMENT";
            $qq = $pdo->prepare($query);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }
    
        public static function fillElementTable($currentPage, $perPage)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "SELECT * FROM ELEMENT ORDER BY ID_ELEMENT LIMIT :STARTPAGE, :PERPAGE";

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

        public static function deleteElement($id)
        {
            self::deleteMonsterElem($id); // we need to delete all row in the ASSOC_MONSTER_ELEMENT before

            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = " DELETE FROM ELEMENT WHERE ID_ELEMENT = :ID";

            $qq = $pdo->prepare($query);

            $qq->bindValue('ID', $id, PDO::PARAM_INT);
            $result = $qq->execute();
            return $result;
        }

        public static function addElement($data)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query  = "INSERT INTO ELEMENT (LIB_ELEMENT) VALUES (:LIB_ELEMENT)";
            $qq = $pdo->prepare($query);
            $qq->bindValue('LIB_ELEMENT', $data['NAME'], PDO::PARAM_STR);
            $result = $qq->execute();

            return $result;
        }

        public static function deleteMonsterElem($id)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query  = "DELETE FROM ASSOC_MONSTER_ELEMENT WHERE ID_ELEMENT = :ID;";
            $qq = $pdo->prepare($query);
            $qq->bindValue('ID', $id, PDO::PARAM_INT);
            $result = $qq->execute();

            return $result;
        }


        /**

                                                REQUEST ABOUT REGIME
    
        **/
            
        public static function countRegime()
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT COUNT(ID_REGIME) AS NB_REGIME FROM REGIME";
            $qq = $pdo->prepare($query);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }
    
        public static function fillRegimeTable($currentPage, $perPage)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "SELECT * FROM REGIME LIMIT :STARTPAGE, :PERPAGE";

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

        public static function deleteRegime($id)
        {
            // necessary, it's a foreign key constraint (but it's very dirty cause some monsters can have their Regime to NULL)
            self::removeRegimeFromMonster($id); 

            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = " DELETE FROM REGIME WHERE ID_REGIME = :ID";

            $qq = $pdo->prepare($query);

            $qq->bindValue('ID', $id, PDO::PARAM_INT);
            $result = $qq->execute();
            return $result;
        }

        public static function addRegime($data)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query  = "INSERT INTO REGIME (LIB_REGIME) VALUES (:LIB_REGIME)";
            $qq = $pdo->prepare($query);
            $qq->bindValue('LIB_REGIME', $data['NAME'], PDO::PARAM_STR);
            $result = $qq->execute();

            return $result;
        }

        public static function removeRegimeFromMonster($id)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query  = "UPDATE MONSTER SET ID_REGIME = 0 WHERE ID_REGIME = :ID";
            $qq = $pdo->prepare($query);
            $qq->bindValue('ID', $id, PDO::PARAM_INT);
            $result = $qq->execute();

            return $result;
        }


        /**

                                                REQUEST ABOUT MATURITY
    
        **/
            
        public static function countMaturity()
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT COUNT(ID_MATURITY) AS NB_MATURITY FROM MATURITY";
            $qq = $pdo->prepare($query);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }
   
        public static function fillMaturityTable($currentPage, $perPage)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "SELECT * FROM MATURITY LIMIT :STARTPAGE, :PERPAGE";

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
            $query = "UPDATE MATURITY SET LIB_MATURITY = :NAME WHERE ID_MATURITY = :ID";

            $qq = $pdo->prepare($query);

            $qq->bindValue('ID',    $id,            PDO::PARAM_INT);
            $qq->bindValue('NAME',  $infos['NAME'], PDO::PARAM_STR);
            $result = $qq->execute();
            return $result;
        }

        public static function deleteMaturity($id)
        {
            // necessary, it's a foreign key constraint (but it's very dirty cause some monsters can have their maturity to NULL)
            self::removeMaturityFromMonster($id); 

            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = " DELETE FROM MATURITY WHERE ID_MATURITY = :ID";

            $qq = $pdo->prepare($query);

            $qq->bindValue('ID', $id, PDO::PARAM_INT);
            $result = $qq->execute();
            return $result;
        }

        public static function addMaturity($data)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query  = "INSERT INTO MATURITY (LIB_MATURITY) VALUES (:LIB_MATURITY)";
            $qq = $pdo->prepare($query);
            $qq->bindValue('LIB_MATURITY', $data['NAME'], PDO::PARAM_STR);
            $result = $qq->execute();

            return $result;
        }

        public static function removeMaturityFromMonster($id)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query  = "UPDATE MONSTER SET ID_MATURITY = 0 WHERE ID_MATURITY = :ID";
            $qq = $pdo->prepare($query);
            $qq->bindValue('ID', $id, PDO::PARAM_INT);
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

   }
?>
