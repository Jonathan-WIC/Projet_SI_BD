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
            $query = "SELECT COUNT(ID_SPECIE) AS NB_SPECIES FROM SPECIE WHERE ID_SPECIE <> 0";
            $qq = $pdo->prepare($query);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }
    
        public static function fillSpecieTable($currentPage, $perPage)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "SELECT * FROM SPECIE WHERE ID_SPECIE <> 0 LIMIT :STARTPAGE, :PERPAGE";

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
            $query = "SELECT COUNT(ID_SUB_SPECIE) AS NB_SUB_SPECIE FROM SUB_SPECIE WHERE ID_SUB_SPECIE <> 0";
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
                        AND ID_SUB_SPECIE <> 0
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
            $query = "SELECT COUNT(ID_REGIME) AS NB_REGIME FROM REGIME WHERE ID_REGIME <> 0";
            $qq = $pdo->prepare($query);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }
    
        public static function fillRegimeTable($currentPage, $perPage)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "SELECT * FROM REGIME WHERE ID_REGIME <> 0 LIMIT :STARTPAGE, :PERPAGE";

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
            $query = "SELECT COUNT(ID_MATURITY) AS NB_MATURITY FROM MATURITY WHERE ID_MATURITY <> 0";
            $qq = $pdo->prepare($query);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }
   
        public static function fillMaturityTable($currentPage, $perPage)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "SELECT * FROM MATURITY WHERE ID_MATURITY <> 0 LIMIT :STARTPAGE, :PERPAGE";

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

                                        REQUESTS ABOUT ITEM'S REWARDED IN QUEST 

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

                                                REQUESTS ABOUT QUEST 

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
            $query = "SELECT * FROM QUEST ORDER BY ID_QUEST DESC LIMIT :STARTPAGE, :PERPAGE";

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


        /**

                                                REQUESTS ABOUT NEWSPAPER 

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
            $query = "DELETE FROM NEWSPAPER WHERE ID_NEWSPAPER = :ID";

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

                                                REQUESTS ABOUT NEWS

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


        /**

                            getAll functions (used to fill select on alteration's modal)

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
