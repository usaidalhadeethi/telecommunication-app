<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assistant Objections List</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="objectionsList.css">
</head>
<body>

<?php


// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION["assistant_id"]) || empty($_SESSION["assistant_id"]) && $_SESSION["role"=="assistant"]) {
    // Redirect to the login page if not logged in
    header("Location: ../login/login.php");
    exit; // Stop further script execution
}



if(isset($_SESSION["email"]) && !empty($_SESSION["email"])) {
    // User is logged in, so display their email
    echo $_SESSION["email"];
} else {
    // User is not logged in, so redirect to the login page
    header("Location: ../login/login.php");
    exit; // Make sure to stop the script after redirection
}

?>
<?php
// Start session

// Check if user is logged in
if (!isset($_SESSION["assistant_id"]) || $_SESSION["role"]!="assistant"|| empty($_SESSION["assistant_id"]) ) {
    // Redirect to the login page if not logged in
    header("Location: ../login/login.php");
    exit; // Stop further script execution
}

// Get assistant ID from session
$assistant_id = $_SESSION["assistant_id"];

// Include the config file
require_once '../php/config.php';

// Fetch objection items from the database
$sql = "SELECT  
            o.*, 
            r.response_content
        FROM 
            objection o
        LEFT JOIN 
            response r ON o.assistant_id = r.assistant_id
        WHERE 
            o.assistant_id = ? 
           ";
$stmt = mysqli_prepare($db, $sql);
// Bind parameters
mysqli_stmt_bind_param($stmt, "i", $assistant_id);

// Execute statement
mysqli_stmt_execute($stmt);

// Get result
$result = mysqli_stmt_get_result($stmt);

// Check if there are any objection items
if ($result && mysqli_num_rows($result) > 0) {
    ?>
    <div class="container">
        <h1 class="mt-4 mb-5 text-center">Objections List</h1>
        <div class="objections-list">
            <!-- Objection items will be dynamically added here -->
            <?php  
            // Loop through each objection item
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <div class="objection mb-3 rounded">
                    <div class="row justify-content-between">
                        <p>Objection Explanation: <?php echo $row["objection_reason"]; ?></p>
                        <p>Response: <?php echo $row["response_content"]; ?></p>
                        <p>Status: <?php echo $row["objection_status"]; ?></p>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
} else {
    // If no objection items found, display a message
    echo '<p class="text-center mt-5">No objection items found.</p>';
}

// Close statement and database connection
mysqli_stmt_close($stmt);
mysqli_close($db);
?>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="objectionsList.js"></script>
</body>
</html>
