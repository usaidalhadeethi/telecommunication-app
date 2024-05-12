<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Assistants</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>List of Assistants</h2>
    <?php
    // Include the config.php file
    require_once '../php/config.php';

    // Query to select all assistants
    $sql = "SELECT * FROM assistant";

    // Perform the query
    $result = $db->query($sql);

    // Check if the query was successful
    if ($result) {
        // Check if there are any rows returned
        if ($result->num_rows > 0) {
            // Display table header
            echo "<table>";
            echo "<tr><th>Assistant ID</th><th>Full Name</th><th>Email</th><th>Team ID</th></tr>";
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["assistant_id"] . "</td>";
                echo "<td>" . $row["assistant_fullName"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td>" . $row["team_ID"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No assistants found.";
        }
    } else {
        echo "Error: " . $db->error;
    }

    // Close the database connection
    $db->close();
    ?>
</body>
</html>
