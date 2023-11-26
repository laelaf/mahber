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
 <div class='container border shadow bg-light mt-5 mb-5 p-5'>
  
<?php      
        
        require 'database.php';

            $sql = sprintf("SELECT * FROM GroupRoster_R 
                            WHERE GroupID = '%s'", $_POST["groupId"]);

            $result = $mysqli->query($sql);

            $groupData = $result->fetch_assoc();
                //var_dump($groupData);
                //exit;

            if ($groupData) {
                
                $sql_2 = sprintf("SELECT NumUsers, NumEnrolled FROM Group_R 
                            WHERE GroupID = '%s'", $_POST["groupId"]);
                $result2 = $mysqli->query($sql_2);
                $enrolled = $result2->fetch_assoc();
                //var_dump($enrolled);

                if ($enrolled['NumEnrolled'] == $enrolled['NumUsers']){
                    echo '<p class = "text-center">Group ' . $_POST["groupId"] . ' is full!</p>';
                    echo "<p class = 'text-center'>Return to <a href='dashboard.php'>User Dashboard</a>.</p>";
                }else{
                    $sql_3 = "INSERT INTO GroupRoster_R set  
                    GroupID = '$_POST[groupId]',
                    UserID = '$_SESSION[UserID]'";

                    mysqli_query($mysqli, $sql_3);

                    $sql_4 = "UPDATE Group_R set  
                    NumEnrolled = NumEnrolled + 1
                    WHERE GroupID = '$_POST[groupId]'";

                    mysqli_query($mysqli, $sql_4);

                    echo "<p class = 'text-center'>You have joined Group ID: " . $_POST['groupId'] . "!</p>";
                    echo "<p class = 'text-center'>Return to <a href='dashboard.php'>User Dashboard</a>.</p>";
                }

            }else{
                echo '<p class = "text-center">Group ID not found!</p>';
                echo "<p class = 'text-center'>Return to <a href='dashboard.php'>User Dashboard</a>.</p>";
           
            }


?>
    </div>

 <!-- FOOTER -->
        <footer class = 'footer py-3 fixed-bottom mt-auto bg-light'>
            <div class = 'container-fluid'>
                <span class = 'text-muted'>
                    <ul class="nav justify-content-center border-bottom pb-3 mb-3">
                        <li class="nav-item"><a href = 'index.html' class="nav-link px-2 text-muted">Home</a></li>
                        <li class="nav-item"><a href = 'about.html' class="nav-link px-2 text-muted">About</a></li>
                        <li class="nav-item"><a href = 'contact.html' class="nav-link px-2 text-muted">Contact</a></li>
                        <li class="nav-item"><a href='faq.html' class="nav-link px-2 text-muted">FAQ</a></li>
                    </ul>
                    <p class='text-center text-muted'>&copy; 2023 Mahber</p>
                </span>
            </div>
        </footer>

<!-- bootstrap JS link -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    </body>
</html>