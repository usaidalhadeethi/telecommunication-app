<?php
// Include the config file
require_once 'config.php';

// Initialize the session
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Define variables and initialize with empty values
    $status = $objection = "";

    // Processing form data when form is submitted
    $status = mysqli_real_escape_string($db, $_POST['status']);
    $objection = mysqli_real_escape_string($db, $_POST['objection']);

    // Ensure $_SESSION["assistant_id"] is set
    if (!isset($_SESSION["assistant_id"])) {
        echo "Session error: assistant_id not set.";
        exit;
    }

    $customer_id = $_SESSION["assistant_id"];

    // Get the last inserted reward_month from the reward table
    $sql_reward = "SELECT reward_month FROM reward ORDER BY reward_id DESC LIMIT 1";
    $result_reward = mysqli_query($db, $sql_reward);
    $row_reward = mysqli_fetch_assoc($result_reward);
    $month = $row_reward['reward_month'];

     // Fetch team_ID from the assistant table
    $sql_fetch_team_id = "SELECT team_ID FROM assistant WHERE assistant_id = ?";
    $stmt_fetch_team_id = mysqli_prepare($db, $sql_fetch_team_id);
    mysqli_stmt_bind_param($stmt_fetch_team_id, "i", $customer_id);
    mysqli_stmt_execute($stmt_fetch_team_id);
    mysqli_stmt_bind_result($stmt_fetch_team_id, $team_id);
    mysqli_stmt_fetch($stmt_fetch_team_id);
    mysqli_stmt_close($stmt_fetch_team_id);

     // Prepare an insert statement
    $sql = "INSERT INTO objection (objection_status, objection_reason, objection_month, assistant_id, team_ID) VALUES (?, ?, ?, ?, ?)";

    if ($stmt = mysqli_prepare($db, $sql)) {
         // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "sssis", $status, $objection, $month, $customer_id, $team_id);
        
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