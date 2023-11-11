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
if (empty($_POST['zip'])) {
	die('Zip is required');
}


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

/* password hash */
$password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

/* using database */
$mysqli = require __DIR__ . "/database.php";


 STUCK HERE 
$sql = 'INSERT INTO User_R (FirstName, LastName, Street, City, State, Zip, Phone, Email, Username, Password) 
	VALUES (?,?,?,?,?,?,?,?,?,?)';

$stmt = $mysqli->stmt_init();

If ( ! $stmt->prepare($sql)) {
	die("SQL error: " . $mysqli->error);
}

$stmt->bind_param("sss",
				$_POST['first_name'],
				$_POST['last_name'],
				$_POST['street'],
				$_POST['city'],
				$_POST['state'],
				$_POST['zip'],
				$_POST['phone'],
				$_POST['email'],
				$_POST['username'],
				$password_hash);

$stmt->execute();


echo "Signup successful"
print_r($_POST);
var_dump($password_hash);

?>