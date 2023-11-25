<!DOCTYPE html>
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
    <title>BOOTSTRAP Mahber Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel='stylesheet' href='style2.css' />
</head>

<body class="d-flex flex-column h-100" style='background-color: #d1edf2;'>
    <!-- #7EF9FF or #E5F3FD for a very muted color, #D1EDF2, #29C5F6, #77d4fc mahber color-->
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container">
            <a class="navbar-brand" href="index.html"> <img class="logo" width="150" height="55" src='images/mahber_logo2.png'></img></a>
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

    <!-- this is where page content goes, inside MAIN -->
    <main class="flex-shrink-0">
        <div class="container border shadow p-3 bg-light rounded mt-5 mb-5">
                    <!-- Invite ROSCA Members Form -->
                    <form id="inviteForm" class="mt-5">
                     <h3 class="mb-4">Invite ROSCA Members</h3>
                    <div class="mb-3">
                    <label for="inviteeEmail" class="form-label">Invitee's Email:</label>
                    <input type="email" class="form-control" id="inviteeEmail" name="inviteeEmail" required pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$">
                   <div class="invalid-feedback">
                   Please enter a valid email address.
                 </div>
    </div>
    <div class="mb-3">
        <label for="invitationMessage" class="form-label">Invitation Message:</label>
        <textarea class="form-control" id="invitationMessage" name="invitationMessage" rows="4" required></textarea>
    </div>
    <button type="submit" class="btn btn-success">Send Invitation</button>
</form>
                </div>
            </div>
        </div>
    </main>

     <!-- FOOTER -->
        <footer class = 'd-flex justify-content mb-0 py-5 border-top bg-light fixed-bottom'>

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
