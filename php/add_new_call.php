<?php
// Include the config file
require_once 'config.php';

// Initialize the session
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Define variables and initialize with empty values
    $customerFullName = $callSubject = $callDate = $startTime = $endTime = $callStatus = "";

    // Processing form data when form is submitted
    $customerFullName = mysqli_real_escape_string($db, $_POST['customerFullName']);
    $callSubject = mysqli_real_escape_string($db, $_POST['callSubject']);
    $callDate = mysqli_real_escape_string($db, $_POST['callDate']);
    $startTime = mysqli_real_escape_string($db, $_POST['startTime']);
    $endTime = mysqli_real_escape_string($db, $_POST['endTime']);
    $callStatus = mysqli_real_escape_string($db, $_POST['callStatus']);
    $customerid = mysqli_real_escape_string($db, $_POST['customerid']);

    // Ensure $_SESSION["assistant_id"] is set
    if (!isset($_SESSION["assistant_id"])) {
        echo "Session error: assistant_id not set.";
        exit;
    }

    $customer_id = $_SESSION["assistant_id"];

    // Prepare an insert statement
    $sql = "INSERT INTO tbl_call (customer_name, customer_id, assistant_id, call_date, call_subject, call_startTime, call_finishTime, call_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = mysqli_prepare($db, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "siisssss", $customerFullName, $customerid, $customer_id, $callDate, $callSubject, $startTime, $endTime, $callStatus);
        
        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Redirect to success page or do something else upon success
            header("location: ../callsList/callsList.php");
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
