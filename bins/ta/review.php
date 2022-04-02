<html>
    <body>
        <h1>Add new review here :</h1>
        <form action = "<?php $_PHP_SELF ?>" method = "POST">
        <?php
            error_reporting(-1);
            ini_set("display_errors", "1");
            if($_GET["id"]) {
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
                echo "<b>Movie Title:</b>";
                echo "<select name='mid' id='ID'>";
                while ($row = $rs->fetch_assoc()) { 
                    echo "<option value= $mid>" . $row['title'] . " (" . $row['year'] . ")</option>";
                }
                echo "</select><br>";

                $rs->free();
                $db->close();
            }
        ?>
            <b><label for="title">Your name</label></b><br>
                <input type="text" name="name" class="form-control" value="Mr. Anonymous" id="title"><br>
            <b><label for="rating">Rating</label></b><br>
                <select  class="form-control" name="rating" id="rating">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select><br>
            <textarea class="form-control" name="comment" rows="5"  placeholder="no more than 500 characters" ></textarea><br>
            <button type="submit">Rating it!</button>
        </form>

        <?php
            $db = new mysqli('localhost', 'cs143', '', 'class_db');
            if ($db->connect_errno > 0) { 
                die('Unable to connect to database [' . $db->connect_error . ']'); 
            }
            $mid = $_GET["id"];
            $name = $db->real_escape_string($_POST["name"]);
            $rating = $_POST["rating"];
            $comment = $db->real_escape_string($_POST["comment"]);

            $query = "INSERT INTO Review (name, time, mid, rating, comment) VALUE ('$name', now(), $mid, $rating, '$comment')";
            $rs = $db->query($query);

            if(mysqli_affected_rows($db) > 0) {
                echo "<hr> Thanks for your comment! Your review has been successfully added. <a href='movie.php?id=$mid'>click this to go back to see the movie</a>";
            }

            #$rs->free();
            $db->close();
        ?>
    </body>
</html>
