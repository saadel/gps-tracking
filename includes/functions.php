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




    function plotLastEmployes()
    {
        $sql = "SELECT * FROM gpslocations AS gl1
                WHERE
                    (SELECT COUNT(*) 
                        FROM gpslocations AS gl2 
            WHERE gl2.phoneNumber = gl1.phoneNumber AND gl2.GPSLocationID > gl1.GPSLocationID
        ) = 0;";
        return $sql;
    }
    
    function escape($var)
    {
        return htmlEntities($var, ENT_QUOTES);
    }

    function generateBG($x) {
        $colors = ["blue","green","red","purple","yellow","white"];
        return $colors[$x];
    }

    // function plotEveryone($name)
    // {
    //     # code...
    // }
?>