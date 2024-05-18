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

<nav class="navbar bg-dark text-white">
  <div class="container-fluid">
    <span class="navbar-brand mb-0 h1">
<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION["assistant_id"]) || $_SESSION["role"] != "assistant" || empty($_SESSION["assistant_id"])) {
    // Redirect to the login page if not logged in
    header("Location: ../login/login.php");
    exit; // Stop further script execution
}

if (isset($_SESSION["email"]) && !empty($_SESSION["email"])) {
    // User is logged in, so display their email
    echo $_SESSION["email"];
} else {
    // User is not logged in, so redirect to the login page
    header("Location: ../login/login.php");
    exit; // Make sure to stop the script after redirection
}
?>
</span>
<span><a class="btn btn-primary" href="../login/logout.php">Logout</a></span>
  </div>
</nav>

<div class="container">
    <h1 class="mt-4 mb-5 text-center">Bonus List</h1>
    <div class="bonus-list">
        <!-- PHP code to fetch and display bonus items -->
        <?php
        // Include the config file
        require_once '../php/config.php';

        // Get the assistant_id from the session
        $assistant_id = $_SESSION["assistant_id"];

        // Fetch bonus items from the database for the logged-in assistant
        $sql = "SELECT * FROM reward WHERE assistant_id = ? ORDER BY reward_id ASC";
        $stmt = mysqli_prepare($db, $sql);

        // Bind the assistant_id parameter
        mysqli_stmt_bind_param($stmt, "i", $assistant_id);

        // Execute the statement
        mysqli_stmt_execute($stmt);

        // Get the result
        $result = mysqli_stmt_get_result($stmt);

        // Initialize a variable to track if there are any bonus items
        $hasBonusItems = false;

        // Check if there are any bonus items
        if ($result && mysqli_num_rows($result) > 0) {
            $hasBonusItems = true;
            // Loop through each bonus item
            while ($row = mysqli_fetch_assoc($result)) {
                // Display the bonus item
                echo '<div class="bonus mb-3 rounded">';
                echo '<div class="row justify-content-between">';
                echo '<p>Month : ' . $row['reward_month'] . '</p>';
                echo '<p>' . $row['reward_amount'] . ' TL</p>';
                echo '</div>'; // Close row div
                echo '</div>'; // Close bonus div
                // Store the month of the last reward
                $month = $row['reward_month'];
            }
        } else {
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

<!-- Conditionally render the objection button -->
<?php if ($hasBonusItems): ?>
    <div><button class="btn btn-primary d-block objection-btn m-auto">Objection</button></div>
<?php endif; ?>

<!-- Pop-up form -->
<div class="overlay" id="overlay"></div>
<div class="popup rounded text-dark" id="objectionForm">
    <h2>Objection</h2>
    <form method="post" action="../php/add_objection.php">
        <div class="form-group">
            <input name="month" type="hidden" value="<?php echo isset($month) ? $month : ''; ?>"></input>
            <input name="status" type="hidden" value="pending"></input>
            <input name="assistant_id" type="hidden" value="<?php echo $assistant_id; ?>"></input>
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
