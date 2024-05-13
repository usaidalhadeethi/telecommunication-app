<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asistant Home</title>
    <link rel="stylesheet" href="assistantHomePage.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>


<!-- As a heading -->
<nav class="navbar bg-dark text-white">
  <div class="container-fluid">
    <span class="navbar-brand mb-0 h1"><?php
session_start();

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

    
    <div class="container mt-5">
        <h2 class="text-center">Welcome to assistant panel</h2>
        <div class="listContainer d-flex justify-content-between">
            <a href="../callsList/callsList.html" class="rounded p-5 text-decoration-none text-white">Customer call list menu</a>
            <a href="../bonusesList/bonusesList.html" class="rounded p-5 text-decoration-none text-white">Monthly bonus list menu</a>
            <a href="../objectionsList/objectionsList.htm" class="rounded p-5 text-decoration-none text-white">List menu of objections</a>
        </div>
    </div>
</body>
</html>