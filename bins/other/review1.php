<html>
<body>


<h1>Review Page</h1>
<?php
if ($_GET["id"]) {

    $input = $_GET["id"];
    $db = new mysqli('localhost', 'cs143', '', 'class_db');
    if ($db->connect_errno > 0) {
        die('Unable to connect to database [' . $db->connect_error . ']');
    }

    $query1 = "SELECT * FROM Movie WHERE id = '$input'";

    $rs1 = $db->query($query1);
    print "Add new review here!<br><br>";
    while ($row = $rs1->fetch_assoc()) {
        $title = $row['title'];
        print "Movie Title:   $title<br><br>";
    }
}
?>


<form action="<?php $_PHP_SELF ?>" method="GET">

    Your Name:<br>
    <input type="text" name="name" />
    <br><br>Rating:<br>
    <select name="rating">
        <option value=5>5 - Excellent</option>
        <option value=4>4 - Pretty good</option>
        <option value=3>3 - Decent</option>
        <option value=2>2 - Poor</option>
        <option value=1>1 - Terrible</option>
    </select>


    <br><br>
    Your comment:<br>
    <textarea name="cmmt" cols="60" rows="8" maxlength="500"></textarea> 
    <br/>
    <input type="hidden" name="clicked" value="1" />
    <br/>
    <input type="submit" value="Add Review!"/> 

</form>


<?php

if ($_GET["id"]) {

    $tempname = $_GET['name'];
    if ($tempname == "") {
        $tempname = "Anonymous";
    }

    $tempcomment = $_GET["cmmt"];
    $id = $_GET["mid"];
    $rate = $_GET["rating"];
    #$time = time();
    #$mysqldate = date('Y-m-d H:i:s', $time);
    #$date = date("Y-m-d", $time);

    $time = date('Y-m-d H:i:s');

    $db = new mysqli('localhost', 'cs143', '', 'class_db');
    if ($db->connect_errno > 0) {
        die('Unable to connect to database [' . $db->connect_error . ']');
    }


    $query = "INSERT INTO Review (name, mid, rating, comment) SELECT * 
    FROM (SELECT '$name', $movie, '$rating', '$comment') AS tmp 
    WHERE NOT EXISTS (SELECT name, mid, rating, comment 
    FROM Review WHERE  name = '$name' AND mid = $movie AND rating = '$rating' AND comment = '$comment') LIMIT 1;";
    // $query = "INSERT INTO Review VALUES
    // ('$tempname', '$time', $id, $rate, '$tempcomment')";
    $rs2 = $db->query($query);

    while ($rs2) { 
        echo "<b>Successful add! Thank you $tempname! </b>";}
}

exit();
?>

</body>

</html>