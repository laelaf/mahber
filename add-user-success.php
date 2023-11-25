<?php

session_start();


require 'database.php';

            $sql = sprintf("SELECT * FROM User_R 
                            WHERE UserID = '%s'", $_POST["add_user_id"]);

            $result = $mysqli->query($sql);

            $userData = $result->fetch_assoc();

            //var_dump($userData);
            //exit;

           $sql_2 = "INSERT INTO GroupRoster_R set  
            GroupID = '$groupId',
            UserID = $_POST["add_user_id"]";

            mysqli_query($mysqli, $sql_2);

            echo "You have added User ID: " . $_POST["add_user_id"] . "!";

            echo "<a href = 'view_group.php'>View Group</a>";

?>
