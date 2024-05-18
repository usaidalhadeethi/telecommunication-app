<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calls List</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="callsList.css">
</head>
<body>
<!-- As a heading -->
<nav class="navbar bg-dark text-white">
  <div class="container-fluid">
    <span class="navbar-brand mb-0 h1">
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
</span>
<span><a class="btn btn-primary" href="../login/logout.php">Logout</a>
</span>
  </div>
</nav>
    <div class="container">
        <h1 class="mt-4 mb-3 text-center">Customer Call List</h1>
        <button class="btn btn-primary mb-2" id="newCallBtn">New Call</button>
        <div class="calls text-white">
        
            <?php
            include '../php/config.php';
            // Execute your database query here to fetch the call details
            // Assuming $rows is an array containing all fetched rows

            // Example database query
            // Example database query
$query = "SELECT c.customer_fullName, c.customer_id, tc.call_subject, tc.call_date, tc.call_startTime, tc.call_finishTime, tc.call_status 
FROM tbl_call tc
LEFT JOIN customer c ON tc.customer_id = c.customer_id
JOIN assistant a ON tc.assistant_id = a.assistant_id
WHERE a.assistant_id = ?
ORDER BY tc.call_id DESC";

$stmt = mysqli_prepare($db, $query);
mysqli_stmt_bind_param($stmt, "i", $_SESSION["assistant_id"]);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

            // Check if query was successful
            if ($result && mysqli_num_rows($result) > 0) {
                // Fetch all rows into an associative array
                $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
                foreach ($rows as $row) {
            ?>
                <div class="call rounded">
                    <div class="row justify-content-between">
                        <p>Full Name: <?php echo $row['customer_fullName']; ?></p>
                        <p>Call Subject: <?php echo $row['call_subject']; ?></p>
                        <p>Date: <?php echo $row['call_date']; ?></p>
                    </div>
                    <div class="row m-0 justify-content-between">
                        <p>Start Time: <?php echo $row['call_startTime']; ?></p>
                        <p>End Time: <?php echo $row['call_finishTime']; ?></p>
                        <p>Status: <?php echo $row['call_status']; ?></p>
                    </div>
                </div>
            <?php
                }
            } else {
                echo "<p class='text-dark'>No calls found.</p>";            
            }
            ?>
        </div>
    </div>

    <!-- Pop-up form -->
    <div class="overlay" id="overlay"></div>
    <div class="popup rounded" id="callForm">
        <h2>New Call</h2>
        <form method="post" action="../php/add_new_call.php">
            <div class="form-group">
                <label for="customerFullName">Customer Full Name :</label>
                <input name="customerFullName" type="text" class="form-control" id="customerFullName" required>
            </div>
            <div class="form-group">
                <label for="customerFullName">Customer İd :</label>
                <input name="customerid" type="number" class="form-control" id="customerFullName" required>
            </div>
            <div class="form-group">
                <label for="callSubject">Call Subject :</label>
                <select name="callSubject" class="form-control" id="callSubject" required>
                    <option value="Fault" >Fault</option>
                    <option value="Request" >Request</option>
                </select>
            </div>
            <div class="form-group">
                <label for="callDate">Call Date :</label>
                <input name="callDate" type="date" class="form-control" id="callDate" required>
            </div>
            <div class="form-group">
                <label for="startTime">Start Time :</label>
                <input  name="startTime" type="time" class="form-control" id="startTime" required>
            </div>
            <div class="form-group">
                <label for="endTime">End Time :</label>
                <input name="endTime" type="time" class="form-control" id="endTime" required>
            </div>
            <div class="form-group">
                <label for="callStatus">Call Status :</label>
                <select name="callStatus" class="form-control" id="callStatus" required>
                    <option value="Completed">Completed</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Problem could not solved">Problem could not solved</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="callList.js"></script>
</body>
</html>
