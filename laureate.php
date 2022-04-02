<?php
// get the id parameter from the request
$id = intval($_GET['id']);

// set the Content-Type header to JSON, 

function change_key($array, $old_key, $new_key) {
    if( ! array_key_exists( $old_key, $array ) )
        return $array;

    $keys = array_keys( $array );
    $keys[ array_search( $old_key, $keys ) ] = $new_key;

    return array_combine( $keys, $array );
}
// so that the client knows that we are returning JSON data
header('Content-Type: application/json');
$db = new mysqli('localhost', 'cs143', '', 'class_db');
if ($db->connect_errno > 0) { 
    die('Unable to connect to database [' . $db->connect_error . ']'); 
}
$LaureateQuery="SELECT id, givenorgName, familyName, gender, birthfoundedDate as date, 
city, country FROM Laureates WHERE id=".$id.";";
$LaureateRs = mysqli_query($db, $LaureateQuery);

$output = array();
while ($row = mysqli_fetch_assoc($LaureateRs)) { 
    $isPerson = 1;
    if (empty($row['gender'])) {
        $isPerson = 0;
    }
    
    $place = array();
    if (!empty($row['city'])) {
        $place['city'] = array('en' => $row['city']);
    }
    if (!empty($row['country'])) {
        $place['country'] = array('en' => $row['country']);
    }

    $middle = array();
    if (!empty($row['date'])){
        $middle['date'] = $row['date'];
    }
    if (!empty($place)){
        $middle['place'] = $place;
    }


    unset($row['date']);
    unset($row['city']);
    unset($row['country']);
    
    if ($isPerson == 1) {
        $row = change_key($row, 'givenorgName', 'givenName');
        $row['givenName'] = array('en' => $row['givenName']);

        if (!empty($row['familyName']))
            $row['familyName'] = array('en' => $row['familyName']);

        if (!empty($middle))
            $row['birth'] = $middle;

    }
    else {
        $row = change_key($row, 'givenorgName', 'orgName');
        $row['orgName'] = array('en' => $row['orgName']);
        $row['founded'] = $middle;
    }

    foreach($row as $key=>$value) {
        if (empty($row[$key]))
            unset($row[$key]);
    }    

    $output = $row;
    
}

$NobelPrizesQuery = "SELECT id, awardYear, category, sortOrder, FLAGN FROM NobelPrizes where id=".$id.";";
$NobelPrizesRs = mysqli_query($db, $NobelPrizesQuery);
$nobelPrizes = array();

while ($row = mysqli_fetch_assoc($NobelPrizesRs)) { 
    unset($row['id']);
    if (!empty($row['awardYear']))
        $row['awardYear'] = ($row['awardYear']);
    if (!empty($row['category']))
        $row['category'] = array('en' => $row['category']);
    if (!empty($row['sortOrder']))
        $row['sortOrder'] = $row['sortOrder'];

    $affiliations = array();
    $affiliationsQuery = "SELECT name, city, country FROM Affiliations WHERE FLAGN=".$row['FLAGN'].";";

    $affiliationsRs = mysqli_query($db, $affiliationsQuery);

    while ($r = mysqli_fetch_assoc($affiliationsRs)) {
        $affiliationALL = array();
        if (!empty($r['name'])) {
            $affiliationALL['name'] = array('en' => $r['name']);
        }
        if (!empty($r['city'])) {
            $affiliationALL['city'] = array('en' => $r['city']);
        }
        if (!empty($r['country'])) {
            $affiliationALL['country'] = array('en' => $r['country']);
        }
        $affiliations[] = $affiliationALL;
    }
    
    unset($row['FLAGN']);
    if (!empty($affiliations))
        $row['affiliations'] = $affiliations;
    

    foreach($row as $key=>$value) {
        if (empty($row[$key]))
            unset($row[$key]);
    }
    $nobelPrizes[] = $row;
}

$output['nobelPrizes'] = $nobelPrizes;
echo json_encode($output, JSON_PRETTY_PRINT);

?>
