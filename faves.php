<?php
    session_start();
    if(count($_SESSION['favorites']) == 0){
        echo "no faveorites set";
    }
    else{
        
    
    
    
    
    
    $host = "localhost";
    $username = "dakell3162";
    $password = "";
    $dbname = "plants";
    $conn = new PDO("mysql:host=$host;dbname=$dbname",$username,$password);
    $conn -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    
    #build the sql string
    $where = "where id in (";
    foreach($_SESSION['favorites'] as $fave){
        $where = $where . $fave . ", ";
    }
    $where = substr($where, 0, -2);
    $where = $where . ")";
    
    
    
    $sql = "select * from plant_types ". $where . ";";
    echo $sql;
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    $records = $stmt->fetchALL(PDO::FETCH_ASSOC);
    echo "<form id = \"fave\" method = \"post\">";
    echo "<table>";
    foreach($records as $record){
        echo "<tr>";
        echo "<th>" . $record['scientific_name'] . "<th/>";
        echo "<input type=\"checkbox\" name=\"faveCheckbox[]\" value=\"" . $record['id'] . "\">";
        echo "<tr/>";
    }
    echo "<tr>";
    echo "<th> <input type=\"submit\" value=\"Remove Faves\"> <th/>";
    echo "<tr/>";
    echo "<form/>";
    
    }
    
?>