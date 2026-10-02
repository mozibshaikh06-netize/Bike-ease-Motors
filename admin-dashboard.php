<?php

session_start();

if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: admin-login.php");
    exit();
}

require_once "db.php";


// ==============================
// TEST RIDE COUNT
// ==============================

$result = $conn->query(
    "SELECT COUNT(*) AS total FROM test_rides"
);

$row = $result->fetch_assoc();

$totalTestRides = $row["total"];


// ==============================
// CONTACT MESSAGE COUNT
// ==============================

$result = $conn->query(
    "SELECT COUNT(*) AS total FROM messages"
);

$row = $result->fetch_assoc();

$totalMessages = $row["total"];


// ==============================
// RECENT TEST RIDES
// ==============================

$recentRides = $conn->query(
    "SELECT * FROM test_rides
     ORDER BY id DESC
     LIMIT 5"
);


// ==============================
// RECENT MESSAGES
// ==============================

$recentMessages = $conn->query(
    "SELECT * FROM messages
     ORDER BY id DESC
     LIMIT 5"
);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Admin Dashboard - BikeEase Motors</title>

    <link rel="stylesheet"
          href="admin-dashboard.css">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>


<!-- =================================
     SIDEBAR
================================= -->

<div class="admin-sidebar">

    <div class="admin-logo">

        <i class="fa-solid fa-motorcycle"></i>

        <span>BikeEase</span>

    </div>


    <div class="admin-menu">

        <a href="admin-dashboard.php"
           class="active">

            <i class="fa-solid fa-house"></i>

            <span>Dashboard</span>

        </a>


        <a href="test-ride-bookings.php">

            <i class="fa-solid fa-motorcycle"></i>

            <span>Test Ride Bookings</span>

        </a>


        <a href="service-appointments.php">

            <i class="fa-solid fa-screwdriver-wrench"></i>

            <span>Service Appointments</span>

        </a>


        <a href="contact-messages.php">

            <i class="fa-solid fa-message"></i>

            <span>Contact Messages</span>

        </a>


        <a href="registered-users.php">

            <i class="fa-solid fa-users"></i>

            <span>Registered Users</span>

        </a>


        <a href="admin-logout.php"
           class="admin-logout">

            <i class="fa-solid fa-right-from-bracket"></i>

            <span>Logout</span>

        </a>

    </div>

</div>



<!-- =================================
     MAIN CONTENT
================================= -->

<div class="admin-main">

    <!-- TOP HEADER -->

    <div class="admin-header">

        <div>

            <h1>Admin Dashboard</h1>

            <p>
                Welcome to BikeEase Motors Admin Panel
            </p>

        </div>


        <div class="admin-user">

            <i class="fa-solid fa-user-shield"></i>

            <span>
                <?php
                echo htmlspecialchars(
                    $_SESSION["admin_username"]
                );
                ?>
            </span>

        </div>

    </div>



    <!-- =================================
         STAT CARDS
    ================================= -->

    <div class="admin-stats">


        <div class="admin-stat-card">

            <div class="stat-icon">
                <i class="fa-solid fa-motorcycle"></i>
            </div>

            <div>

                <h2>
                    <?php echo $totalTestRides; ?>
                </h2>

                <p>Test Ride Bookings</p>

            </div>

        </div>



        <div class="admin-stat-card">

            <div class="stat-icon">
                <i class="fa-solid fa-screwdriver-wrench"></i>
            </div>

            <div>

                <h2>0</h2>

                <p>Service Appointments</p>

            </div>

        </div>



        <div class="admin-stat-card">

            <div class="stat-icon">
                <i class="fa-solid fa-message"></i>
            </div>

            <div>

                <h2>
                    <?php echo $totalMessages; ?>
                </h2>

                <p>Contact Messages</p>

            </div>

        </div>



        <div class="admin-stat-card">

            <div class="stat-icon">
                <i class="fa-solid fa-users"></i>
            </div>

            <div>

                <h2>0</h2>

                <p>Registered Users</p>

            </div>

        </div>

    </div>



    <!-- =================================
         RECENT TEST RIDES
    ================================= -->

    <div class="admin-panel">

        <div class="panel-heading">

            <h2>
                Recent Test Ride Bookings
            </h2>

            <a href="test-ride-bookings.php">
                View All
            </a>

        </div>


        <div class="table-wrapper">

            <table>

                <thead>

                    <tr>

                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Bike</th>
                        <th>Model</th>
                        <th>Phone</th>
                        <th>Location</th>

                    </tr>

                </thead>


                <tbody>

                <?php if ($recentRides->num_rows > 0): ?>

                    <?php while ($ride = $recentRides->fetch_assoc()): ?>

                        <tr>

                            <td>
                                <?php
                                echo htmlspecialchars(
                                    $ride["id"]
                                );
                                ?>
                            </td>

                            <td>
                                <?php
                                echo htmlspecialchars(
                                    $ride["full_name"]
                                );
                                ?>
                            </td>

                            <td>
                                <?php
                                echo htmlspecialchars(
                                    $ride["email"]
                                );
                                ?>
                            </td>

                            <td>
                                <?php
                                echo htmlspecialchars(
                                    $ride["bike_name"]
                                );
                                ?>
                            </td>

                            <td>
                                <?php
                                echo htmlspecialchars(
                                    $ride["bike_model"]
                                );
                                ?>
                            </td>

                            <td>
                                <?php
                                echo htmlspecialchars(
                                    $ride["phone"]
                                );
                                ?>
                            </td>

                            <td>
                                <?php
                                echo htmlspecialchars(
                                    $ride["location"]
                                );
                                ?>
                            </td>

                        </tr>

                    <?php endwhile; ?>

                <?php else: ?>

                    <tr>

                        <td colspan="7"
                            class="empty-row">

                            No test ride bookings yet.

                        </td>

                    </tr>

                <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>



    <!-- =================================
         RECENT MESSAGES
    ================================= -->

    <div class="admin-panel">

        <div class="panel-heading">

            <h2>
                Recent Contact Messages
            </h2>

            <a href="contact-messages.php">
                View All
            </a>

        </div>


        <div class="table-wrapper">

            <table>

                <thead>

                    <tr>

                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Message</th>

                    </tr>

                </thead>


                <tbody>

                <?php if ($recentMessages->num_rows > 0): ?>

                    <?php while ($message = $recentMessages->fetch_assoc()): ?>

                        <tr>

                            <td>
                                <?php
                                echo htmlspecialchars(
                                    $message["id"]
                                );
                                ?>
                            </td>

                            <td>
                                <?php
                                echo htmlspecialchars(
                                    $message["full_name"]
                                );
                                ?>
                            </td>

                            <td>
                                <?php
                                echo htmlspecialchars(
                                    $message["email"]
                                );
                                ?>
                            </td>

                            <td>
                                <?php
                                echo htmlspecialchars(
                                    $message["subject"]
                                );
                                ?>
                            </td>

                            <td>
                                <?php
                                echo htmlspecialchars(
                                    $message["message"]
                                );
                                ?>
                            </td>

                        </tr>

                    <?php endwhile; ?>

                <?php else: ?>

                    <tr>

                        <td colspan="5"
                            class="empty-row">

                            No contact messages yet.

                        </td>

                    </tr>

                <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>


</div>

</body>
</html>