<?php 
    function plotAll($name)
    {        
        $sql = "SELECT * FROM gpslocations";
        $sql .= " WHERE phoneNumber=\"". $name ."\";";
        return $sql;
    }

    function plotLast($name)
    {
        $sql = "SELECT * FROM gpslocations WHERE phoneNumber=\"". $name ."\"";
        $sql .= " ORDER BY LastUpdate desc ";
        $sql .= "LIMIT 1;";
        return $sql;
    }

    // function plotEveryone($name)
    // {
    //     # code...
    // }
?>