<?php 
session_start();
require 'database.php';

if (!isset($_SESSION['UserID'])) {
    header('Location: login.php');
    exit();
}

ini_set('display_errors', 1);
error_reporting(E_ALL);
$userId = $_SESSION['UserID'];

// Fetch user's group memberships with GroupName
$memberGroupsStmt = $mysqli->prepare("SELECT gr.GroupID, g.GroupName FROM GroupRoster_R gr JOIN Group_R g ON gr.GroupID = g.GroupID WHERE gr.UserID = ?");
$memberGroupsStmt->bind_param("s", $userId);
$memberGroupsStmt->execute();
$memberGroups = $memberGroupsStmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Fetch AdminID(s) for the user
$adminIdsStmt = $mysqli->prepare("SELECT AdminID FROM GroupAdmin_R WHERE UserID = ?");
$adminIdsStmt->bind_param("s", $userId);
$adminIdsStmt->execute();
$adminIdsResult = $adminIdsStmt->get_result();
$adminIds = $adminIdsResult->fetch_all(MYSQLI_ASSOC);

// Initialize an array to hold GroupIDs and GroupNames where the user is an admin
$adminGroupIDs = [];

// Fetch GroupIDs and GroupNames for each AdminID
foreach ($adminIds as $adminId) {
    $groupIdsStmt = $mysqli->prepare("SELECT GroupID, GroupName FROM Group_R WHERE AdminID = ?");
    $groupIdsStmt->bind_param("s", $adminId['AdminID']);
    $groupIdsStmt->execute();
    $groupIdsResult = $groupIdsStmt->get_result();
    while ($group = $groupIdsResult->fetch_assoc()) {
        $adminGroupIDs[] = $group;
    }
}


// Fetch the total amount contributed by the user for each group
$totalContributionsStmt = $mysqli->prepare("
    SELECT GroupID, SUM(PaymentAmount) AS TotalContribution 
    FROM Contribution_R 
    WHERE UserID = ? 
    GROUP BY GroupID
");
$totalContributionsStmt->bind_param("s", $userId);
$totalContributionsStmt->execute();
$totalContributions = $totalContributionsStmt->get_result()->fetch_all(MYSQLI_ASSOC);


// Fetch the total amount received by the user from each group
$totalPayoutsStmt = $mysqli->prepare("
    SELECT GroupID, SUM(PayoutAmount) AS TotalPayout 
    FROM Payout_R 
    WHERE UserID = ? 
    GROUP BY GroupID
");
$totalPayoutsStmt->bind_param("s", $userId);
$totalPayoutsStmt->execute();
$totalPayouts = $totalPayoutsStmt->get_result()->fetch_all(MYSQLI_ASSOC);


// Fetch specific payments made by the user
$specificPaymentsStmt = $mysqli->prepare("
    SELECT GroupID, PaymentAmount, ContributionDate 
    FROM Contribution_R 
    WHERE UserID = ?
");
$specificPaymentsStmt->bind_param("s", $userId);
$specificPaymentsStmt->execute();
$specificPayments = $specificPaymentsStmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Fetch specific payouts received by the user
$specificPayoutsStmt = $mysqli->prepare("
    SELECT GroupID, PayoutAmount, PayoutDate 
    FROM Payout_R 
    WHERE UserID = ?
");
$specificPayoutsStmt->bind_param("s", $userId);
$specificPayoutsStmt->execute();
$specificPayouts = $specificPayoutsStmt->get_result()->fetch_all(MYSQLI_ASSOC);


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
        <title>Mahber Report</title>
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

<div class="container border shadow p-3 bg-light rounded mt-5 mb-5">
        <h1 class="text-center">User Report</h1><br>

        <div class="row">
            <div class="col-md-6">
                <h2 class='text-center'>Groups Membership</h2>
                <ul class="list-group">
                    <?php foreach ($memberGroups as $group): ?>
                        <li class="list-group-item">
                            <?php echo htmlspecialchars($group['GroupID']) . " - " . htmlspecialchars($group['GroupName']); ?>
                        </li>
                    <?php endforeach; ?>
                    <?php if (empty($memberGroups)): ?>
                        <p>No group memberships.</p>
                    <?php endif; ?>
                </ul>
            </div>

            <div class="col-md-6">
                <h2 class='text-center'>Groups Administered</h2>
                <ul class="list-group">
                    <?php foreach ($adminGroupIDs as $group): ?>
                        <li class="list-group-item">
                            <?php echo htmlspecialchars($group['GroupID']) . " - " . htmlspecialchars($group['GroupName']); ?>
                        </li>
                    <?php endforeach; ?>
                    <?php if (empty($adminGroupIDs)): ?>
                        <p>No administered groups.</p>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <h2 class='text-center'>Total Contributions Made</h2>
                <ul class="list-group">
                    <?php foreach ($totalContributions as $contribution): ?>
                        <li class="list-group-item">
                            Group ID: <?php echo htmlspecialchars($contribution['GroupID']); ?> - 
                            Total Contribution: <?php echo htmlspecialchars(number_format((float)$contribution['TotalContribution'], 0)); ?>
                        </li>
                    <?php endforeach; ?>
                    <?php if (empty($totalContributions)): ?>
                        <p>No contributions have been made.</p>
                    <?php endif; ?>
                </ul>
            </div>

            <div class="col-md-6">
                <h2 class='text-center'>Total Payouts Received</h2>
                <ul class="list-group">
                    <?php foreach ($totalPayouts as $payout): ?>
                        <li class="list-group-item">
                            Group ID: <?php echo htmlspecialchars($payout['GroupID']); ?> - 
                            Total Payout: <?php echo htmlspecialchars(number_format((float)$payout['TotalPayout'], 0)); ?>
                        </li>
                    <?php endforeach; ?>
                    <?php if (empty($totalPayouts)): ?>
                        <p>No payouts have been received.</p>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <h2 class='text-center'>Contribution List</h2>
                <ul class="list-group">
                    <?php foreach ($specificPayments as $payment): ?>
                        <li class="list-group-item">
                            Group ID: <?php echo htmlspecialchars($payment['GroupID']); ?> - 
                            Payment: <?php echo htmlspecialchars(number_format((float)$payment['PaymentAmount'], 0)); ?> on 
                            <?php echo htmlspecialchars($payment['ContributionDate']); ?>
                        </li>
                    <?php endforeach; ?>
                    <?php if (empty($specificPayments)): ?>
                        <p>No specific payments have been made.</p>
                    <?php endif; ?>
                </ul>
            </div>

            <div class="col-md-6">
                <h2 class='text-center'>Payouts Received</h2>
                <ul class="list-group">
                    <?php foreach ($specificPayouts as $payout): ?>
                        <li class="list-group-item">
                            Group ID: <?php echo htmlspecialchars($payout['GroupID']); ?> - 
                            Payout: <?php echo htmlspecialchars(number_format((float)$payout['PayoutAmount'], 0)); ?> on 
                            <?php echo htmlspecialchars($payout['PayoutDate']); ?>
                        </li>
                    <?php endforeach; ?>
                    <?php if (empty($specificPayouts)): ?>
                        <p>No specific payouts have been received.</p>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <div class="container my-4 text-center">
            <a href="dashboard.php" class="btn btn-primary mx-2">Return to Dashboard</a>
        </div>
    </div>


    <footer class = 'footer py-3 mt-auto bg-light'>
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


