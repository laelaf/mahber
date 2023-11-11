<?php

/*Personal Info Validation*/
if (empty($_POST['first_name'])) {
	die('First Name is required');
}
if (empty($_POST['last_name'])) {
	die('Last Name is required');
}
if (empty($_POST['dob'])) {
	die('Date of Birth is required');
}
if (empty($_POST['phone'])) {
	die('Phone Number is required');
}
if ( ! filter_var($_POST['email'], 	FILTER_VALIDATE_EMAIL)) {
	die('Valid email is required');
}
if($_POST['email'] !== $_POST['confirm_email']) {
	die("Emails must match");
}


/* Address Validation */
if (empty($_POST['street'])) {
	die('Street is required');
}
if (empty($_POST['city'])) {
	die('City is required');
}
if (empty($_POST['state'])) {
	die('State is required');
}
/*if (empty($_POST['zip'])) {
	die('Zip is required');
}*/


/*Username Password Validation
	still need to require upper And lowercase, and 1 special character*/
if (empty($_POST['username'])) {
	die('username is required');
}
if (strlen($_POST['password']) < 8) {
	die('Password must be at least 8 characters');
}
if ( ! preg_match("/[a-z]/i", $_POST['password'])) {
	die("Password must contain at least one letter");
}
if ( ! preg_match("/[0-9]/", $_POST['password'])) {
	die("Password must contain at least one number");
}
if($_POST['password'] !== $_POST['confirm_password']) {
	die("Passwords must match");
}

/* password hash not used yet*/
//$password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);


/* create user id */

function generateUserId() {
     //Choose a random letter for the first character
    $firstChar = "U";
    
     //Generate 5 random numbers for the remaining characters
    $numbersPart = rand(10000, 99999);
    
    // Combine the letter and numbers to form the 6-character user ID
    $userId = $firstChar . $numbersPart;
    
    return $userId;
}

$userID = generateUserId();
echo $userID;
/*end create user id*/

print_r($_POST);
//var_dump($password_hash);

/* using database*/ 
$mysqli = require __DIR__ . "/database.php";

$sql = "INSERT INTO User_R (UserID, FirstName, LastName, Street, City, State, Zip, Phone, Email, Username, Password) VALUES (?,?,?,?,?,?,?,?,?,?,?)";

$stmt = $mysqli->stmt_init();

If ( ! $stmt->prepare($sql)) {
	die("SQL error: " . $mysqli->error);
}

$stmt->bind_param("sssssssssss",
				$userID,
				$_POST['first_name'],
				$_POST['last_name'],
				$_POST['street'],
				$_POST['city'],
				$_POST['state'],
				$_POST['zip'],
				$_POST['phone'],
				$_POST['email'],
				$_POST['username'],
				$_POST['password']);

if ($stmt->execute()) {
    echo "Signup successful";
} else {
    die($mysqli->error . " " . $mysqli->errno);
}


$stmt->close();
$mysqli->close();

?>