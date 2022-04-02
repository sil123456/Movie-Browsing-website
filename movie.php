
<?php
    if($_GET["id"]){

		echo "The id is ". $_GET['id']."<br /><br>";

		$input = $_GET["id"];
		$db = new mysqli('localhost', 'cs143', '', 'class_db');
		if ($db->connect_errno > 0) { 
    		die('Unable to connect to database [' . $db->connect_error . ']'); 
		}


		$query1 = "SELECT * FROM Movie WHERE id = '$input'";
        $query2 = "SELECT * FROM Actor A, MovieActor MA
		WHERE MA.mid = '$input' AND MA.aid = A.id ORDER BY first, last";
        $avg_ = "SELECT AVG(rating) as avg FROM Review WHERE mid = '$input' GROUP BY mid";
		$query3 = "SELECT * FROM Review WHERE mid = '$input'";

        $rs1 = $db->query($query1);
        $rs2 = $db->query($query2);
        $rs3 = $db->query($avg_);
        $rs4 = $db->query($query3);
        
        while ($row = $rs1->fetch_assoc()) { 
            $title = $row['title']; 
            print "Movie name:   $title<br><br>"; 

		}

        while ($row = $rs3->fetch_assoc()) { 
            $rating = $row['avg']; 
            if ($rating > 0)
                print "Average Rating Score:   $rating<br><br>"; 
            else print "no rating!<br><br>";
		}

        print "Actor(s): <br>";
        while ($row = $rs2->fetch_assoc()) { 
            $id =  $row['id'];
            $first = $row['first'];
            $last = $row['last'];
            echo "<a href = './actor.php?id=$id'>";
            print "$first $last</a><br>"; 
        }

        // print "<br>User Review: <br>";
        // echo "<a href = './review.php?id=$input'>";
        // print "Leave your review as well</a><br>";

        // print "<br>All the comments: <br><br>";
        // while ($row = $rs4->fetch_assoc()) { 
        //     $comment = $row['comment']; 
        //     print "$comment<br><br>";
		// }




        echo "<h4>User Review:</h4>";
            $query = "SELECT *FROM Review where mid = $input";
            $rs = $db->query($query);
            if(!$rs) {
                $errmsg = $db->error;
                print "Query falied: $errmsg <br>";
                exit(1);
            }
            if($rs->num_rows == 0) {
                echo "<a href='review.php?id=$input'>By now, nobody ever rates this movie. Be the first one to give a review</a>";
            }
            else {
                while ($row = $rs->fetch_assoc()) {
                    $num = $rs->num_rows;
                    $rating += $row['rating'];
                }
                $avgrating = round($rating/$num, 4);
                echo "Average score for this Movie is $avgrating based on $rs->num_rows people's reviews<br>";
                echo "<a href='review.php?id=$input'>Leave your review as well!</a>";
                echo "</hr>";
    
                echo "<hr>";
                echo "<h4>Comment detials shown below:</h4>";
                
                $rs->free();
                $rs = $db->query($query);
                if(!$rs) {
                    $errmsg = $db->error;
                    print "Query falied: $errmsg <br>";
                    exit(1);
                }
                while ($row = $rs->fetch_assoc()) {
                    $name = $row['name'];
                    $time = $row['time'];
                    $score = $row['rating'];
                    $comment = $row['comment'];
                    echo "<font color='red'><b>$name</b></font>";
                    echo " rates this movie with score ";
                    echo "<font color='blue'><b>$score</b></font>";
                    echo " and left a review at $time<br>";
                    echo "comment:<br> $comment<br>";
                }
                echo "</hr>";
            }

		exit();
	}
?>
	
<html>
    <body>

		<form action = "<?php $_PHP_SELF ?>" method = "GET">
		<h1>Search Movie by ID</h1>
		id: <input type="text" name="id"/>
		<input type="submit"/>
	</form>
	</body>
</html>

