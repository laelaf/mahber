<!doctype html>
<?php

    session_start();

?>
<!-- Authors:
    Saly Camara
    Eisha Basit
    Prudhvi Raju
    Laelaf Mengistie-->
<html lang='en'>
    <head>
        <meta charset="utf-8">
        <title>Process-Group</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- bootstrap CSS link -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link rel = 'stylesheet' href = 'style2.css'/>
    </head>

    <body class="d-flex flex-column h-100" style = 'background-color: #d1edf2;'>
<!-- #7EF9FF  or #E5F3FD for a very muted color, #D1EDF2, #29C5F6,  #77d4fc mahber color-->
        <nav class="navbar navbar-expand-lg bg-light">
            <div class="container">
                <a class="navbar-brand" href="index.php">                <img class="logo" width="150" height="55" src = 'images/mahber_logo2.png'></img></a>
                <button class="navbar-toggler " type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item navlink">
                                <a class="nav-link" aria-current="page" href="index.php">Home</a>
                            </li>
                            <li class="nav-item navlink">
                                <a class="nav-link" href="about.php">About</a>
                            </li>
                            <li class="nav-item navlink">
                                <a class="nav-link" href="contact.php">Contact</a>
                            </li>
                            <li class="nav-item">
                                <?php if (isset($_SESSION['UserID'])): ?>
                                <a href='dashboard.php'>
                                    <button type = 'button' class='btn btn-outline-info px-3 py-1 m-1'>
                                        <img src = 'images/Placeholder.png' style="width: 50px;height: 50px;"/>
                                        <?php 
                                            echo $_SESSION['Username'];
                                        ?>                 
                                    </button>
                                 </a>
                            </li>
                            <li class="nav-item">
                                <button type = 'button' class='btn btn-outline-info px-3 py-3 m-1'>
                                    <a href ='logout.php'>Log out</a>                          
                                </button>
                                <?php else: ?>
                                    <button type='button' class='btn btn-outline-info p-1 m-1'>
                                     <a class="nav-link active" href="login.php">Login</a>
                                    </button>
                                    <button type='button' class='btn btn-outline-info py-1 m-1'>
                                    <a class="nav-link active" href="signup.html">Sign Up</a>
                                </button>
                                <?php endif; ?>
                            </li>
                        </ul>
                    </div>
            </div>
        </nav>
		
	<main class="flex-shrink-0">
        <div class="container border shadow p-3 bg-light rounded mt-5 mb-5">


		<?php

		/* create group id */

		function generateGroupId() {
		     //Choose a random letter for the first character
		    $firstChar = "G";
		    
		     //Generate 5 random numbers for the remaining characters
		    $numbersPart = rand(10000, 99999);
		    
		    // Combine the letter and numbers to form the 6-character user ID
		    $GroupId = $firstChar . $numbersPart;
		    
		    return $GroupId;
		}

		$GroupID = generateGroupId();
		$_SESSION['GroupID'] = $GroupID;

		function generateAdminId() {
		     //Choose a random letter for the first character
		    $firstChar = "A";
		    
		     //Generate 5 random numbers for the remaining characters
		    $numbersPart = rand(10000, 99999);
		    
		    // Combine the letter and numbers to form the 6-character user ID
		    $AdminId = $firstChar . $numbersPart;
		    
		    return $AdminId;
		}

		$AdminID = generateAdminId();
		$_SESSION['AdminID'] = $AdminID;
		print_r($_SESSION);
		//echo $AdminID;
		/*end create admin id*/

		/* using database*/ 
		
		require 'database.php';
		
		mysqli_select_db ( $mysqli , $dbname);

		$sql_1 = "INSERT INTO GroupAdmin_R set 	
		AdminID = '$_SESSION[AdminID]',
		UserID = '$_SESSION[UserID]'";


		$sql_2 = "INSERT INTO Group_R set 	
			GroupID = '$_SESSION[GroupID]',
			AdminID = '$_SESSION[AdminID]',
			GroupName = '$_POST[groupName]',
			NumUsers = '$_POST[numUsers]',
			NumEnrolled = '1',
			NumRounds = '$_POST[numCycles]',
			CyclePoolAmount = '$_POST[totalPool]',
			ContributionAmount = '$_POST[contribution_amt]'";

		$sql_3 = "INSERT INTO GroupRoster_R set 	
			GroupID = '$_SESSION[GroupID]',
			UserID = '$_SESSION[UserID]'";
						

		mysqli_query($mysqli, $sql_1);
		mysqli_query($mysqli, $sql_2);
		mysqli_query($mysqli, $sql_3);

		header("Location: group-created.php");

		

		?>
		</div>
		<div style="margin-bottom: 200px;">
		    <!-- footer spacing-->
		</div>
	</main>
	<footer class = 'footer py-3 mt-auto fixed-bottom bg-light'>
            <div class = 'container-fluid'>
                <span class = 'text-muted'>
                    <ul class="nav justify-content-center border-bottom pb-3 mb-3">
                        <li class="nav-item"><a href = 'index.php' class="nav-link px-2 text-muted">Home</a></li>
                        <li class="nav-item"><a href = 'about.php' class="nav-link px-2 text-muted">About</a></li>
                        <li class="nav-item"><a href = 'contact.php' class="nav-link px-2 text-muted">Contact</a></li>
                        <li class="nav-item"><a href='faq.php' class="nav-link px-2 text-muted">FAQ</a></li>
                    </ul>
                    <p class='text-center text-muted'>&copy; 2023 Mahber</p>
                </span>
            </div>
        </footer>

        <!-- bootstrap JS link -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    </body>