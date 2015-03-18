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

            if($search['ID_PERSO'] == 0 AND $search['ID_PERSO'] != "")
                $condition .= " AND M.ID_PERSO IS NULL " ;
            else if($search['ID_PERSO'] != "")
                $condition .= " AND M.ID_PERSO = ". $search['ID_PERSO'];

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

                                                REQUEST ABOUT ACCOUNT
    
        **/
            
        public static function countAccount()
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT COUNT(ID_ACCOUNT) AS NB_ACCOUNT FROM ACCOUNT WHERE ID_ACCOUNT <> 0";
            $qq = $pdo->prepare($query);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }
    
        public static function fillAccountTable($currentPage, $perPage, $data)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $condition = "";
            if($data['PSEUDO'] != "")
                $condition .= " AND PSEUDO LIKE '".$data['PSEUDO']."%' ";
            if($data['GENDER'] != "null")
                $condition .= " AND GENDER = '".$data['GENDER']."' ";
            if($data['AGE'] != "")
                $condition .= " AND AGE >= ".$data['AGE']." ";
            if($data['DATEREG'] != "")
                $condition .= " AND DATE_INSCRIPTION = '".$data['DATEREG']."' ";
            if($data['DATECO'] != "")
                $condition .= " AND DATE_LAST_CONNEXION >= '".$data['DATECO']."' ";

           //echo $condition;

            $query = "SELECT * FROM ACCOUNT WHERE ID_ACCOUNT <> 0 ".$condition." LIMIT :STARTPAGE, :PERPAGE";

            //echo $query;

            $qq = $pdo->prepare($query);
            $qq->bindValue('STARTPAGE', ($currentPage-1)*$perPage, PDO::PARAM_INT);
            $qq->bindValue('PERPAGE', $perPage, PDO::PARAM_INT);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

        public static function getPersoAccount()
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT A.ID_ACCOUNT, P.LAST_NAME, P.FIRST_NAME
                      FROM ACCOUNT A, PERSO P
                      WHERE A.ID_ACCOUNT = P.ID_ACCOUNT";
            $qq = $pdo->prepare($query);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

    
        public static function getAccountInfos($id)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "SELECT * FROM ACCOUNT WHERE ID_ACCOUNT = :ID";

            $qq = $pdo->prepare($query);
            $qq->bindValue('ID', $id, PDO::PARAM_INT);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }


        public static function updateAccount($id, $infos)
        {
             $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "  UPDATE ACCOUNT
                        SET  PSEUDO = :PSEUDO,
                             PASSWORD = :PASSWORD,
                             GENDER = :GENDER,
                             AGE = :AGE,
                             PHONE_NUMBER = :PHONE_NUMBER,
                             EMAIL = :EMAIL,
                             WEBSITE = :WEBSITE,
                             DESCRIPTION = :DESCRIPTION
                       WHERE ID_ACCOUNT = :ID";

            $qq = $pdo->prepare($query);

            $qq->bindValue('ID', $id, PDO::PARAM_INT);
            $qq->bindValue('PSEUDO', $infos['PSEUDO'], PDO::PARAM_STR);
            $qq->bindValue('PASSWORD', $infos['PASSWORD'], PDO::PARAM_STR);
            $qq->bindValue('GENDER', $infos['GENDER'], PDO::PARAM_STR);
            $qq->bindValue('AGE', $infos['AGE'], PDO::PARAM_INT);
            $qq->bindValue('PHONE_NUMBER', $infos['PHONE_NUMBER'], PDO::PARAM_STR);
            $qq->bindValue('EMAIL', $infos['EMAIL'], PDO::PARAM_STR);
            $qq->bindValue('WEBSITE', $infos['WEBSITE'], PDO::PARAM_STR);
            $qq->bindValue('DESCRIPTION', $infos['DESCRIPTION'], PDO::PARAM_STR);
            $result = $qq->execute();
            return $result;
        }

        public static function deleteAccount($id)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = " DELETE FROM ACCOUNT WHERE ID_ACCOUNT = :ID";

            $qq = $pdo->prepare($query);

            $qq->bindValue('ID', $id, PDO::PARAM_INT);
            $result = $qq->execute();
            return $result;
        }

        public static function addAccount($infos)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query  = "INSERT INTO ACCOUNT (
                                            PSEUDO,
                                            PASSWORD,
                                            GENDER,
                                            AGE,
                                            PHONE_NUMBER,
                                            EMAIL,
                                            WEBSITE,
                                            DESCRIPTION
                                            )
                                    VALUES (
                                            :PSEUDO,
                                            :PASSWORD,
                                            :GENDER,
                                            :AGE,
                                            :PHONE_NUMBER,
                                            :EMAIL,
                                            :WEBSITE,
                                            :DESCRIPTION
                                            )";
            $qq = $pdo->prepare($query);
            $qq->bindValue('PSEUDO', $infos['PSEUDO'], PDO::PARAM_STR);
            $qq->bindValue('PASSWORD', $infos['PASSWORD'], PDO::PARAM_STR);
            $qq->bindValue('GENDER', $infos['GENDER'], PDO::PARAM_STR);
            $qq->bindValue('AGE', $infos['AGE'], PDO::PARAM_INT);
            $qq->bindValue('PHONE_NUMBER', $infos['PHONE_NUMBER'], PDO::PARAM_STR);
            $qq->bindValue('EMAIL', $infos['EMAIL'], PDO::PARAM_STR);
            $qq->bindValue('WEBSITE', $infos['WEBSITE'], PDO::PARAM_STR);
            $qq->bindValue('DESCRIPTION', $infos['DESCRIPTION'], PDO::PARAM_STR);
            $result = $qq->execute();

            return $result;
        }

        public static function selectPersoFromAccount($id)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "SELECT ID_PERSO FROM PERSO WHERE ID_ACCOUNT = :ID";

            $qq = $pdo->prepare($query);
            $qq->bindValue('ID', $id, PDO::PARAM_INT);

            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

        /**

                                                REQUEST ABOUT PLAYER
    
        **/
            
        public static function countPlayer()
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT COUNT(ID_PERSO) AS NB_PERSO FROM PERSO WHERE ID_PERSO <> 0";
            $qq = $pdo->prepare($query);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }
    
        public static function fillPlayerTable($currentPage, $perPage)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "SELECT * FROM PERSO WHERE ID_PERSO <> 0 LIMIT :STARTPAGE, :PERPAGE";

            $qq = $pdo->prepare($query);
            $qq->bindValue('STARTPAGE', ($currentPage-1)*$perPage, PDO::PARAM_INT);
            $qq->bindValue('PERPAGE', $perPage, PDO::PARAM_INT);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

        public static function getPlayerQuest()
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT Q.NAME, P.ID_PERSO
                      FROM QUEST Q, PERSO P, ASSOC_PERSO_QUEST APQ
                      WHERE P.ID_PERSO = APQ.ID_PERSO
                        AND APQ.ID_QUEST = Q.ID_QUEST";
            $qq = $pdo->prepare($query);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

        public static function getPlayerpark()
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT PA.NAME_PARK, PA.ID_PERSO
                      FROM PARK PA, PERSO P
                      WHERE PA.ID_PERSO = P.ID_PERSO";
            $qq = $pdo->prepare($query);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

        public static function getPlayerMonster()
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT M.NAME, M.ID_PERSO
                      FROM MONSTER M, PERSO P
                      WHERE M.ID_PERSO = P.ID_PERSO";
            $qq = $pdo->prepare($query);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

        public static function getPlayerItem()
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT I.LIB_ITEM, P.ID_PERSO
                      FROM ITEM I, PERSO P, PERSO_STOCK_ITEM PSI
                      WHERE P.ID_PERSO = PSI.ID_PERSO
                        AND PSI.ID_ITEM = I.ID_ITEM";
            $qq = $pdo->prepare($query);
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
                           SET FIRST_NAME = :FIRST_NAME,
                               LAST_NAME = :LAST_NAME,
                               GENDER = :GENDER,
                               PMONEY = :PMONEY,
                               ID_ACCOUNT = :ID_ACCOUNT
                         WHERE ID_PERSO = :ID";

            $qq = $pdo->prepare($query);

            $qq->bindValue('ID', $id, PDO::PARAM_INT);
            $qq->bindValue('FIRST_NAME', $infos['FIRST_NAME'], PDO::PARAM_STR);
            $qq->bindValue('LAST_NAME', $infos['LAST_NAME'], PDO::PARAM_STR);
            $qq->bindValue('GENDER', $infos['GENDER'], PDO::PARAM_STR);
            $qq->bindValue('PMONEY', $infos['PMONEY'], PDO::PARAM_INT);
            $qq->bindValue('ID_ACCOUNT', $infos['ID_ACCOUNT'], PDO::PARAM_INT);
            $result = $qq->execute();
            return $result;
        }

        public static function deletePlayer($id)
        {

            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = " DELETE FROM PERSO_STOCK_ITEM WHERE ID_PERSO = :ID;
                       DELETE FROM ASSOC_PERSO_QUEST WHERE ID_PERSO = :ID;
                       DELETE FROM PARK WHERE ID_PERSO = :ID;
                       DELETE FROM MONSTER WHERE ID_PERSO = :ID;
                       DELETE FROM PERSO WHERE ID_PERSO = :ID;";

            $qq = $pdo->prepare($query);

            $qq->bindValue('ID', $id, PDO::PARAM_INT);
            $result = $qq->execute();
            return $result;
        }

        public static function addPlayer($infos)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query  = "INSERT INTO PERSO (
                                            FIRST_NAME,
                                            LAST_NAME,
                                            GENDER,
                                            PMONEY,
                                            ID_ACCOUNT
                                            )
                                    VALUES (
                                            :FIRST_NAME,
                                            :LAST_NAME,
                                            :GENDER,
                                            :PMONEY,
                                            :ID_ACCOUNT
                                            )";
            $qq = $pdo->prepare($query);
            $qq->bindValue('FIRST_NAME', $infos['FIRST_NAME'], PDO::PARAM_STR);
            $qq->bindValue('LAST_NAME', $infos['LAST_NAME'], PDO::PARAM_STR);
            $qq->bindValue('GENDER', $infos['GENDER'], PDO::PARAM_STR);
            $qq->bindValue('PMONEY', $infos['PMONEY'], PDO::PARAM_INT);
            $qq->bindValue('ID_ACCOUNT', $infos['ID_ACCOUNT'], PDO::PARAM_INT);
            $result = $qq->execute();

            return $result;
        }


        /**

                                                REQUEST ABOUT PARK
    
        **/
            
        public static function countPark()
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT COUNT(ID_PARK) AS NB_PARK FROM PARK";
            $qq = $pdo->prepare($query);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }
    
        public static function fillParkTable($currentPage, $perPage, $search)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $condition = "";
            if($search['NAME_PARK'] != "")
                $condition .= " WHERE NAME_PARK LIKE '".$search['NAME_PARK']."%' ";
            if($search['CAPACITY_ENCLOSURE'] != "")
                if($condition == "")
                    $condition .= " WHERE CAPACITY_ENCLOSURE >= ".$search['CAPACITY_ENCLOSURE'];
                else
                    $condition .= " AND CAPACITY_ENCLOSURE >= ".$search['CAPACITY_ENCLOSURE'];

            if($search['ID_PERSO'] == 0 AND $search['ID_PERSO'] != "")
                if($condition == "")
                    $condition .= " WHERE ID_PERSO IS NULL " ;
                else
                    $condition .= " AND ID_PERSO IS NULL ";
            else if($search['ID_PERSO'] != "")
                if($condition == "")
                    $condition .= " WHERE ID_PERSO = ".$search['ID_PERSO'];
                else
                    $condition .= " AND ID_PERSO = ".$search['ID_PERSO'];

            $query = "SELECT * FROM PARK ".$condition." LIMIT :STARTPAGE, :PERPAGE";

            $qq = $pdo->prepare($query);
            $qq->bindValue('STARTPAGE', ($currentPage-1)*$perPage, PDO::PARAM_INT);
            $qq->bindValue('PERPAGE', $perPage, PDO::PARAM_INT);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }
   
        public static function getEnclosurePark()
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "SELECT ID_ENCLOSURE, ID_PARK FROM ENCLOSURE";

            $qq = $pdo->prepare($query);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }
    
        public static function getParkInfos($id)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "SELECT * FROM PARK WHERE ID_PARK = :ID";

            $qq = $pdo->prepare($query);
            $qq->bindValue('ID', $id, PDO::PARAM_INT);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }


        public static function updatePark($id, $infos)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "UPDATE PARK SET  NAME_PARK = :NAME_PARK,
                                       CAPACITY_ENCLOSURE = :CAPACITY_ENCLOSURE,
                                       ID_PERSO = :ID_PERSO
                      WHERE ID_PARK = :ID";

            $qq = $pdo->prepare($query);

            $qq->bindValue('ID', $id, PDO::PARAM_INT);
            $qq->bindValue('NAME_PARK', $infos['NAME_PARK'], PDO::PARAM_STR);
            $qq->bindValue('CAPACITY_ENCLOSURE', $infos['CAPACITY_ENCLOSURE'], PDO::PARAM_INT);
            $qq->bindValue('ID_PERSO', $infos['ID_PERSO'], PDO::PARAM_INT);
            $result = $qq->execute();
            return $result;
        }

        public static function deletePark($id)
        {
            self::removeEnclosureWithPark($id);

            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = " DELETE FROM PARK WHERE ID_PARK = :ID";

            $qq = $pdo->prepare($query);

            $qq->bindValue('ID', $id, PDO::PARAM_INT);
            $result = $qq->execute();
            return $result;
        }

        public static function removeEnclosureWithPark($id)
        {

            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = " DELETE FROM ENCLOSURE WHERE ID_PARK = :ID;
                       UPDATE MONSTER SET ID_ENCLOSURE = NULL;";

            $qq = $pdo->prepare($query);

            $qq->bindValue('ID', $id, PDO::PARAM_INT);
            $result = $qq->execute();
            return $result;
        }

        public static function addPark($infos)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query  = "INSERT INTO PARK 
                                  (NAME_PARK,
                                   CAPACITY_ENCLOSURE,
                                   ID_PERSO)

                        VALUES    (:NAME_PARK,
                                   :CAPACITY_ENCLOSURE,
                                   :ID_PERSO)";

            $qq = $pdo->prepare($query);
            $qq->bindValue('NAME_PARK', $infos['NAME_PARK'], PDO::PARAM_STR);
            $qq->bindValue('CAPACITY_ENCLOSURE', $infos['CAPACITY_ENCLOSURE'], PDO::PARAM_INT);
            $qq->bindValue('ID_PERSO', $infos['ID_PERSO'], PDO::PARAM_INT);
            $result = $qq->execute();

            return $result;
        }

        /**

                                                REQUEST ABOUT ENCLOSURE
    
        **/
            
        public static function countEnclosure()
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT COUNT(ID_ENCLOSURE) AS NB_ENCLOSURE FROM ENCLOSURE";
            $qq = $pdo->prepare($query);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }
    
        public static function fillEnclosureTable($currentPage, $perPage, $search)
        {
            $condition = "";
            if($search['ID_PARK'] != "")
                $condition .= " AND ID_PARK = ".$search['ID_PARK'];
            if($search['TYPE_ENCLOS'] != "")
                $condition .= " AND TYPE_ENCLOS LIKE '".$search['TYPE_ENCLOS']."%' ";
            if($search['CAPACITY_MONSTER'] != "")
                $condition .= " AND CAPACITY_MONSTER >= ".$search['CAPACITY_MONSTER'];
            if($search['PRICE'] != "")
                $condition .= " AND PRICE <= ".$search['PRICE'];
            if($search['CLIMATE'] != "")
                $condition .= " AND CLIMATE LIKE '".$search['CLIMATE']."%' ";
            if($search['LIB_SUB_SPECIE'] != "")
                $condition .= " AND SSP.LIB_SUB_SPECIE LIKE '".$search['LIB_SUB_SPECIE']."%' ";

            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "SELECT E.*, SSP.LIB_SUB_SPECIE
                      FROM ENCLOSURE E, SUB_SPECIE SSP
                      WHERE E.ID_SUB_SPECIE = SSP.ID_SUB_SPECIE";
            $query.=  $condition." LIMIT :STARTPAGE, :PERPAGE ";

            $qq = $pdo->prepare($query);
            $qq->bindValue('STARTPAGE', ($currentPage-1)*$perPage, PDO::PARAM_INT);
            $qq->bindValue('PERPAGE', $perPage, PDO::PARAM_INT);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }
    
        public static function getEnclosureInfos($id)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "SELECT * FROM ENCLOSURE WHERE ID_ENCLOSURE = :ID";

            $qq = $pdo->prepare($query);
            $qq->bindValue('ID', $id, PDO::PARAM_INT);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }


        public static function updateEnclosure($id, $infos)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "UPDATE ENCLOSURE SET  ID_PARK = :ID_PARK,
                                            TYPE_ENCLOS = :TYPE_ENCLOS,
                                            CAPACITY_MONSTER = :CAPACITY_MONSTER,
                                            PRICE = :PRICE,
                                            CLIMATE = :CLIMATE,
                                            ID_SUB_SPECIE = :ID_SUB_SPECIE
                      WHERE ID_ENCLOSURE = :ID";

            $qq = $pdo->prepare($query);

            $qq->bindValue('ID', $id, PDO::PARAM_INT);
            $qq->bindValue('ID_PARK', $infos['ID_PARK'], PDO::PARAM_INT);
            $qq->bindValue('TYPE_ENCLOS', $infos['TYPE_ENCLOS'], PDO::PARAM_STR);
            $qq->bindValue('CAPACITY_MONSTER', $infos['CAPACITY_MONSTER'], PDO::PARAM_INT);
            $qq->bindValue('PRICE', $infos['PRICE'], PDO::PARAM_INT);
            $qq->bindValue('CLIMATE', $infos['CLIMATE'], PDO::PARAM_STR);
            $qq->bindValue('ID_SUB_SPECIE', $infos['ID_SUB_SPECIE'], PDO::PARAM_INT);
            $result = $qq->execute();
            return $result;
        }

        public static function deleteEnclosure($id)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = " UPDATE MONSTER SET ID_ENCLOSURE = NULL WHERE ID_ENCLOSURE = :ID;
                       DELETE FROM ENCLOSURE WHERE ID_ENCLOSURE = :ID;";

            $qq = $pdo->prepare($query);

            $qq->bindValue('ID', $id, PDO::PARAM_INT);
            $result = $qq->execute();
            return $result;
        }

        public static function addEnclosure($infos)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query  = "INSERT INTO ENCLOSURE 
                                  (ID_PARK,
                                   TYPE_ENCLOS,
                                   CAPACITY_MONSTER,
                                   PRICE,
                                   CLIMATE,
                                   ID_SUB_SPECIE)

                        VALUES    (:ID_PARK,
                                   :TYPE_ENCLOS,
                                   :CAPACITY_MONSTER,
                                   :PRICE,
                                   :CLIMATE,
                                   :ID_SUB_SPECIE)";

            $qq = $pdo->prepare($query);
            $qq->bindValue('ID_PARK', $infos['ID_PARK'], PDO::PARAM_INT);
            $qq->bindValue('TYPE_ENCLOS', $infos['TYPE_ENCLOS'], PDO::PARAM_STR);
            $qq->bindValue('CAPACITY_MONSTER', $infos['CAPACITY_MONSTER'], PDO::PARAM_INT);
            $qq->bindValue('PRICE', $infos['PRICE'], PDO::PARAM_INT);
            $qq->bindValue('CLIMATE', $infos['CLIMATE'], PDO::PARAM_STR);
            $qq->bindValue('ID_SUB_SPECIE', $infos['ID_SUB_SPECIE'], PDO::PARAM_INT);
            $result = $qq->execute();

            return $result;
        }

        /**

                                                REQUEST ABOUT ITEM
    
        **/
            
        public static function countItem()
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT COUNT(ID_ITEM) AS NB_ITEM FROM ITEM";
            $qq = $pdo->prepare($query);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }
    
        public static function fillItemTable($currentPage, $perPage, $search)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $condition = "";
            if($search['LIB_ITEM'] != "")
                $condition .= " WHERE LIB_ITEM LIKE '".$search['LIB_ITEM']."%' ";            
            if($search['TYPE_ITEM'] != "")
                if($condition != "")
                    $condition .= " AND TYPE_ITEM LIKE '".$search['TYPE_ITEM']."%' ";
                else
                    $condition .= " WHERE TYPE_ITEM LIKE '".$search['TYPE_ITEM']."%' ";
            if($search['FAMILY_ITEM'] != "")
                if($condition != "")
                    $condition .= " AND FAMILY_ITEM LIKE '".$search['FAMILY_ITEM']."%' ";
                else
                    $condition .= " WHERE FAMILY_ITEM LIKE '".$search['FAMILY_ITEM']."%' ";
            if($search['PRIX_ITEM'] != "")
                if($condition != "")
                    $condition .= " AND PRIX_ITEM LIKE '".$search['PRIX_ITEM']."%' ";
                else
                    $condition .= " WHERE PRIX_ITEM <= ".$search['PRIX_ITEM'];


            $query = "SELECT * FROM ITEM ".$condition." LIMIT :STARTPAGE, :PERPAGE";

            $qq = $pdo->prepare($query);
            $qq->bindValue('STARTPAGE', ($currentPage-1)*$perPage, PDO::PARAM_INT);
            $qq->bindValue('PERPAGE', $perPage, PDO::PARAM_INT);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }
    
        public static function getItemInfos($id)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "SELECT * FROM ITEM WHERE ID_ITEM = :ID";

            $qq = $pdo->prepare($query);
            $qq->bindValue('ID', $id, PDO::PARAM_INT);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }


        public static function updateItem($id, $infos)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "UPDATE ITEM SET LIB_ITEM = :LIB_ITEM,
                                      TYPE_ITEM = :TYPE_ITEM,
                                      FAMILY_ITEM = :FAMILY_ITEM,
                                      PRIX_ITEM = :PRIX_ITEM
                      WHERE ID_ITEM = :ID";

            $qq = $pdo->prepare($query);

            $qq->bindValue('ID', $id, PDO::PARAM_INT);
            $qq->bindValue('LIB_ITEM', $infos['LIB_ITEM'], PDO::PARAM_STR);
            $qq->bindValue('TYPE_ITEM', $infos['TYPE_ITEM'], PDO::PARAM_STR);
            $qq->bindValue('FAMILY_ITEM', $infos['FAMILY_ITEM'], PDO::PARAM_STR);
            $qq->bindValue('PRIX_ITEM', $infos['PRIX_ITEM'], PDO::PARAM_INT);
            $result = $qq->execute();
            return $result;
        }

        public static function deleteItem($id)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = " DELETE FROM PERSO_STOCK_ITEM WHERE ID_ITEM = :ID;
                       DELETE FROM QUEST_REWARD_ITEM WHERE ID_ITEM = :ID;
                       DELETE FROM ITEM WHERE ID_ITEM = :ID; ";

            $qq = $pdo->prepare($query);

            $qq->bindValue('ID', $id, PDO::PARAM_INT);
            $result = $qq->execute();
            return $result;
        }

        public static function addItem($infos)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query  = "INSERT INTO ITEM 
                                  (LIB_ITEM,
                                   TYPE_ITEM,
                                   FAMILY_ITEM,
                                   PRIX_ITEM)

                        VALUES    (:LIB_ITEM,
                                   :TYPE_ITEM,
                                   :FAMILY_ITEM,
                                   :PRIX_ITEM)";

            $qq = $pdo->prepare($query);
            $qq->bindValue('LIB_ITEM', $infos['LIB_ITEM'], PDO::PARAM_STR);
            $qq->bindValue('TYPE_ITEM', $infos['TYPE_ITEM'], PDO::PARAM_STR);
            $qq->bindValue('FAMILY_ITEM', $infos['FAMILY_ITEM'], PDO::PARAM_STR);
            $qq->bindValue('PRIX_ITEM', $infos['PRIX_ITEM'], PDO::PARAM_INT);
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

        public static function deleteSpecie($id)
        {
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

        public static function selectSubSpecieFromSpecie($id)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query  = "SELECT ID_SUB_SPECIE FROM SUB_SPECIE WHERE ID_SPECIE = :ID_SPECIE";
            $qq = $pdo->prepare($query);
            $qq->bindValue('ID_SPECIE', $id, PDO::PARAM_INT);
            $result = $qq->execute();

            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
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

        public static function deleteSubSpecie($id)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "UPDATE MONSTER SET  ID_SUB_SPECIE = 0;
                      DELETE FROM ENCLOSURE WHERE ID_SUB_SPECIE = :ID;
                      DELETE FROM SUB_SPECIE WHERE ID_SUB_SPECIE = :ID;";
            $qq = $pdo->prepare($query);
            $qq->bindValue('ID', $id, PDO::PARAM_INT);
            $result = $qq->execute();
            return $result;
        }

        public static function addSubSpecie($data)
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query  = "INSERT INTO SUB_SPECIE (LIB_SUB_SPECIE, LIB_HABITAT, ID_SPECIE) 
                            VALUES (:LIB_SUB_SPECIE, :LIB_HABITAT, :ID_SPECIE)";
            $qq = $pdo->prepare($query);
            $qq->bindValue('LIB_SUB_SPECIE', $data['NAME'], PDO::PARAM_STR);
            $qq->bindValue('LIB_HABITAT', $data['HABITAT'], PDO::PARAM_STR);
            $qq->bindValue('ID_SPECIE', $data['ID_SPECIE'], PDO::PARAM_INT);
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
    
        public static function fillElementTable($currentPage, $perPage, $search)
        {

            $condition = "";
            if($search['LIB_ELEMENT'] != "")
                $condition .= " WHERE LIB_ELEMENT LIKE '". $search['LIB_ELEMENT'] ."%' ";

            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "SELECT * FROM ELEMENT ".$condition." ORDER BY ID_ELEMENT LIMIT :STARTPAGE, :PERPAGE";

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
            $query = "SELECT * FROM SPECIE WHERE ID_SPECIE <> 0 LIMIT 30";
            $qq = $pdo->prepare($query);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

        public static function getAllSubSpecies()
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT * FROM SUB_SPECIE WHERE ID_SUB_SPECIE <> 0 LIMIT 30";
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
      
        public static function getAllPark()
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT ID_PARK FROM PARK LIMIT 30";
            $qq = $pdo->prepare($query);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }
      
        public static function getAllPerso()
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT ID_PERSO FROM PERSO LIMIT 30";
            $qq = $pdo->prepare($query);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

        public static function getAllAccount()
        {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT ID_ACCOUNT FROM ACCOUNT LIMIT 30";
            $qq = $pdo->prepare($query);
            $qq->execute();
            $data = $qq->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

   }
?>
