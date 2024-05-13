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


<?php
            // Include the config file
            require_once '../php/config.php';

            // Fetch bonus items from the database
            $sql = "SELECT * FROM objections_list_view ";
            $result = mysqli_query($db, $sql);
    
           


// Check if there are any bonus items


            ?>




    <div class="container">
        <h1 class="mt-4 mb-5 text-center">Employee Objections List</h1>
        <div class="objections">
            <!-- Objection items will be dynamically added here -->
            <?php  
            
             // Check if there are any bonus items
             if ($result && mysqli_num_rows($result) > 0) {
                // Loop through each bonus item
                while ($row = mysqli_fetch_assoc($result)) {
                    // Display the bonus item
                    echo '<div class="objection-item">';
                    echo '<p class="objection-subject">' . $row['objection_reason'] . '</p>';
                    echo '<button class="btn btn-primary answer-btn">Answer</button>';
                    echo '</div>';


                }
            } else {
                // If no bonus items found, display a message
                echo '<p>No bonus items found.</p>';
            }

            ?>

           
            <!-- More objection items can be added similarly -->
        </div>
    </div>
<!-- Objection Details Modal -->
<div id="objectionDetailsModal" class="modal">
                        <div class="modal-content">
                            <span class="close">&times;</span>
                            <div id="objectionDetails" class="modal-body">
                                <p><strong>Employee ID:</strong> <span id="employeeId">'. $row['assistant_id'] .'</span></p>
                                <p><strong>Employee Full Name:</strong> <span id="employeeFullName">'. $row['assistant_fullName'] .'</span></p>
                                <p><strong>Objection Description:</strong> <span id="objectionDescription">Sample objection description</span></p>
                                <p><strong>Objection Month:</strong> <span id="objectionMonth">May 2024</span></p>
                            </div>
                        </div>
                    </div>


    <!-- Pop-up form -->
    <div class="overlay" id="overlay"></div>
    <div class="popup rounded" id="answerForm">
        <h2>Answer Objection</h2>
        <form id="answerObjectionForm">
            <div class="form-group">
                <label for="response">Response :</label>
                <textarea class="form-control" id="response" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Accept</button>
            <button type="submit" class="btn btn-primary">Reject</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="teamLeaderScreen.js"></script>


    <?php             // Free result set
            mysqli_free_result($result);

            // Close connection
            mysqli_close($db); ?>
</body>
</html>
