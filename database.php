<?php 
/* Authors:
    Saly Camara
    Eisha Basit
    Prudhvi Raju
    Laelaf Mengistie*/


$host = 'eishabasit.com';
        $dbname = 'mahberRosca';
        $username = 'mahberTest';
        $password = 'R0sca';

        $mysqli = new mysqli(   hostname: $host, 
                                username: $username,
                                password: $password,
                                database: $dbname );

        // fails to connect, give reason

        if ($mysqli->connect_errno) {
            die ("Connection error: " . $mysqli->connect_error);
        }
        // if it connects to the database
        if (mysqli_ping($mysqli)) {
            echo "<br><br>The connection to your database '".$dbname ."' is working!";
            //echo '<br>User: '.$username;
        }
        else{
            echo "Error: " . mysqli_error($mysqli);
        }
return $mysqli;

/* http://eishabasit.com/mahber/mahber3/signup.html */
?>