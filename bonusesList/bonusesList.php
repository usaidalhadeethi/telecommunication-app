<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assistant Bonus List</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="bonusList.css">
</head>
<body>
<?php


// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION["assistant_id"]) || $_SESSION["role"]!="assistant"|| empty($_SESSION["assistant_id"]) ) {
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
    <div class="container">
        <h1 class="mt-4 mb-5 text-center">Bonus List</h1>
        <div class="bonus-list">
            <!-- PHP code to fetch and display bonus items -->
            <?php
            // Include the config file
            require_once '../php/config.php';

            // Fetch bonus items from the database
            $sql = "SELECT * FROM reward order by reward_id asc";
            $result = mysqli_query($db, $sql);

            // Check if there are any bonus items
            if ($result && mysqli_num_rows($result) > 0) {
                // Loop through each bonus item
                while ($row = mysqli_fetch_assoc($result)) {
                    // Display the bonus item
                    echo '<div class="bonus mb-3 rounded">';
                    echo '<div class="row justify-content-between">';
                    echo '<p>' . $row['reward_month'] . '</p>';
                    echo '<p>' . $row['reward_amount'] . '</p>';
                    echo '</div>';
                    // Enable the "Objection" button only for the last entry
                  $month=$row['reward_month'];
                        
                    }
                    echo '</div>';
                }
           else {
                // If no bonus items found, display a message
                echo '<p>No bonus items found.</p>';
            }

            // Free result set
            mysqli_free_result($result);

            // Close connection
            mysqli_close($db);
            ?>
        </div>
    </div>

    <div><button class="btn btn-primary d-block objection-btn m-auto" >Objection</button></div>

 <!-- Pop-up form -->
 <div class="overlay" id="overlay"></div>
    <div class="popup rounded text-dark" id="objectionForm">
        <h2 >Objection</h2>
        <form method="post" action="../php/add_objection.php">
            <div class="form-group">
                <input name="month" type="hidden" value="<?php echo  $month; ?>"></input>
                <input name="status" type="hidden" value="pending"></input>
                <label for="objectionExplanation">Objection Explanation :</label>
                <textarea name="objection" class="form-control" id="objectionExplanation" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Send</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="bonusesList.js"></script>
</body>
</html>
