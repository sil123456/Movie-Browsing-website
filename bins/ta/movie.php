<html>
    <body>
        <h1>Movie information Page :</h1>
        <form action = "<?php $_PHP_SELF ?>" method = "GET">
        </form>
        <?php
            if(!$_GET["id"]) exit();
            $db = new mysqli('localhost', 'cs143', '', 'class_db');
            if ($db->connect_errno > 0) { 
                die('Unable to connect to database [' . $db->connect_error . ']'); 
            }
            
            $mid = $_GET["id"];
            $query = "SELECT * FROM Movie WHERE id = $mid";
            $rs = $db->query($query);
            if(!$rs) {
                $errmsg = $db->error;
                print "Query falied: $errmsg <br>";
                exit(1);
            }
            echo "<hr>";
            echo "<h4>Movie Information is:</h4>";
            echo "<div class='table-responsive'>";
            echo "<table class='table table-bordered table-condensed table-hover'>";
            echo "<tbody>";
            while ($row = $rs->fetch_assoc()) { 
                $title = $row['title']; 
                $year = $row['year']; 
                $mpaa = $row['rating']; 
                $company = $row['company']; 
                echo "<tr><td>Title :</td><td>$title($year)</td></tr>";
                echo "<tr><td>Producer: </td><td>$company</td></tr>";
                echo "<tr><td>MPAA Rating :</td><td>$mpaa</td></tr>";
                echo "<tr><td>Genre :</td><td>";
                $query = "SELECT * FROM MovieGenre WHERE mid = $mid";
                $rs2 = $db->query($query);
                if(!$rs2) {
                    $errmsg = $db->error;
                    print "Query falied: $errmsg <br>";
                    exit(1);
                }
                while ($row2 = $rs2->fetch_assoc()) {
                    $genre = $row2["genre"];
                    echo " $genre ";
                }
            }
            echo "</td></tr>";
            echo "</tbody>";
            echo "</table>";
            echo "</div>";
            echo "</hr>";

            echo "<hr>";
            echo "<h4>Actors in this Movie:</h4>";
            $query = "SELECT * FROM MovieActor, Actor WHERE mid = $mid AND MovieActor.aid = Actor.id";
            $rs = $db->query($query);
            if(!$rs) {
                $errmsg = $db->error;
                print "Query falied: $errmsg <br>";
                exit(1);
            }
            echo "<div class='table-responsive'>";
            echo "<table class='table table-bordered table-condensed table-hover'>";
            echo "<thead><td>Name</td><td>Role</td></thead>";
            echo "<tbody>";
            while ($row = $rs->fetch_assoc()) {
                $name = $row['first'] . " " . $row['last'];
                $role = $row['role'];
                $aid = $row['aid'];
                echo "<tr><td><a href='actor.php?id=$aid'>$name</a></td><td>\"$role\"</td></tr>";
            }
            echo "</tbody>";
            echo "</table>";
            echo "</div>";
            echo "</hr>";

            echo "<hr>";
            echo "<h4>User Review:</h4>";
            $query = "SELECT *FROM Review where mid = $mid";
            $rs = $db->query($query);
            if(!$rs) {
                $errmsg = $db->error;
                print "Query falied: $errmsg <br>";
                exit(1);
            }
            if($rs->num_rows == 0) {
                echo "<a href='review.php?id=$mid'>By now, nobody ever rates this movie. Be the first one to give a review</a>";
            }
            else {
                while ($row = $rs->fetch_assoc()) {
                    $num = $rs->num_rows;
                    $rating += $row['rating'];
                }
                $avgrating = round($rating/$num, 4);
                echo "Average score for this Movie is $avgrating based on $rs->num_rows people's reviews<br>";
                echo "<a href='review.php?id=$mid'>Leave your review as well!</a>";
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


            $rs->free();
            $rs2->free();
            $db->close();
        ?>
    </body>
</html>
