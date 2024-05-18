<?php
// Start session
session_start();

// Include the config file
require_once '../php/config.php';

// Check if user is logged in
if (!isset($_SESSION["leader_id"]) || empty($_SESSION["leader_id"]) || $_SESSION["role"] != "leader") {
    // Redirect to the login page if not logged in
    header("Location: ../login/login.php");
    exit; // Stop further script execution
}

$leader_id = $_SESSION["leader_id"];

// Prepare your SQL query
$sql = "SELECT 
            a.assistant_id,
            a.assistant_fullName,
            o.objection_id,
            o.objection_reason,
            o.objection_month,
            o.objection_status
        FROM 
            assistant a
        JOIN 
            team_leader tl ON a.team_ID = tl.team_ID
        JOIN 
            objection o ON a.assistant_id = o.assistant_id
        WHERE 
            tl.leader_id = ?";

// Prepare the SQL statement
$stmt = mysqli_prepare($db, $sql);

if ($stmt === false) {
    echo "<p>SQL preparation error: " . mysqli_error($db) . "</p>";
    exit; // Stop further script execution
}

// Bind the parameter
mysqli_stmt_bind_param($stmt, "i", $leader_id);

// Execute the statement
mysqli_stmt_execute($stmt);

// Get the result
$result = mysqli_stmt_get_result($stmt);

if ($result === false) {
    echo "<p>SQL execution error: " . mysqli_stmt_error($stmt) . "</p>";
    exit; // Stop further script execution
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Objections List</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="teamLeaderScreen.css">
</head>
<body>

<nav class="navbar bg-dark text-white">
    <div class="container-fluid">
        <span class="navbar-brand mb-0 h1">
            <?php
            // Display user email
            echo $_SESSION["email"];
            ?>
        </span>
        <span><a class="btn btn-primary" href="../login/logout.php">Logout</a></span>
    </div>
</nav>

<div class="container">
    <h1 class="mt-4 mb-5 text-center">Employee Objections List</h1>
    <div class="objections">
        <!-- Objection items will be dynamically added here -->
        <?php
        // Check if there are any objection items
        if (mysqli_num_rows($result) > 0) {
            // Loop through each objection item
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row['objection_status'] == "pending") {
                    // Display the objection item
                    echo '<div class="objection-item mb-1 mt-5">';
                    echo '<p class="objection-subject">' . $row['objection_reason'] . '</p>';
                    echo '<p class="employee-id" style="display: none;">' . $row['assistant_id'] . '</p>';
                    echo '<p class="employee-fullname" style="display: none;">' . $row['assistant_fullName'] . '</p>';
                    echo '<p class="objection-description" style="display: none;">' . $row['objection_reason'] . '</p>';
                    echo '<p class="objection-month" style="display: none;">' . $row['objection_month'] . '</p>';
                    echo '</div>';
                    echo '
                    <form action="../php/response_objection.php" class="d-flex align-items-end" method="post"> 
                        <input type="hidden" name="assistant_id" value="'. $row['assistant_id'] .'">
                        <input type="hidden" name="leader_id" value="'. $leader_id .'">
                        <input type="hidden" name="objection_id" value="'. $row['objection_id'] .'">
                        <textarea name="response_content" class="mr-2 w-50"></textarea>
                        <button type="submit" class="btn btn-primary mr-2" name="response_action" value="accept">Accept</button>
                        <button type="submit" class="btn btn-primary" name="response_action" value="reject">Reject</button>
                    </form>';
                }
            }
        } else {
            // If no objection items found, display a message
            echo '<p>No objection items found.</p>';
        }
        ?>
    </div>
</div>

<!-- Objection Details Modal -->
<div id="objectionDetailsModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div id="objectionDetails" class="modal-body">
            <p><strong>Employee ID:</strong> <span id="employeeId"></span></p>
            <p><strong>Employee Full Name:</strong> <span id="employeeFullName"></span></p>
            <p><strong>Objection Description:</strong> <span id="objectionDescription"></span></p>
            <p><strong>Objection Month:</strong> <span id="objectionMonth"></span></p>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="teamLeaderScreen.js"></script>

</body>
</html>