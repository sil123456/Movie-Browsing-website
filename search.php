<html>
    <body>
        <h1>Searching Page :</h1>
        <hr>
        <form action = "<?php $_PHP_SELF ?>" method = "GET">
            <h4>Actor name:</h4>
            <input type = "text" name = "actor"><br>
            <input type = "submit" value = "Search Actor!"><br>
        </form>
        <form action = "<?php $_PHP_SELF ?>" method = "GET">
            <h4>Movie title:</h4>
            <input type = "text" name = "movie"><br>
            <input type = "submit" value = "Search Movie!"><br>
        </form>
        <?php
            if($_GET["actor"]) {
                $db = new mysqli('localhost', 'cs143', '', 'class_db');
                if ($db->connect_errno > 0) { 
                    die('Unable to connect to database [' . $db->connect_error . ']'); 
                }

                $key = $db->real_escape_string($_GET["actor"]);
                $key = explode(' ', $key);

                $query = "SELECT * FROM Actor WHERE (first LIKE LOWER('%$key[0]%') OR last LIKE LOWER('%$key[0]%'))";
                for($i=1; $i<count($key); $i++) {
                    $query = $query . "AND (first LIKE LOWER('%$key[$i]%') OR last LIKE LOWER('%$key[$i]%'))";
                }
                $rs = $db->query($query);
                if(!$rs) {
                    $errmsg = $db->error;
                    print "Query falied: $errmsg <br>";
                    exit(1);
                }
                
                echo "<h4>matching Actors are:</h4>";
                echo "<div class='table-responsive'>";
                echo "<table class='table table-bordered table-condensed table-hover'>";
                echo "<thead> <tr><td>Name</td><td>Date of Birth</td></tr></thead>";
                echo "<tbody>";
                while ($row = $rs->fetch_assoc()) {
                    $aid = $row['id'];
                    $name = $row['first'] . " " . $row['last'];
                    $dob = $row['dob'];
                    echo "<tr><td><a href='actor.php?id=$aid'>$name</a></td><td><a href='actor.php?id=$aid'>$dob</a></td></tr>";
                }
                echo "</tbody>";
                echo "</table>";
                echo "</div>";
                
                $rs->free();
                $db->close();
            }
            else if($_GET["movie"]){
                $db = new mysqli('localhost', 'cs143', '', 'class_db');
                if ($db->connect_errno > 0) { 
                    die('Unable to connect to database [' . $db->connect_error . ']'); 
                }

                $key = $db->real_escape_string($_GET["movie"]);
                $key = explode(' ', $key);

                $query = "SELECT * FROM Movie WHERE title LIKE '%$key[0]%'";
                for($i=1; $i<count($key); $i++) {
                    $query = $query . "AND (title LIKE '%$key[$i]%')";
                }
                $rs = $db->query($query);
                if(!$rs) {
                    $errmsg = $db->error;
                    print "Query falied: $errmsg <br>";
                    exit(1);
                }
                
                echo "<h4>matching Movies are:</h4>";
                echo "<div class='table-responsive'>";
                echo "<table class='table table-bordered table-condensed table-hover'>";
                echo "<thead> <tr><td>Title</td><td>Year</td></tr></thead>";
                echo "<tbody>";
                while ($row = $rs->fetch_assoc()) {
                    $mid = $row['id'];
                    $title = $row['title'];
                    $year = $row['year'];
                    echo "<tr><td><a href='movie.php?id=$mid'>$title</a></td><td><a href='movie.php?id=$mid'>$year</a></td></tr>";
                }
                echo "</tbody>";
                echo "</table>";
                echo "</div>";

                $rs->free();
                $db->close();
            }
            else exit();
            
        ?>
        </hr>
    </body>
</html>
