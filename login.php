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
        $username = mysqli_real_escape_string($conn, $_POST['user']); // Escape input to prevent SQL injection
        $password = mysqli_real_escape_string($conn, $_POST['pass']); // Escape input to prevent SQL injection

        // Fetch user from the database
        $query = "SELECT * FROM user WHERE Name = '$username' AND Password = '$password'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) == 1) {
            // Authentication successful, create session
            $row = mysqli_fetch_assoc($result);
            $_SESSION['Name'] = $row['Name']; // Store the username
            $_SESSION['UserID'] = $row['UserID']; // Store the UserID or any other relevant data from the user table
            header('Location: index.php'); // Redirect to the dashboard page
            exit(); // Terminate the script after the redirect
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
<html>
<head>
    <meta name="Jelmer de Leeuw" content="Portfolio website">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="bovenbalk"></div>
        <img class="Logo" src="../Toets Track and Trace/img/logo.png">
    </header>

    <div id="frm">
        <h1 class="logintext">Login</h1>
        <form method="POST">
            <p>
                <label class="username"> Gebruikersnaam: </label>
                <input type="text" id="user" name="user" required /> <!-- Added "required" attribute for input validation -->
            </p>
            <p>
                <label class="password"> Wachtwoord: </label>
                <input class="password1" type="password" id="pass" name="pass" required /> <!-- Added "required" attribute for input validation -->
            </p>
            <p>
                <input type="submit" id="btn" value="Login" />
            </p>
        </form>
        <?php
            if ($login_error !== null) {
                echo '<p class="error">' . $login_error . '</p>';
            }
        ?>
    </div>
</body>
</html>
