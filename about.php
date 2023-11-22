<!doctype html>
<?php

    session_start();

?>
<!-- Authors:
    Saly Camara
    Eisha Basit
    Prudhvi Raju
    Laelaf Mengistiessssss-->
<html lang='en'>
<head>                     
    <meta charset="utf-8">
    <title>Mahber About</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel='stylesheet' href='style2.css'/>
</head>

<body class="d-flex flex-column h-100" style='background-color: #d1edf2;'>

<!-- NAV -->
<nav class="navbar navbar-expand-lg bg-light">
    <div class="container">
        <a class="navbar-brand" href="index.php"><img class="logo" width="150" height="55" src='images/mahber_logo2.png'></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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

<!-- CONTENT -->
<!-- About Mahber Section -->
<main class="flex-shrink-0">
                
    <div class="container mt-5 mb-5">
        <h1 class="text-center">About Mahber</h1>
        <div class="container border shadow p-3 bg-light rounded mt-5 mb-5">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <h3>History</h3>
                    <p>Mahber was founded in 2023 with the vision to revolutionize the traditional ROSCA model through technology. Our founders, coming from diverse backgrounds, saw the potential to empower communities by providing a reliable and transparent platform for financial collaboration.</p>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h3>Vision</h3>
                    <p>Our vision is to become the world's leading digital ROSCA platform, enabling people to access community-based savings and lending services that are secure, user-friendly, and accessible to all.</p>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h3>Mission</h3>
                    <p>Our mission is to provide an innovative and trustworthy ROSCA service that fosters financial inclusion, builds trust within communities, and promotes a culture of mutual support and economic growth.</p>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h3>Values</h3>
                    <p>At Mahber, we uphold values such as integrity, community empowerment, innovation, and excellence. We believe in the strength of community finance and are committed to delivering exceptional service to our members.</p>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Our Founders Section -->
<div class="container mt-5">
    <h3 class="mb-3 text-center">Our Founders</h3>
    <div class="row text-center">
        <!-- Co-founder 1 -->
        <div class="col-lg-3 col-sm-6 mb-4 p-2 border shadow rounded">
            <div class="card h-100">
                <img src="images/Placeholder.png" class="card-img-top" alt="Co-founder 1">
                <div class="card-body">
                    <h5 class="card-title">Eisha Basit</h5>
                    <p class="card-text">CEO</p>
                </div>
            </div>
        </div>
        <!-- Co-founder 2 -->
        <div class="col-lg-3 col-sm-6 mb-4 p-2 border shadow rounded">
            <div class="card h-100">
                <img src="images/Placeholder.png" class="card-img-top" alt="Co-founder 2">
                <div class="card-body">
                    <h5 class="card-title">Saly Camara</h5>
                    <p class="card-text">CTO</p>
                </div>
            </div>
        </div>
        <!-- Co-founder 3 -->
        <div class="col-lg-3 col-sm-6 mb-4 p-2 border shadow rounded">
            <div class="card h-100">
                <img src="images/Placeholder.png" class="card-img-top" alt="Co-founder 3">
                <div class="card-body">
                    <h5 class="card-title">Prudhvi Raju</h5>
                    <p class="card-text">CFO</p>
                </div>
            </div>
        </div>
        <!-- Co-founder 4 -->
        <div class="col-lg-3 col-sm-6 mb-4 p-2 border shadow rounded">
            <div class="card h-100">
                <img src="images/Placeholder.png" class="card-img-top" alt="Co-founder 4">
                <div class="card-body">
                    <h5 class="card-title">Laelaf Mengistie</h5>
                    <p class="card-text">COO</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FOOTER -->
<footer class='footer py-3 mt-auto bg-light'>
    <div class='container-fluid'>
        <span class='text-muted'>
            <ul class="nav justify-content-center border-bottom pb-3 mb-3">
                <li class="nav-item"><a href='index.php' class="nav-link px-2 text-muted">Home</a></li>
                <li class="nav-item"><a href='about.php' class="nav-link px-2 text-muted">About</a></li>
                <li class="nav-item"><a href='contact.php' class="nav-link px-2 text-muted">Contact</a></li>
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
