<?php
    require_once(__DIR__."/../dbinfo.php");

    class Employe
    {

        private static $_table = "employe";
        private $employe;

        public function __construct()
        {
            $this->employe = array(
                "emp_id"=>null,
                "emp_nom"=>null,
                "emp_prenom"=>null,
                "emp_surnom"=>null,
                "soc_id"=>null
            );
        }

        public function get_employe()
        {
            return $this->employe;
        }

        public function set_employe($key, $value)
        {
            $this->employe[$key] = $value;
        }

        public function find_by_id($id)
        {
            global $db;

            $sql = "SELECT * FROM " . self::$_table;
            $sql .= " WHERE emp_id=:id"; 
            $sql .= " LIMIT 1;";

            $re = $db->query($sql, array("id"=>$id));
            $resultat = $re->fetch(PDO::FETCH_ASSOC);

            if(empty($resultat))
            {
                $this->employe = array();
            }
            else
            {
                $this->employe = $resultat;
            }   
        }

        public function count_all()
        {
            global $db;

            $sql = "SELECT COUNT(*) FROM " . self::$_table . ";";

            $re = $db->query($sql);
            $resultat = $re->fetch(PDO::FETCH_ASSOC);
            
            return array_shift($resultat);
        }

        public function create()
        {
            global $db;

            $sql = "INSERT INTO " . self::$_table;
            $sql .= " (" . implode(",",array_keys($this->employe)) . ")";
            $sql .= " values(:".implode(", :",array_keys($this->employe)) . ");";
            
            $re = $db->query($sql, $this->employe);

            if($db->affected_rows($re) > 0)
            {
                $this->find_by_id($db->last_insert_id());
                return true;
            }
            else
            {
                return false;
            }        
        }

        public function delete()
        {
            global $db;
            $sql = "DELETE FROM " . self::$_table;
            $sql .= " WHERE emp_id=:emp_id;";           
            $re = $db->query($sql, array("emp_id"=>$this->employe["emp_id"]));
            if($db->affected_rows($re) > 0)
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        public function update()
        {
            global $db;

            $shifted = $this->employe;
            array_shift($shifted);
            $array_key_key = array();

            foreach($shifted as $key => $val)
            {
                $array_key_key[] = $key . "=:" . $key;
            }
            
            $sql = "UPDATE " . self::$_table;
            $sql .= " SET ". implode(",", $array_key_key);
            $sql .= " WHERE emp_id=:emp_id;";
            
            $re = $db->query($sql, $this->employe);

            if($db->affected_rows($re) > 0)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    
        public function attache($soc_id)
        {
            global $db;
            $sql="insert 
                into employe
                values(:soc_id,:emp_id) ";
                $re=$db->query($sql,array("soc_id"=>$soc_id,"emp_id"=>$this->employe["emp_id"]));
                if($db->affected_rows($re)>0)
                {
                    return true;
                }else
                {
                    
                    return false;
                }   
        }

        public static function employes()
        {
            global $db;

            $sql = "SELECT *
                    FROM ".self::$_table.";";   
           
            $list = array();
            $re = $db->query($sql);
            $list = $re->fetchAll(PDO::FETCH_ASSOC);
            
            return $list;
        }

        public static function liste_employes_societe($soc_id,$offset=0,$limit=10)
        {
        
            global $db;
            $sql="select 
                  emp_id, emp_nom, emp_prenom, emp_surnom
                  from employe
                  where soc_id=:soc_id
                  limit  ".$offset.",".$limit.";";  
           
            $list=array();
            $re=$db->query($sql,array("soc_id"=>$soc_id));
            $list=$re->fetchAll(PDO::FETCH_ASSOC);
            return $list;
        
        }
        
    }


?>