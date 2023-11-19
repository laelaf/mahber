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
                                <button type = 'button' class='btn btn-outline-info px-3 py-1 m-1'>
                                    
                                    <img src = 'images/Placeholder.png' style="width: 50px;height: 50px;"/>
                                    <?php 
                                        echo $_SESSION['Username'];
                                    ?>                 
                                </button>
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
        
        <div class = 'container border shadow bg-light mt-5 mb-5 p-5'>
            <h2 class='text-center'>Create New Group</h2>
             <form action='#' method='post' class='create-group-form'> 
                    
                        <p>
                            <label>Group Name: </label> 
                            <input type = 'text' name = 'groupName' id='groupName' placeholder="Enter Group Name" class='form-control'/>
                            <!--Group name is different from group ID which must be generated automatically!!!!-->
                        </p>
                        <p>
                            <label>Number of Users: </label>
                            <select name = 'numUsers' id=numUsers placeholder="#" size = '1'required class='form-control'/>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                                <option>6</option>
                                <option>7</option>
                                <option>8</option>
                                <option>9</option>
                                <option>10</option>
                            </select>
                            <small>*minimum 3, maximum 10</small>
                        </p>
                        <p>
                            <label>Number of Cycles:</label>
                                                    
                            <select type='text' name = 'numCycles' id = 'numCycles' placeholder="#" required class='form-control'/>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                                <option>6</option>
                                <option>7</option>
                                <option>8</option>
                                <option>9</option>
                                <option>10</option>
                            </select>
                            <small>*numCycles must be the same as number of users</small>

                        </p>
                        <p>
                            <label>Contribution Amount</label>
                            <input type = 'text' name = 'contribution_amt' id = 'contribution_amt' placeholder = 'Contribution Amount' class='form-control'/>
                            
                        </p>
                        <p>
                            <label>Total Pool Amount: </label>
                            <input type = 'text' name = 'totalPool' id = 'totalPool' placeholder = 'Final Pool Amount' class='form-control' readonly/>
                            <small>*this is a calculated field, numUsers*contributionAmount (cannot type here)</small>
                        </p>
                        
                                        
                    <br/>
                    <button type="submit" class="btn btn-primary text-center">Create Group</button>
                </form><br>

                <!--Notes:-->
                
        </div>
    </main>

 <!-- FOOTER -->
        <footer class = 'footer py-3 mt-auto bg-light'>
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