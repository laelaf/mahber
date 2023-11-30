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
        <title>BOOTSTRAP Mahber Contact</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- bootstrap CSS link -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link rel = 'stylesheet' href = 'style2.css'/>
        <link rel = 'stylesheet' href = 'form.css'/>
    </head>

    <body class="d-flex flex-column h-100" style = 'background-color: #d1edf2;'>

   <!-- NAV -->
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

  <!-- CONTENT -->
<main class="flex-shrink-0">
 <div class='container border shadow bg-light mt-5 mb-5 p-5'>
  
<?php      
        
        require 'database.php';

        $cont_payment = $_POST['contribution_amt'];
        $groupId = $_POST['groupId'];
        $date = date("Y-m-d");
        //echo $date;

        function generatePaymentId() {
             //Choose a random letter for the first character
            $firstChar = "C";
            
             //Generate 5 random numbers for the remaining characters
            $numbersPart = rand(10000, 99999);
            
            // Combine the letter and numbers to form the 6-character user ID
            $paymentId = $firstChar . $numbersPart;
            
            return $paymentId;
        }

        $paymentID = generatePaymentId();
        $contributionID = $paymentID;

        echo '<h1 class="text-center">Payment Confirmation</h1>';
        echo '<div class="container mt-4 p-3">
                <table class="table">
                    <tr>
                        <th>Payment ID</th>
                        <th>User ID</th>
                        <th>Group ID</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </tr>
                    <tr>
                        <td>' . $contributionID . '</td>
                        <td>' . $_SESSION['UserID'] . '</td>
                        <td>' . $groupId . '</td>
                        <td>' . $cont_payment . '</td>
                        <td>' . $date . '</td>
                    </tr>
                </table>
            </div>';

        /* using database*/ 
        
        require 'database.php';
        
        mysqli_select_db ( $mysqli , $dbname);
        //-----------------------

        $userId = $_SESSION['UserID']; // Replace with the actual user ID
        $currentMonthYear = date("Y-m");


        // Check if the user has already made a contribution in the current month to the specified group
        /*$sql = "SELECT COUNT(*) as contributionCount FROM Contribution_R WHERE UserID = '$userId' AND GroupID = '$groupId' AND ContributionDate='$currentMonthYear'";
        mysqli_query($mysqli, $sql);
echo $currentMonthYear;

        if ($contributionCount >= 1) {

            echo 'ERROR: You have already made a payment this month!';

        }else if ($contributionCount == 0){*/
            $sql = "SELECT HasPaid FROM GroupRoster_R
            WHERE UserID='$userId'";

            $result = $mysqli->query($sql);

            $paidStatus = $result->fetch_assoc();
            print_r($paidStatus);
            echo $paidStatus['HasPaid'];
           
           /*$sql_1 = "UPDATE Group_R set  
                    GroupFund = (GroupFund + $cont_payment)
                    WHERE GroupID = '$groupId'";

            mysqli_query($mysqli, $sql_1);
            echo "wrote to Group_R";

            $sql_2 = "INSERT INTO Contribution_R set   
                PaymentID = '$contributionID',
                GroupID = '$groupId',
                UserID = '$_SESSION[UserID]',
                PaymentAmount = '$cont_payment',
                ContributionDate = '$date'";
                            
            mysqli_query($mysqli, $sql_2);

            echo "wrote to contribution!!";*/
            
        /*}else{
            echo 'Error: Action could not be completed';
        }*/
        
?>
        <div class="container my-4 text-center">
            <a href="dashboard.php" class="btn btn-primary mx-2">Return to Dashboard</a>
        </div>
    </div>
    <div style="margin-bottom: 200px;">
        <!-- footer spacing-->
    </div>
</main>

 <!-- FOOTER -->
        <footer class = 'footer py-3 fixed-bottom mt-auto bg-light'>
            <div class = 'container-fluid'>
                <span class = 'text-muted'>
                    <ul class="nav justify-content-center border-bottom pb-3 mb-3">
                        <li class="nav-item"><a href = 'index.html' class="nav-link px-2 text-muted">Home</a></li>
                        <li class="nav-item"><a href = 'about.html' class="nav-link px-2 text-muted">About</a></li>
                        <li class="nav-item"><a href = 'contact.html' class="nav-link px-2 text-muted">Contact</a></li>
                        <li class="nav-item"><a href='faq.php' class="nav-link px-2 text-muted">FAQ</a></li>
                    </ul>
                    <p class='text-center text-muted'>&copy; 2023 Mahber</p>
                </span>
            </div>
        </footer>

<!-- bootstrap JS link -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    </body>
</html>