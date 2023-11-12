<!doctype html>
<!-- Authors:
    Saly Camara
    Eisha Basit
    Prudhvi Raju
    Laelaf Mengistie-->
<html lang='en'>
    <head>
        <meta charset="utf-8">
        <title>Mahber signed up</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- bootstrap CSS link -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link rel = 'stylesheet' href = 'style2.css'/>
    </head>

    <body class="d-flex flex-column h-100" style = 'background-color: #d1edf2;'>
<!-- #7EF9FF  or #E5F3FD for a very muted color, #D1EDF2, #29C5F6,  #77d4fc mahber color-->
        <nav class="navbar navbar-expand-lg bg-light">
            <div class="container">
                <a class="navbar-brand" href="index.html">                <img class="logo" width="150" height="55" src = 'images/mahber_logo2.png'></img></a>
                <button class="navbar-toggler " type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item navlink">
                                <a class="nav-link" aria-current="page" href="index.html">Home</a>
                            </li>
                            <li class="nav-item navlink">
                                <a class="nav-link" href="about.html">About</a>
                            </li>
                            <li class="nav-item navlink">
                                <a class="nav-link" href="contact.html">Contact</a>
                            </li>
                            <li class="nav-item">
                                <button type = 'button' class='btn btn-outline-info p-1 m-1'>
                                    <a class="nav-link active" href="login.php">Login</a>
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type = 'button' class='btn btn-outline-info py-1 m-1'>
                                    <a class="nav-link active" href="signup.html">Sign Up</a>
                                </button>
                            </li>
                        </ul>
                    </div>
            </div>
        </nav>
		
	<main class="flex-shrink-0">
        <div class="container border shadow p-3 bg-light rounded mt-5 mb-5">


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
		if (empty($_POST['zip_code'])) {
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
		//echo $userID;
		/*end create user id*/

		//print_r($_POST);		------> hide this
		//var_dump($password_hash);

		/* using database*/ 
		
		require 'database.php';
		
		mysqli_select_db ( $mysqli , $dbname);

		$sql = "INSERT INTO User_R set 	UserID = '$userID',
										FirstName = '$_POST[first_name]',
										LastName = '$_POST[last_name]',
										Street = '$_POST[street]',
										City = '$_POST[city]',
										State = '$_POST[state]',
										Zip = '$_POST[zip_code]',
										Phone = '$_POST[phone]',
										Email = '$_POST[email]',
										Username = '$_POST[username]',
										Password = '$_POST[password]'";

		mysqli_query($mysqli, $sql);

		header("Location: signup-success.html");

		//Close connection
		//mysqli_close($mysqli);

		/*					THIS WAS MY ATTEMPT TO PREVENT SQL INJECTION, BUT THIS DIDN'T WORK
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
						$_POST['zip_code'],
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
		*/

		?>
		</div>
	</main>
	<footer class = 'footer py-3 mt-auto fixed-bottom bg-light'>
            <div class = 'container-fluid'>
                <span class = 'text-muted'>
                    <ul class="nav justify-content-center border-bottom pb-3 mb-3">
                        <li class="nav-item"><a href = 'index.html' class="nav-link px-2 text-muted">Home</a></li>
                        <li class="nav-item"><a href = 'about.html' class="nav-link px-2 text-muted">About</a></li>
                        <li class="nav-item"><a href = 'contact.html' class="nav-link px-2 text-muted">Contact</a></li>
                        <li class="nav-item"><a href = 'login.php' class="nav-link px-2 text-muted">Login</a></li>
                        <li class="nav-item"><a href = 'signup.html' class="nav-link px-2 text-muted">Sign Up</a></li>
                    </ul>
                    <p class='text-center text-muted'>&copy; 2023 Mahber</p>
                </span>
            </div>
        </footer>

        <!-- bootstrap JS link -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    </body>