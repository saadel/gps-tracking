<?php 
    require 'dbinfo.php';
    require 'includes/functions.php';

    function parseToXML($htmlStr)
    {
        $xmlStr=str_replace('<','&lt;',$htmlStr);
        $xmlStr=str_replace('>','&gt;',$xmlStr);
        $xmlStr=str_replace('"','&quot;',$xmlStr);
        $xmlStr=str_replace("'",'&#39;',$xmlStr);
        $xmlStr=str_replace("&",'&amp;',$xmlStr);
        return $xmlStr;
    }     

    $bdd = new PDO('mysql:host=localhost;dbname=' . DB_NAME . ';charset=gbk', DB_USER, DB_PASS);  

    // Select all the rows in the markers table
    $sql = plotAll("test");
    $result = $bdd->query($sql);

    header("Content-type: text/xml");

    // Start XML file, echo parent node
    echo '<markers>'; 
    // Iterate through the rows, printing XML nodes for each
    while ($donnees = $result->fetch()) {
      // ADD TO XML DOCUMENT NODE
      echo '<marker ';
      echo 'phoneNumber="' . parseToXML($donnees['phoneNumber']) . '" ';
      echo 'eventType="' . parseToXML($donnees['eventType']) . '" ';
      echo 'Latitude="' . $donnees['Latitude'] . '" ';
      echo 'Longitude="' . $donnees['Longitude'] . '" ';
      echo 'LastUpdate="' . $donnees['LastUpdate'] . '" ';
      echo '/>';
    }

    // End XML file
    echo '</markers>';
?>