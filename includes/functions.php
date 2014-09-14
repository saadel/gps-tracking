<?php
    function plotAll($array)
    {
        global $db;
        $sql = "SELECT * FROM gpslocations";
        $sql .= " WHERE phoneNumber IN( '".$array."')";
        $sql .= " ORDER BY phoneNumber;";
        $result = $db->query($sql);
        return $result;
    }

    function plotAllFromTo($array, $from = '2014-07-01 00:00:00', $to = '2214-07-01 00:00:00')
    {
        global $db;
        $sql = "SELECT * FROM gpslocations";
        $sql .= " WHERE phoneNumber IN( '".$array."')";
        $sql .= " AND LastUpdate BETWEEN '".$from."' AND '".$to."'";
        $sql .= " ORDER BY phoneNumber;";
        $result = $db->query($sql);
        return $result;
    }

    function plotLast($array)
    {
        global $db;
        $sql = "SELECT Latitude,Longitude,phoneNumber,MAX(LastUpdate) FROM gpslocations WHERE phoneNumber IN( '".$array."')";
        $sql .= " GROUP BY phoneNumber ";
        $result = $db->query($sql);
        return $result;
    }

    function escape($var)
    {
        return htmlEntities($var, ENT_QUOTES);
    }

    function generateBG($x) {
        $colors = ["blue","green","red","purple","yellow","white"];
        while ($x > 5) {
            $x -= 5;
        }
        return $colors[$x];
    }
?>