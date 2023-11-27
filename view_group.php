<?php
session_start();
require 'database.php';

if (!isset($_GET['group_id'])) {
    echo "No group selected.";
    exit();
}

$groupId = $_GET['group_id'];

// Query for Payout and Contribution Details
$groupDetailsStmt = $mysqli->prepare("
    SELECT 
        u.UserID, u.FirstName, u.LastName, u.Email, u.Phone, 
        gr.PayoutOrder, 
        c.PaymentAmount, c.ContributionDate, 
        p.PayoutAmount, p.PayoutDate
    FROM 
        GroupRoster_R gr
    JOIN User_R u ON gr.UserID = u.UserID
    LEFT JOIN Contribution_R c ON gr.GroupID = c.GroupID AND gr.UserID = c.UserID
    LEFT JOIN Payout_R p ON gr.GroupID = p.GroupID AND gr.UserID = p.UserID
    WHERE 
        gr.GroupID = ?
    ORDER BY 
        gr.PayoutOrder, u.UserID, c.ContributionDate, p.PayoutDate
");
$groupDetailsStmt->bind_param("s", $groupId);
$groupDetailsStmt->execute();
$result = $groupDetailsStmt->get_result();
$groupDetails = $result->fetch_all(MYSQLI_ASSOC);

// Check if payout order is already set
$payoutOrderCheckStmt = $mysqli->prepare("SELECT COUNT(*) as count FROM GroupRoster_R WHERE GroupID = ? AND PayoutOrder IS NOT NULL");
$payoutOrderCheckStmt->bind_param("s", $groupId);
$payoutOrderCheckStmt->execute();
$payoutOrderCheckResult = $payoutOrderCheckStmt->get_result()->fetch_assoc();

$payoutOrderSet = $payoutOrderCheckResult['count'] > 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'set_random_order') {
    // Logic for random payout order setting
    $membersStmt = $mysqli->prepare("SELECT UserID FROM GroupRoster_R WHERE GroupID = ?");
    $membersStmt->bind_param("s", $groupId);
    $membersStmt->execute();
    $members = $membersStmt->get_result()->fetch_all(MYSQLI_ASSOC);

    $orders = range(1, count($members));
    shuffle($orders);

    foreach ($members as $index => $member) {
        $updateStmt = $mysqli->prepare("UPDATE GroupRoster_R SET PayoutOrder = ? WHERE GroupID = ? AND UserID = ?");
        $updateStmt->bind_param("iss", $orders[$index], $groupId, $member['UserID']);
        $updateStmt->execute();
    }

    // Refresh group details after updating payout order
    $groupDetailsStmt->execute();
    $result = $groupDetailsStmt->get_result();
    $groupDetails = $result->fetch_all(MYSQLI_ASSOC);
}
?>

<!doctype html>
<html lang='en'>
    <head>                     
        <meta charset="utf-8">
        <title>View Group - <?php echo htmlspecialchars($groupName); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- bootstrap CSS link -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link rel = 'stylesheet' href = 'style2.css'/>
        <link rel = 'stylesheet' href = 'form.css'/>
    </head>
    <body class="d-flex flex-column h-100" style='background-color: #d1edf2;'>

        <!-- Navbar here -->
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
                                

    <div class="container mt-3">
            <h2 class="text-center">Group Details: <?php echo htmlspecialchars($groupName); ?> (<?php echo htmlspecialchars($groupId); ?>)</h2>

            <!-- Section for setting payout order -->
            <div class="payout-order-setting">
                <h3>Set Payout Order</h3>
                <div style="display: flex;">
                    <form action="view_group.php?group_id=<?php echo htmlspecialchars($groupId); ?>" method="post" style="margin-right: 10px;">
                        <input type="hidden" name="action" value="set_random_order">
                        <button type="submit" class="btn btn-primary">Set Randomly</button>
                    </form>
                    <a href="set_payout_order.php?group_id=<?php echo htmlspecialchars($groupId); ?>&method=manual" class="btn btn-secondary">Set Manually</a>
                </div>
            </div>

            <!-- Payout details section -->
            <!-- Payout Details Table -->
    <div class="container border shadow bg-light mt-5 mb-5 p-5">
        <div class="row">
            <div class="col">
                <h2 class='text-center'>Payout Details for Group: <?php echo htmlspecialchars($groupId); ?></h2>
                <table class="table table-responsive table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>User ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Total Payouts</th>
                            <th>Latest Payout Date</th>
                            <th>Payout Order</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($groupDetails as $detail): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($detail['UserID']); ?></td>
                            <td><?php echo htmlspecialchars($detail['FirstName'] . ' ' . $detail['LastName']); ?></td>
                            <td><?php echo htmlspecialchars($detail['Email']); ?></td>
                            <td><?php echo htmlspecialchars($detail['Phone']); ?></td>
                            <td><?php echo htmlspecialchars(number_format($detail['PayoutAmount'], 2)); ?></td>
                            <td><?php echo htmlspecialchars($detail['PayoutDate'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($detail['PayoutOrder'] ?? 'N/A'); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="container my-4 text-center">
                    <a href="dashboard.php" class="btn btn-primary mx-2">Return to Dashboard</a>
                </div>
            </div>
        </div>
    </div>


    <div class="container border shadow bg-light mt-5 mb-5 p-5">
            <!-- Contribution details section -->
            <h3 class="mt-4 text-center">Contribution Details</h3>
            <table class="table table-responsive table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>User ID</th>
                        <th>Name</th>
                        <th>Payment Amount</th>
                        <th>Contribution Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($groupDetails as $detail): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($detail['UserID']); ?></td>
                            <td><?php echo htmlspecialchars($detail['FirstName'] . ' ' . $detail['LastName']); ?></td>
                            <td><?php echo htmlspecialchars($detail['PaymentAmount'] ? number_format($detail['PaymentAmount'], 2) : 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($detail['ContributionDate'] ?? 'N/A'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="container my-4 text-center">
                <a href="dashboard.php" class="btn btn-primary mx-2">Return to Dashboard</a>
            </div>
    </div>
</div>

        <!-- Footer content -->
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

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    </body>
</html>