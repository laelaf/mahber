<?php

$is_invalid = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST'){

require 'database.php';

    $sql = sprintf("SELECT * FROM User_R 
                    WHERE Username = '%s'", $_POST["Username"]);

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();

    //var_dump($user);
    //exit;

    if ($user) {

        if ($_POST['Password'] == $user['Password']) {
            
            session_start();
            session_regenerate_id();
            $_SESSION['UserID'] = $user['UserID'];
            $_SESSION['Username'] = $_POST['Username'];

            header("Location: create_group.php");
            exit;
            
        }
    }

$is_invalid = true;

}

?>

<!doctype html>
<!-- Authors:
    Saly Camara
    Eisha Basit
    Prudhvi Raju
    Laelaf Mengistie-->
<html lang='en'>
     <head>                     
        <meta charset="utf-8">
        <title>BOOTSTRAP Mahber Login</title>
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

  <!-- CONTENT -->
            <div class = 'container border shadow p-3 bg-light rounded mt-5 mb-5'>
            <?php if ($is_invalid): ?>
                <em>Invalid Login</em>
            <?php endif; ?>
               <form class="form-signin text-center" method='POST'>
                  <img class="logo" width="200" height="200" src = 'images/mahber_logo.png'></img>
                  <h1 class="h3 mb-3 font-weight-normal">Sign in</h1>
                  <fieldset>
                      <label for="username" class="form-label sr-only visually-hidden">Username</label>
                      <input type="username" id='Username' name="Username" class="form-control" placeholder="Username" required autofocus>
                      <label for="password" class="form-label sr-only visually-hidden">Password</label>
                      <input type="password" id='Password' name="Password" class="form-control" placeholder="Password" required><br>
                      <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
                  </fieldset>
                </form>
            </div>

 <!-- FOOTER -->
        <footer class = 'footer py-3 mt-auto fixed-bottom bg-light'>
            <div class = 'container-fluid'>
                <span class = 'text-muted'>
                    <ul class="nav justify-content-center border-bottom pb-3 mb-3">
                        <li class="nav-item"><a href = 'index.php' class="nav-link px-2 text-muted">Home</a></li>
                        <li class="nav-item"><a href = 'about.php' class="nav-link px-2 text-muted">About</a></li>
                        <li class="nav-item"><a href = 'contact.php' class="nav-link px-2 text-muted">Contact</a></li>
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
</html>