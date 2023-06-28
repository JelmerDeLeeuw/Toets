<?php
session_start();
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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <!-- Bootstrap core CSS -->
    <link href="../../dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="product.css" rel="stylesheet">

    <link href="style.css" rel="stylesheet">

    <script>
        function generateRandomDistance() {
            var distance = Math.floor(Math.random() * 500) + 1; // Generate a random number between 1 and 100
            return distance;
        }

        setInterval(function () {
            var randomDistance = generateRandomDistance();
            document.getElementById("distance").textContent = "De afstand tot je huis is: " + randomDistance + " Meter";
        }, 2000); // Execute the code every 10 seconds (10000 milliseconds))
    </script>
</head>

<body>

    <nav class="site-header sticky-top py-1">
        <div class="container d-flex flex-column flex-md-row justify-content-between">
            <img class="logo" src="../Toets Track and Trace/img/logo.png">
            <div>
                <?php
                if (isset($_SESSION['Name'])) {
                    $userId = $_SESSION['Name'];
                    echo '<a class="py-2 d-none d-md-inline-block" href="index.php">Home</a>';
                } else {
                    echo '<a class="py-2 d-none d-md-inline-block" href="index.php">Home</a>';
                }
                ?>
            </div>
        </div>
    </nav>


    <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-light">
        <div class="col-md-5 p-lg-5 mx-auto my-5">
            <h1 class="display-4 font-weight-normal">Dit is het dashboard</h1>
            <p class="lead font-weight-normal">
                Uw bestellingen:
            </p>
            <p id="distance"></p>
            <?php
            $host = 'localhost';
            $username = 'root';
            $password = '';
            $database = 'trackandtrace';

            // Establishing database connection
            $connection = mysqli_connect($host, $username, $password, $database);
            if (!$connection) {
                die("Connection failed: " . mysqli_connect_error());
            }

            if (isset($_SESSION['Name'])) {
                $userId = $_SESSION['Name'];
            }
            // Retrieve user_id from the user table
            $userQuery = mysqli_query($connection, "SELECT id FROM user");
            if ($userQuery) {
                $userRow = mysqli_fetch_assoc($userQuery);
                if ($userRow) {
                    $user_id = $userRow['id'];

                    // Retrieve orders from the orders table
                    $orders = mysqli_query($connection, "SELECT * FROM arrival_time");
                    if ($orders) {
                        if (mysqli_num_rows($orders) > 0) {
                            echo '<table class="table">';
                            echo '<thead>';
                            echo '<tr>';
                            echo '<th>ID</th>';
                            echo '<th>Order ID</th>';
                            echo '<th>Time</th>';
                            echo '<th>Place</th>';
                            echo '</tr>';
                            echo '</thead>';
                            echo '<tbody>';

                            while ($row = mysqli_fetch_assoc($orders)) {
                                echo '<tr>';
                                echo '<td>' . $row['id'] . '</td>';
                                echo '<td>' . $row['order_id'] . '</td>';
                                echo '<td>' . $row['time'] . '</td>';
                                echo '<td>' . $row['place'] . '</td>';
                                echo '</tr>';
                            }

                            echo '</tbody>';
                            echo '</table>';
                        } else {
                            echo '<p>No orders found.</p>';
                        }
                    } else {
                        echo "Error: " . mysqli_error($connection);
                    }
                } else {
                    echo "No user found.";
                }
            } else {
                echo "Error: " . mysqli_error($connection);
            }
            

            // Close the database connection
            mysqli_close($connection);
            ?>
        </div>
        <div class="product-device box-shadow d-none d-md-block"></div>
        <div class="product-device product-device-2 box-shadow d-none d-md-block"></div>
    </div>

    <!-- Bootstrap core JavaScript
================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
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