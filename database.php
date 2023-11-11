<?php 

// Cloud Apps class example

/*$hostname = "eishabasit.com"; // my hostname
$username = "mahberTest"; // my DB username
$password = "R0sca"; // my DB password
$dbname = "mahberRosca"; // my DB name

$mysqli = mysqli_connect($hostname, $username, $password, $dbname);

// if it fails to connect, give me the reason why it failed to connect

if (mysqli_connect_errno()) {
	echo "Failed to connect" . mysqli_connect_error();
}
 
//if it connects to your database

if (mysqli_ping($mysqli)) {
	echo "<br>The connection to your database '". $dbname ."' is working!";
 	echo '<br>User: ' . $username;
}
 
// if it connects but something is wrong
 
else {
	echo "Error: " . mysqli_error($mysqli);
}

mysqli_close($mysqli);

*/




/* this was from following video tutorial
https://www.youtube.com/watch?v=5L9UhOnuos0&t=907s */

$host = 'eishabasit.com';
$dbname = 'mahberRosca';
$username = 'mahberTest';
$password = 'R0sca';

$mysqli = new mysqli(	hostname: $host, 
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
	echo '<br>User: '.$username;
}

else{
	echo "Error: " . mysqli_error($mysqli);
}


return $mysqli;

/* http://eishabasit.com/mahber/mahber3/signup.html */
?>