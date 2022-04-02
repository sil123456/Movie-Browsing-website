
<?php
    if($_GET["id"]){

		echo "The id is ". $_GET['id']."<br /><br>";

		$input = $_GET["id"];
		$db = new mysqli('localhost', 'cs143', '', 'class_db');
		if ($db->connect_errno > 0) { 
    		die('Unable to connect to database [' . $db->connect_error . ']'); 
		}

		$query1 = "SELECT * FROM Actor WHERE id = '$input'";
		$query2 = "SELECT * FROM MovieActor MA, Movie M 
		WHERE MA.aid = '$input' AND MA.mid = M.id ORDER BY year DESC";
		
		$rs1 = $db->query($query1);
		$rs2 = $db->query($query2);

		while ($row = $rs1->fetch_assoc()) { 
			$first = $row['first'];
			$last = $row['last'];
			print "Actor name:   $first $last<br><br>"; 
		}
		print "Movie(s): <br>";
		while ($row = $rs2->fetch_assoc()) { 
    		$title = $row['title'];
			$id =  $row['id'];

			print "<a href = './movie.php?id=$id'>";
			print "$title<br>"; 
		}
		print('</a>');
		exit();
	}
?>
	
<html>
    <body>

		<form action = "<?php $_PHP_SELF ?>" method = "GET">
		<h1>Search Actor by ID</h1>
		id: <input type="text" name="id"/>
		<input type="submit"/>
	</form>
	</body>
</html>
