<!doctype html>
<?php
session_start();

$messageSent = false;
$errorMsg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phoneNumber'] ?? ''; // Optional
    $messageContent = $_POST['message'];

    // Email Content
    $to = "eishabasit2@gmail.com"; // Replace with your email address / please use an email address that belongs to your domain 
    $subject = "New Contact Message from " . $firstName . " " . $lastName;
    $message = "Name: " . $firstName . " " . $lastName . "\r\n" .
               "Email: " . $email . "\r\n" .
               "Phone: " . $phoneNumber . "\r\n" .
               "Message: " . $messageContent;
    $headers = "From: no-reply@yourdomain.com"; // Use an email from your domain

}
    
?>
<!-- Authors:
    Saly Camara
    Eisha Basit
    Prudhvi Raju
    Laelaf Mengistie-->
<html lang='en'>
     <head>                     
        <meta charset="utf-8">
        <title>Mahber Contact</title>
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
  

  <div class="container border shadow bg-light mt-5 mb-5 p-5">
    <h2 class='text-center'>Contact Us</h2>

    <form class = 'contact-form-signin' action='' method='post'>

        <div class="row mb-3">
            <div class="col">
                <label for="firstName" class="form-label">First Name</label>
                <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First Name" required>
            </div>
            <div class="col">
                <label for="lastName" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last Name" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email"  placeholder="Your Email" required>
            </div>
            <div class="col-md-6">
                <label for="phoneNumber" class="form-label">Phone Number</label>

                <input type="tel" class="form-control" id="phoneNumber" name = "phoneNumber" placeholder="Phone Number (Optional)">

            </div>
        </div>
        <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea class="form-control" id="message" rows="3" name="message" placeholder="Your Message" required></textarea>
        </div>
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary mx-auto">Submit</button>
        </div>
    </form>
<?php
    if (mail($to, $subject, $message, $headers)) {
        $messageSent = true;
        echo 'Message Sent!';
    } else {
        $errorMsg = "Error: Unable to send message.";
    }
?>
</div>

 <!-- FOOTER -->
        <footer class = 'footer py-3 fixed-bottom mt-auto bg-light'>
            <div class = 'container-fluid'>
                <span class = 'text-muted'>
                    <ul class="nav justify-content-center border-bottom pb-3 mb-3">
                        <li class="nav-item"><a href = 'index.php' class="nav-link px-2 text-muted">Home</a></li>
                        <li class="nav-item"><a href = 'about.php' class="nav-link px-2 text-muted">About</a></li>
                        <li class="nav-item"><a href = 'contact.php' class="nav-link px-2 text-muted">Contact</a></li>
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