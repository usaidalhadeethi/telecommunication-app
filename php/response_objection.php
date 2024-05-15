<?php
// Include the config file
require_once 'config.php';

// Check if the form is submitted using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the required fields are set and not empty
    if (isset($_POST['assistant_id'], $_POST['leader_id'], $_POST['response_content'], $_POST['response_action']) && !empty($_POST['assistant_id']) && !empty($_POST['leader_id']) && !empty($_POST['response_content']) && !empty($_POST['response_action'])) {
        // Sanitize input data
        $assistant_id = mysqli_real_escape_string($db, $_POST['assistant_id']);
        $leader_id = mysqli_real_escape_string($db, $_POST['leader_id']);
        $response_content = mysqli_real_escape_string($db, $_POST['response_content']);
        $response_action = mysqli_real_escape_string($db, $_POST['response_action']);
        $objection_id = mysqli_real_escape_string($db, $_POST['objection_id']);
        
        // Start a transaction
        mysqli_begin_transaction($db);

        // Prepare and execute the SQL statement to insert the response into the response table
        $sql_response = "INSERT INTO response (assistant_id, leader_id, response_content, response_action) VALUES ('$assistant_id', '$leader_id', '$response_content', '$response_action')";
        
        // Prepare and execute the SQL statement to update the status in the objection table
        $sql_update_status = "UPDATE objection SET objection_status = '$response_action' WHERE objection_id = '$objection_id'";
        
        // Execute both queries within a transaction
        if (mysqli_query($db, $sql_response) && mysqli_query($db, $sql_update_status)) {
            // Commit transaction
            mysqli_commit($db);
            // Response and status updated successfully
            echo "Response inserted and status updated successfully.";
        } else {
            // Rollback transaction if any query fails
            mysqli_rollback($db);
            // Error inserting response or updating status
            echo "Error: " . mysqli_error($db);
        }
    } else {
        // Required fields are missing
        echo "All fields are required.";
    }
} else {
    // Redirect if form is not submitted using POST method
    header("Location: ../error_page.php");
}
?>
