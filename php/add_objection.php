<?php
// Include the config file
require_once 'config.php';

// Initialize the session
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Define variables and initialize with empty values
    $month = $status = $objection = "";

    // Processing form data when form is submitted
    $month = mysqli_real_escape_string($db, $_POST['month']);
    $status = mysqli_real_escape_string($db, $_POST['status']);
    $objection = mysqli_real_escape_string($db, $_POST['objection']);
  
    // Ensure $_SESSION["assistant_id"] is set
    if (!isset($_SESSION["assistant_id"])) {
        echo "Session error: assistant_id not set.";
        exit;
    }

    $customer_id = $_SESSION["assistant_id"];

    // Prepare an insert statement
    $sql = "INSERT INTO objection (objection_status, objection_reason, objection_month, assistant_id) VALUES (?, ?, ?, ?)";

    if ($stmt = mysqli_prepare($db, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "sssi", $status, $objection, $month, $customer_id);
        
        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Redirect to success page or do something else upon success
            header("location: ../bonusesList/bonusesList.php");
            exit;
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Oops! Something went wrong. Please try again later.";
    }

    // Close connection
    mysqli_close($db);
}
?>
