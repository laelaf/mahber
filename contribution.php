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
        <title>Make Contribution</title>
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
 <div class='container border shadow bg-light mt-5 mb-5 p-5'>
        <h1 class = 'text-center'>Make Contribution Payment</h1><br>
        <form action='#' method='get' class='contact-form-signin'>
            <fieldset>
                <p>
                    <label for='groupId'>Group ID: </label>
                    <?php 
                        require 'database.php';
        
                        mysqli_select_db ( $mysqli , $dbname);

                        $sql = sprintf("SELECT * FROM GroupRoster_R 
                            WHERE UserID = '%s'", $_SESSION["UserID"]);

                        $result = $mysqli->query($sql);
                        //print_r($result);

                        //echo '<br><br>';

                        $groups = $result->fetch_all(MYSQLI_ASSOC);
                        //print_r($groupData);

                     ?>
                    <select id='groupId' name='groupId'required class="form-control">
                        <option>Click to Select GroupID</option>
                        <?php 
                            foreach ($groups as $group){
                                echo "<option value='{$group['GroupID']}'>{$group['GroupID']}</option>";
                            }
                        ?>
                    </select>
                </p>
                <p>
                    <label for='contribution_amt'>Contribution Amount</label>

                    <input type='text' id='contribution_amt' name='contribution_amt' required class="form-control" readonly />
                </p>
                
            </fieldset>
            <p class = 'text-center'>
                <button type="submit" class="btn btn-primary">Submit</button>
            </p>
        </form>
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

        <script>
    document.addEventListener("DOMContentLoaded", function () {
        var groupIdSelect = document.getElementById('groupId');
        var contributionAmtInput = document.getElementById('contribution_amt');

        groupIdSelect.addEventListener('change', function () {
            // Get the selected Group ID
            var selectedGroupId = groupIdSelect.value;

            // Make an AJAX request to fetch contribution information
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'get_contribution_info.php?groupId=' + selectedGroupId, true);

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Parse the JSON response
                    var contributionInfo = JSON.parse(xhr.responseText);

                    // Set the Contribution Amount input value
                    contributionAmtInput.value = contributionInfo.amount;
                }
            };

            xhr.send();
        });
    });
</script>

    </body>
</html>