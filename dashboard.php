<?php 
session_start();
if (!isset($_SESSION['UserID'])) {
    header('Location: login.php');
    exit();
}
require 'database.php';


$userId = $_SESSION['UserID'];
$stmt = $mysqli->prepare("SELECT * FROM User_R WHERE UserID = ?");
$stmt->bind_param("s", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();


// Query to find groups where the user is an admin
$adminGroupsStmt = $mysqli->prepare("SELECT g.GroupID, g.GroupName FROM GroupAdmin_R ga JOIN Group_R g ON ga.AdminID = g.AdminID WHERE ga.UserID = ?");
$adminGroupsStmt->bind_param("s", $userId);
$adminGroupsStmt->execute();
$adminGroupsResult = $adminGroupsStmt->get_result();
$adminGroups = $adminGroupsResult->fetch_all(MYSQLI_ASSOC);

$groupStmt = $mysqli->prepare("SELECT g.GroupID, g.GroupName, c.PaymentAmount, c.ContributionDate FROM GroupRoster_R gr JOIN Group_R g ON gr.GroupID = g.GroupID LEFT JOIN Contribution_R c ON g.GroupID = c.GroupID AND c.UserID = ? WHERE gr.UserID = ?");
$groupStmt->bind_param("ss", $userId, $userId);
$groupStmt->execute();
$groups = $groupStmt->get_result()->fetch_all(MYSQLI_ASSOC);



function getPaymentStatus($paymentDate) {
    $currentDate = new DateTime();
    $paymentDateTime = new DateTime($paymentDate);

    if ($paymentDateTime < $currentDate) {
        return 'Payment Made';
    } else {
        return 'Payment Due';
    }
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
        <title>Mahber Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- bootstrap CSS link -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link rel = 'stylesheet' href = 'style2.css'/>
        <link rel = 'stylesheet' href = 'form.css'/>
        
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

   

<!-- Content  -->

<main class="flex-shrink-0">
    <div class="container border shadow p-3 bg-light rounded mt-5 mb-5">
        <h1 class='text-center'>Welcome, <?php echo htmlspecialchars($user['FirstName']); ?>!</h1>
   
    <div class="container mt-4">
        <h2>MyAdmin</h2>
        <div>
            <?php foreach ($adminGroups as $group): ?>
                <div class="card my-2">
                    <div class="card-body"style="display: inline-block; padding: 10px; box-shadow: 0 2px 4px rgba(0,0,0,.2);">
                        <?php echo htmlspecialchars($group['GroupName']); ?>
                        <!-- Link to view group details -->
                        <a href="view_group.php?group_id=<?php echo htmlspecialchars($group['GroupID']); ?>" class="btn btn-sm btn-primary float-end">Manage Groups</a>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if (empty($adminGroups)): ?>
                <p>You are not an admin of any group.</p>
            <?php endif; ?>
        </div>
    </div>



    <div class="container mt-4">
        <div class="row">
            <div class="col">
                <h2>My Groups and Payments</h2>
                <table class="table table-responsive table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>Group ID</th>
                            <th>Group Name</th>
                            <th>Payment Amount</th>
                            <th>Payment Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($groups as $group): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($group['GroupID']); ?></td>
                            <td><?php echo htmlspecialchars($group['GroupName']); ?></td>
                            <td><?php echo htmlspecialchars(number_format((float)$group['PaymentAmount'], 0, '.', '')); ?></td>
                            <td><?php echo htmlspecialchars($group['ContributionDate'] ?? 'N/A'); ?></td>
                            <td><?php echo getPaymentStatus($group['ContributionDate'] ?? 'N/A'); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <!-- Action Buttons -->
    <div class="container my-4 text-center">
        <a href="create_group.php" class="btn btn-primary mx-2">Create Rosca Group</a>
        <a href="#" class="btn btn-secondary mx-2">Join Rosca Group</a>
        <a href="report.php" class="btn btn-success mx-2">View Report</a>
        <a href="#" class="btn btn-success mx-2">Make Contribution</a>
    </div>
</div>
</main>








<!-- content end -->
<footer class = 'footer fixed-bottom py-3 mt-auto bg-light'>
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

