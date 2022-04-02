<html>
    <body>
        <h1>Actor information Page :</h1>
        <form action = "<?php $_PHP_SELF ?>" method = "GET">
        </form>
        <?php
            if(!$_GET["id"]) exit();
            $db = new mysqli('localhost', 'cs143', '', 'class_db');
            if ($db->connect_errno > 0) { 
                die('Unable to connect to database [' . $db->connect_error . ']'); 
            }
            
            $aid = $_GET["id"];
            $query = "SELECT * FROM Actor WHERE id = $aid";
            $rs = $db->query($query);
            if(!$rs) {
                $errmsg = $db->error;
                print "Query falied: $errmsg <br>";
                exit(1);
            }
            echo "<hr>";
            echo "<h4>Actor Information is:</h4>";
            echo "<div class='table-responsive'>";
            echo "<table class='table table-bordered table-condensed table-hover'>";
            echo "<thead><tr><td>Name</td><td>Sex</td><td>Date of Birth</td><td>Date of Death</td></tr></thead>";
            echo "<tbody>";
            while ($row = $rs->fetch_assoc()) { 
                $name = $row['first'] . " " . $row['last'];
                $sex = $row['sex']; 
                $dob = $row['dob']; 
                if(is_null($row['dod'])) {
                    $dod = "Still Alive";
                }
                else {
                    $dod = $row['dod'];
                }
                echo "<tr><td>$name</td><td>$sex</td><td>$dob</td><td>$dod</td></tr>";
            }
            echo "</tbody>";
            echo "</table>";
            echo "</div>";
            echo "</hr>";

            $query = "SELECT * FROM MovieActor WHERE aid = $aid";
            $rs = $db->query($query);
            if(!$rs) {
                $errmsg = $db->error;
                print "Query falied: $errmsg <br>";
                exit(1);
            }
            echo "<hr>";
            echo "<h4>Actor's Movies and Role:</h4>";
            echo "<div class='table-responsive'>";
            echo "<table class='table table-bordered table-condensed table-hover'>";
            echo "<thead><tr><td>Role</td><td>Movie Title</td></tr></thead>";
            echo "<tbody>";
            while ($row = $rs->fetch_assoc()) { 
                $mid = $row['mid']; 
                $role = $row['role'];
                $query = "SELECT * FROM Movie WHERE id = $mid;";
                $rs2 = $db->query($query);
                if(!$rs2) {
                    $errmsg = $db->error;
                    print "Query falied: $errmsg <br>";
                    exit(1);
                }
                while($row2 = $rs2->fetch_assoc()){
                    $title = $row2['title'];
                    echo "<tr><td>\"$role\"</td><td><a href='movie.php?id=$mid'>$title</a></td></tr>";
                }
            }
            echo "</tbody>";
            echo "</table>";
            echo "</div>";
            echo "</hr>";

            $rs->free();
            $rs2->free();
            $db->close();
        ?>
    </body>
</html>
