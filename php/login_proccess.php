<?php
// Include the config file
require_once 'config.php';

// Initialize the session
session_start();

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate email and password
    if(empty($_POST["email"]) || empty($_POST["password"])) {
        echo "Please enter both email and password.";
    } else {
        $email = $_POST["email"];
        $password = $_POST["password"];
        
        // Sanitize input to prevent SQL injection
        $email = mysqli_real_escape_string($db, $email);
        
        // Prepare a select statement for assistant table
        $sql_assistant = "SELECT assistant_id, team_ID, email, password FROM assistant WHERE email = '$email'";
        
        // Execute the query for assistant table
        $result_assistant = mysqli_query($db, $sql_assistant);
        
        if($result_assistant) {
            // Check if email exists in assistant table
            if(mysqli_num_rows($result_assistant) == 1) {
                // Fetch result row
                $row = mysqli_fetch_assoc($result_assistant);
                
                // Verify password
                if($password == $row['password']) {
                    // Password is correct, so start a new session
                    session_start();
                    
                    // Store data in session variables
                    $_SESSION["loggedin"] = true;
                    $_SESSION["assistant_id"] = $row['assistant_id'];
                    $_SESSION["team_ID"] = $row['team_ID'];
                    $_SESSION["email"] = $row['email'];
                    $_SESSION["role"] = "assistant";
                    
                    // Redirect user to assistantHomePage.php page
                    header("location: ../assistantHomePage/assistantHomePage.php");
                    exit;
                } else {
                    // Display an error message if password is not valid
                    echo "Invalid email or password.";
                }
            } else {
                // If email doesn't exist in assistant table, check in team_leader table
                
                // Prepare a select statement for team_leader table
                $sql_leader = "SELECT leader_id, email, password FROM team_leader WHERE email = '$email'";
                
                // Execute the query for team_leader table
                $result_leader = mysqli_query($db, $sql_leader);
                
                if($result_leader) {
                    // Check if email exists in team_leader table
                    if(mysqli_num_rows($result_leader) == 1) {
                        // Fetch result row
                        $row = mysqli_fetch_assoc($result_leader);
                        
                        // Verify password
                        if($password == $row['password']) {
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["leader_id"] = $row['leader_id'];
                            $_SESSION["email"] = $row['email'];
                            
                            // Redirect user to leader.php page
                            header("location: ../teamLeaderScreen/teamLeaderScreen.php");
                            exit;
                        } else {
                            // Display an error message if password is not valid
                            echo "Invalid email or password.";
                        }
                    } else {
                        // Display an error message if email doesn't exist in both tables
                        echo "Invalid email or password.";
                    }
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }
                
                // Free result set for team_leader table
                mysqli_free_result($result_leader);
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
        
        // Free result set for assistant table
        mysqli_free_result($result_assistant);
        
        // Close connection
        mysqli_close($db);
    }
}
?>
