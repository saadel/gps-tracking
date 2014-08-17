<?php

    require_once(__DIR__."dbinfo.php");

    class societe
    {

        private static $_table = "societe";
        private $societe;

        public function __construct()
        {
            $this->societe = array(
                "s_id"=>null,
                "s_nom"=>null,
                "s_prenom"=>null
            );
        }
        
        public function get_societe()
        {
            return $this->societe;
        }

        public function set_societe($key, $value)
        {
            $this->societe[$key] = $value;
        }

        public function find_by_id($id)
        {
            global $db;

            $sql = "SELECT * FROM " . self::$_table;
            $sql .= " WHERE s_id=:id"; 
            $sql .= " LIMIT 1;";

            $re = $db->query($sql, array("id"=>$id));
            $resultat = $re->fetch(PDO::FETCH_ASSOC);

            if(empty($resultat))
            {
                $this->societe = array();
            }
            else
            {
                $this->societe = $resultat;
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
            $sql .= " (" . implode(",",array_keys($this->societe)) . ")";
            $sql .= " values(:".implode(", :",array_keys($this->societe)) . ");";
            
            $re = $db->query($sql, $this->societe);

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

        public function update()
        {
            global $db;

            $shifted = $this->societe;
            array_shift($shifted);
            $array_key_key = array();

            foreach($shifted as $key => $val)
            {
                $array_key_key[] = $key . "=:" . $key;
            }
            
            $sql = "UPDATE " . self::$_table;
            $sql .= " SET ". implode(",", $array_key_key);
            $sql .= " WHERE s_id=:s_id;";
            
            $re = $db->query($sql, $this->societe);

            if($db->affected_rows($re) > 0)
            {
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
            $sql .= " WHERE s_id=:s_id;";           
            $re = $db->query($sql, array("s_id"=>$this->societe["s_id"]));
            if($db->affected_rows($re) > 0)
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        public static function societes()
        {
            global $db;

            $sql = "SELECT *
                    FROM ".self::$_table.";";   
           
            $list = array();
            $re = $db->query($sql);
            $list = $re->fetchAll(PDO::FETCH_ASSOC);
            
            return $list;
        }
        
    }


?>