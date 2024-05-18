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

<nav class="navbar bg-dark text-white">
  <div class="container-fluid">
    <span class="navbar-brand mb-0 h1">
<?php

session_start();

// Check if user is logged in
if (!isset($_SESSION["assistant_id"]) || $_SESSION["role"] != "assistant" || empty($_SESSION["assistant_id"])) {
    // Redirect to the login page if not logged in
    header("Location: ../login/login.php");
    exit; // Stop further script execution
}

// Display assistant's email
if (isset($_SESSION["email"]) && !empty($_SESSION["email"])) {
    echo $_SESSION["email"];
} else {
    // Redirect to the login page if email is not set
    header("Location: ../login/login.php");
    exit; // Stop further script execution
}

?>
    </span>
    <span><a class="btn btn-primary" href="../login/logout.php">Logout</a></span>
    </div>
</nav>

<div class="container">
    <h1 class="mt-4 mb-5 text-center">Objections List</h1>
    <div class="objections-list">
        <?php
        // Get assistant ID from session
        $assistant_id = $_SESSION["assistant_id"];

        // Include the config file
        require_once '../php/config.php';

        // Fetch objections and their responses from the database
        $sql = "SELECT  
                    o.*, 
                    r.response_content
                FROM 
                    objection o
                LEFT JOIN 
                    response r ON o.objection_id = r.objection_id
                WHERE 
                    o.assistant_id = ?
                ORDER BY 
                    o.objection_id DESC";
        
        $stmt = mysqli_prepare($db, $sql);
        
        // Bind parameters
        mysqli_stmt_bind_param($stmt, "i", $assistant_id);
        
        // Execute statement
        mysqli_stmt_execute($stmt);
        
        // Get result
        $result = mysqli_stmt_get_result($stmt);
        
        // Check if there are any objection items
        if ($result && mysqli_num_rows($result) > 0) {
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
        } else {
            // If no objection items found, display a message
            echo '<p class="text-center mt-5">No objection items found.</p>';
        }
        
        // Close statement and database connection
        mysqli_stmt_close($stmt);
        mysqli_close($db);
        ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="objectionsList.js"></script>
</body>
</html>