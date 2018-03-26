<?php

session_start();
if(!isset($_SESSION['favorites'])){
    $_SESSION['favorites'] = array();
}
if(isset($_POST['faveCheckbox'])){
    foreach($_POST['faveCheckbox'] as $fave){
        if(array_search($fave, $_SESSION['favorites'], false) === false){
            array_push($_SESSION['favorites'], $fave);
        }
    }
}

echo count($_SESSION['favorites']);



$host = "localhost";
$username = "dakell3162";
$password = "";
$dbname = "plants";

    $conn = new PDO("mysql:host=$host;dbname=$dbname",$username,$password);
    $conn -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    
    
    
    

    $water = "";
    $sun = "";
    if(isset($_POST['water3'])) {
        if(!empty($water)){
            $water = $water . ", ";
        }
        $water = $water . "'3'";
    }
    if(isset($_POST['water2'])) {
        if(!empty($water)){
            $water = $water . ", ";
        }
        $water = $water . "'2'";
    }
    if(isset($_POST['water1'])) {
        if(!empty($water)){
            $water = $water . ", ";
        }
        $water = $water . "'1'";
    }
    #if no water is set defalt to all set
    if(empty($water)){
        $water = "'1', '2', '3'";
    }

    if(isset($_POST['sun3'])) {
        if(!empty($sun)){
            $sun = $sun . ", ";
        }
        $sun = $sun . "'3'";
    }
    if(isset($_POST['sun2'])) {
        if(!empty($sun)){
            $sun = $sun . ", ";
        }
        $sun =  $sun . "'2'";
    }
    if(isset($_POST['sun1'])) {
        if(!empty($sun)){
            $sun = $sun . ", ";
        }
        $sun = $sun . "'1'";
    }
    #if no sun is set defalt to all set
    if(empty($sun)){
        $sun = "'1', '2', '3'";
    }
    
    $where = "where water in (" . $water . ") and sun in (" . $sun . ") ";
    
    
    
    #orderby name
    if(!isset($_POST['orderOptions'])){
       $_POST['orderOptions'] = "aToz";
    }
    if(strcmp($_POST['orderOptions'], "aToz")){
        $orderby = " order by scientific_name desc";
    }
    else{
        $orderby = " order by scientific_name asc";
    }
    
    $sql = "select * from plant_types ". $where . $orderby . ";";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    
    $records = $stmt->fetchALL(PDO::FETCH_ASSOC);
    
    
    
    


?>


<html>
    <head>
        <title> plants </title>
    </head>
    <body>
        
        <a href="./faves.php"> Favorites</a> <br/>
        <form id="orderby" method="post">
            <input type="checkbox" name="water3" value="yes"/> high water <br/>
            <input type="checkbox" name="water2" value="yes"/> med water <br/>
            <input type="checkbox" name="water1" value="yes"/> low water <br/>
            
            <input type="checkbox" name="sun3" value="yes"/> high sun <br/>
            <input type="checkbox" name="sun2" value="yes"/> med sun <br/>
            <input type="checkbox" name="sun1" value="yes"/> low sun <br/>
            
            <input type="submit" value="Submit"/>
        </form>
        
        
        <select name="orderOptions" form="orderby">
          <option value="aToz">a-z</option>
          <option value="zToa">z-a</option>
        </select>
        
        <?php
            echo "<form id = \"fave\" method = \"post\">";
    echo "<table>";
    #table lables
    ?>
    <tr>
        <th>
            Scientific Name
        </th>
        <th>
            Water Requirement
        </th>
        <th>
            sun Requirement
        </th>
        <th>
            Edible
        </th>
        <th>
            add favorite
        </th>
    </tr>
    <?php
    #table contents
    foreach($records as $record){
        echo "<tr>";
        echo "<th>" . $record['scientific_name'] . "<th/> ";
        echo  $record['water'] . " <th/> ";
        echo  $record['sun'] . " <th/> ";
        echo  $record['edible'] . " <th/> ";

        echo "<input type=\"checkbox\" name=\"faveCheckbox[]\" value=\"" . $record['id'] . "\">";

        echo "<tr/>";
    }
    echo "<tr>";
    echo "<th> <input type=\"submit\" value=\"Submit Faves\"> <th/>";
    echo "<tr/>";
    echo "<form/>";
    
    echo "<table/>";

        ?>
        

    </body>
</html>
        
    </body>
    
</body>