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


// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION["leader_id"]) || empty($_SESSION["leader_id"]) ||  $_SESSION["role"]!="leader") {
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

</span>
<span><a class="btn btn-primary" href="../login/logout.php">Logout</a>
</span>
  </div>
</nav>


<?php
    // Include the config file
    require_once '../php/config.php';


    // Fetch objection items from the database
    $sql = "SELECT * FROM objections_list_view";
    $result = mysqli_query($db, $sql);
?>

<div class="container">
    <h1 class="mt-4 mb-5 text-center">Employee Objections List</h1>
    <div class="objections">
        <!-- Objection items will be dynamically added here -->
        <?php  
        // Check if there are any objection items
        if ($result && mysqli_num_rows($result) > 0) {
            // Loop through each objection item
            while ($row = mysqli_fetch_assoc($result)) {
              
if($row['objection_status']=="pending"){


               
                // Display the objection item
                echo '<div class="objection-item">';
                echo '<p class="objection-subject">' . $row['objection_reason'] . '</p>';
                echo '<p class="employee-id" style="display: none;">' . $row['assistant_id'] . '</p>';
                echo '<p class="employee-fullname" style="display: none;">' . $row['assistant_fullName'] . '</p>';
                echo '<p class="objection-description" style="display: none;">' . $row['objection_reason'] . '</p>';
                echo '<p class="objection-month" style="display: none;">' . $row['objection_month'] . '</p>';
                 echo '</div>';
                echo '
                <form action="../php/response_objection.php" method="post"> 
                    <input type="hidden" name="assistant_id" value="'. $row['assistant_id'] .'">
                    <input type="hidden" name="leader_id" value="'. $_SESSION['leader_id'] .'">
                    <input type="hidden" name="objection_id" value="'. $row['objection_id'] .'">
                    <textarea name="response_content"></textarea>
                    <button type="submit" class="btn btn-primary" name="response_action" value="accept">Accept</button>
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

<!-- Pop-up form -->
<!-- <div class="overlay" id="overlay"></div>
<div class="popup rounded" id="answerForm">
    <h2>Answer Objection</h2>
</div> -->

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="teamLeaderScreen.js"></script>

</body>
</html>
