<?php
$host = getenv('IP');
$username = 'lab7_user';
$password = 'password1';
$dbname = 'world';

if($_SERVER['REQUEST_METHOD']==='GET'){
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    if(isset($_GET['country'])&& !empty($_GET['country'])===true && $_GET['context']=="undefined"){
        $country=filter_input(INPUT_GET,'country',FILTER_SANITIZE_SPECIAL_CHARS);
        $stmt = $conn-> query("SELECT * FROM countries WHERE name LIKE '%$country%'");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        LookupCountry($results);
        
    }else if (isset($_GET['country'])&& !empty($_GET['country'])===false && $_GET['context']=="undefined"){
        $stmt = $conn->query("SELECT * FROM countries");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        LookupCountry($results);
        
    }else if ($_GET['context']=="cities"&& empty($_GET['country'])===true){
        $context=filter_input(INPUT_GET,'context',FILTER_SANITIZE_SPECIAL_CHARS);
        $stmt = $conn->query("SELECT * FROM cities");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        LookupCities($results);
        
    }else {
        $stmt2=$conn->query("SELECT name,code FROM countries WHERE name LIKE '%$country%'");
       $stmt = $conn->query("SELECT cities.name,cities.district,cities.population,cities.country_code FROM cities INNER JOIN  countries  on cities.country_code=countries.code");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $results1=$stmt2->fetchAll(PDO::FETCH_ASSOC);
        CountryLookupCities($results,$results1);
    }
}


function LookupCountry ($results){?>
    <table>
        <tr>
            <th >Country Name</th>
            <th>Continent</th>
            <th>Independence Year</th>
            <th>Head of State</th>
        </tr>
    <?php foreach ($results as $row):?>
        <tr>
          <td><?= $row['name'] ;?></td>
          <td><?= $row['continent'];?></td>
          <td><?=$row['independence_year'];?></td>
           <td><?=$row['head_of_state']; ?></td>
        </tr>   
    <?php endforeach; ?>
    </table>
<?php    
}



function CountryLookupCities($results,$results1){?>
    <table>
    <tr>
        <th>Name</th>
        <th>District</th>
        <th>Population</th>
    </tr><?php
    $ArrName=array();
    $ArrCode=array();
    
    foreach($results1 as $row):
        array_push($ArrName,$row['name']);
        array_push($ArrCode,$row['code']);
    endforeach;
    
    $length=count($ArrName);

    for($i=0;$i<$length;$i++){
        foreach($results as $row): 
           if(($ArrName[$i]===$_GET['country']) &&($ArrCode[$i]===$row['country_code'])){?>
              <tr>
                <td><?=$row['name'];?></td>  
                <td><?=$row['district'];?></td>
                <td><?=$row['population'];?></td>
               </tr>
            <?php
            }//end if
        endforeach;
    }//endfor 
    ?>   
    </table>
<?php   
}



function LookupCities($results){
    ?>
    <table>
        <tr>
            <th>Name</th>
            <th>District</th>
            <th>Population</th>
        </tr>    
        <?php foreach($results as $row):?>
        <tr>
            <td><?=$row['name'];?></td>  
            <td><?=$row['district'];?></td>
            <td><?=$row['population'];?></td>
         </tr>
        <?php
    endforeach;?>
    </table>
<?php    
}
?>

