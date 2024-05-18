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

    $assistant_id = $_SESSION["assistant_id"];

    // Start transaction
    mysqli_begin_transaction($db);

    try {
        // Insert into customer table
        $sql_insert_customer = "INSERT INTO customer (customer_id, customer_fullName) VALUES (?, ?)";
        $stmt_insert_customer = mysqli_prepare($db, $sql_insert_customer);
        mysqli_stmt_bind_param($stmt_insert_customer, "is", $customerid, $customerFullName);
        mysqli_stmt_execute($stmt_insert_customer);
        mysqli_stmt_close($stmt_insert_customer);

        // Insert into tbl_call table
        $sql_insert_call = "INSERT INTO tbl_call (customer_id, assistant_id, call_date, call_subject, call_startTime, call_finishTime, call_status) 
                            VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert_call = mysqli_prepare($db, $sql_insert_call);
        mysqli_stmt_bind_param($stmt_insert_call, "iisssss", $customerid, $assistant_id, $callDate, $callSubject, $startTime, $endTime, $callStatus);
        mysqli_stmt_execute($stmt_insert_call);
        mysqli_stmt_close($stmt_insert_call);

        // Commit transaction
        mysqli_commit($db);

        // Redirect to success page
        header("location: ../callsList/callsList.php");
        exit;
    } catch (Exception $e) {
        // Rollback transaction on error
        mysqli_rollback($db);
        echo "Oops! Something went wrong. Please try again later.";
    }

    // Close connection
    mysqli_close($db);
}
?>