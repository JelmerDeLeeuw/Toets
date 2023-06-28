<?php

function handleLogin()
{
    // Database connection credentials
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'trackandtrace';

    // Establishing database connection
    $conn = mysqli_connect($host, $username, $password, $database);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    session_start();

    // Login form submission handling
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['user'];
        $password = $_POST['pass'];

        // Fetch user from the database
        $query = "SELECT * FROM user WHERE Name = '$username' AND Password = '$password'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) == 1) {
            // Authentication successful, create session
            $row = mysqli_fetch_assoc($result);
            $_SESSION['Name'] = $username;
            $_SESSION['ID'] = session_id(); // Store the session ID
            $_SESSION['UserID'] = $row['UserID']; // Store any other relevant data from the user table
            header('Location: index.php'); // Redirect to the dashboard page (index.php)
            exit(); // Terminate script execution after redirect
        } else {
            // Authentication failed
            $login_error = "Invalid username or password.";
        }
    }

    mysqli_close($conn);

    return isset($login_error) ? $login_error : null;
}

// Call the login function
$login_error = handleLogin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

    <title>Product example for Bootstrap</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/product/">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <!-- Bootstrap core CSS -->
    <link href="../../dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="product.css" rel="stylesheet">

    <link href="style.css" rel="stylesheet">
</head>

<body>

    <nav class="site-header sticky-top py-1">
        <div class="container d-flex flex-column flex-md-row justify-content-between">
            <img class="logo" src="../Toets Track and Trace/img/logo.png">
            <div>
                <?php
                if (isset($_SESSION['Name'])) {
                  echo '<a class="py-2 d-none d-md-inline-block" href="trackandtrace.php">Track and Trace</a>';
              } else {
                  echo '<a class="py-2 d-none d-md-inline-block" href="login.php">Login</a>';
              }
                ?>
            </div>
        </div>
    </nav>

    <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-light">
        <div class="col-md-5 p-lg-5 mx-auto my-5">
            <h1 class="display-4 font-weight-normal">Dit is de home page</h1>
            <p class="lead font-weight-normal">Hier komt normaal alle producten maar nu niet hahahhahhahaha</p>
            <a class="btn btn-outline-secondary" href="#">Komt nooit</a>
        </div>
        <div class="product-device box-shadow d-none d-md-block"></div>
        <div class="product-device product-device-2 box-shadow d-none d-md-block"></div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="../../assets/js/vendor/popper.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <script src="../../assets/js/vendor/holder.min.js"></script>
    <script>
        Holder.addTheme('thumb', {
            bg: '#55595c',
            fg: '#eceeef',
            text: 'Thumbnail'
        });
    </script>
</body>
</html>
