<?php

    session_start();

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
        <title>BOOTSTRAP Mahber Home</title>
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

<!-- this is where page content goes, inside MAIN -->
        <main class="flex-shrink-0">

                <?php if (isset($_SESSION['user_id'])): ?>
                    <h2 class='text-center'>You are logged in.</h2>
                    <h2 class = 'text-center'><a href ='logout.php'>Log out</a></h2>
                <?php else: ?>
                    <h2 class = 'text-center'>You are logged out, Goodbye!</h2>
                <?php endif; ?>

          <div class="container border shadow p-3 bg-light rounded mt-5 mb-5">

            <div class="px-4 py-5 my-5 text-center">

                <img class="logo" width="200" height="75" src = 'images/mahber_logo2.png'/>
                <!--<h1 class="display-5 fw-bold text-body-emphasis">Mahber ROSCA</h1>-->
                <div class="col-lg-6 mx-auto">
                    <br><p class="lead mb-4 fw-bold" style = 'color:#010c80;'>Transparency | Efficiency | Security</p>
                  <p class="lead mb-4">Mahber is the world's first all-in-one ROSCA management tool. We are dedicated to providing secure and efficient tools to quickly create and administer ROSCA group activities. Mahber promises transparency, efficiency, and security.</p>
                  <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                    <button type="button" class="btn btn-outline-secondary btn-lg px-4 gap-3"><a class="nav-link active" href="login.php">Login</a></button>
                    <button type="button" class="btn btn-primary btn-lg px-4"><a class="nav-link active" href="signup.html">Sign Up</a></button>
                  </div>
                </div>
            </div>
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

</html>