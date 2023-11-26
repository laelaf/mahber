<?php
require 'database.php';

// Assuming database structure has a table named 'ContributionInfo'
// with columns 'GroupID' and 'ContributionAmount'
if (isset($_GET['groupId'])) {
    $groupId = $_GET['groupId'];

    $sql_2 = "SELECT ContributionAmount FROM Group_R WHERE GroupID = ?";
    $stmt = $mysqli->prepare($sql_2);
    $stmt->bind_param("s", $groupId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $contributionAmount = $row['ContributionAmount'];

        // Return the contribution amount as JSON
        echo json_encode(['amount' => $contributionAmount]);
    } else {
        // Handle case when no contribution information is found
        echo json_encode(['amount' => 'Not available']);
    }

    //$stmt->close();
    //$mysqli->close();
}
?>
