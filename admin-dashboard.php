<?php
session_start();
require_once "db.php";

// Redirect if not logged in
if (!isset($_SESSION["admin_logged_in"]) || $_SESSION["admin_logged_in"] !== true) {
    header("Location: admin-login.php");
    exit();
}

// Which page is selected?
$page = $_GET['page'] ?? 'dashboard';


// =======================================
// DASHBOARD COUNTS
// =======================================

$userCount = 0;
$testRideCount = 0;
$serviceCount = 0;
$messageCount = 0;


// Users Count
$result = $conn->query("SELECT COUNT(*) AS total FROM users");
if ($result) {
    $row = $result->fetch_assoc();
    $userCount = $row['total'];
}


// Test Rides Count
$result = $conn->query("SELECT COUNT(*) AS total FROM test_rides");
if ($result) {
    $row = $result->fetch_assoc();
    $testRideCount = $row['total'];
}


// Service Appointments Count
$result = $conn->query("SELECT COUNT(*) AS total FROM service_appointments");
if ($result) {
    $row = $result->fetch_assoc();
    $serviceCount = $row['total'];
}


// Contact Messages Count (Using 'messages' table)
$result = $conn->query("SELECT COUNT(*) AS total FROM messages");
if ($result) {
    $row = $result->fetch_assoc();
    $messageCount = $row['total'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - BikeEase Motors</title>
    <link rel="stylesheet" href="admin-dashboard.css">
</head>

<body>

<!-- =======================================
     SIDEBAR
======================================= -->

<div class="sidebar">
    <h2>BIKEEASE</h2>
    <p class="admin-title">ADMIN PANEL</p>

    <a href="admin-dashboard.php?page=dashboard"
       class="<?php echo ($page == 'dashboard') ? 'active' : ''; ?>">
        🏠 Dashboard
    </a>

    <a href="admin-dashboard.php?page=test-rides"
       class="<?php echo ($page == 'test-rides') ? 'active' : ''; ?>">
        🏍 Test Ride Bookings
    </a>

    <a href="admin-dashboard.php?page=services"
       class="<?php echo ($page == 'services') ? 'active' : ''; ?>">
        🔧 Service Appointments
    </a>

    <a href="admin-dashboard.php?page=messages"
       class="<?php echo ($page == 'messages') ? 'active' : ''; ?>">
        ✉ Contact Messages
    </a>

    <a href="admin-dashboard.php?page=users"
       class="<?php echo ($page == 'users') ? 'active' : ''; ?>">
        👤 Registered Users
    </a>

    <a href="admin-logout.php" class="logout">
        🚪 Logout
    </a>
</div>


<!-- =======================================
     MAIN CONTENT
======================================= -->

<div class="main-content">

    <!-- DASHBOARD -->
    <?php if ($page == 'dashboard'): ?>

        <h1>Dashboard</h1>
        <p class="welcome">Welcome to BikeEase Motors Admin Panel</p>

        <div class="cards">
            <div class="card">
                <div class="card-icon">👤</div>
                <div>
                    <h3>Registered Users</h3>
                    <p><?php echo $userCount; ?></p>
                </div>
            </div>

            <div class="card">
                <div class="card-icon">🏍</div>
                <div>
                    <h3>Test Ride Bookings</h3>
                    <p><?php echo $testRideCount; ?></p>
                </div>
            </div>

            <div class="card">
                <div class="card-icon">🔧</div>
                <div>
                    <h3>Service Appointments</h3>
                    <p><?php echo $serviceCount; ?></p>
                </div>
            </div>

            <div class="card">
                <div class="card-icon">✉</div>
                <div>
                    <h3>Messages</h3>
                    <p><?php echo $messageCount; ?></p>
                </div>
            </div>
        </div>

        <div class="dashboard-box">
            <h2>BikeEase Motors</h2>
            <p>
                Use the sidebar to manage test rides, service appointments, 
                contact messages and registered users.
            </p>
        </div>


    <!-- TEST RIDE BOOKINGS -->
    <?php elseif ($page == 'test-rides'): ?>

        <h1>Test Ride Bookings</h1>

        <div class="table-container">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Bike</th>
                    <th>Model</th>
                    <th>Phone</th>
                    <th>Location</th>
                </tr>

                <?php
                $result = $conn->query("SELECT * FROM test_rides ORDER BY id DESC");

                if ($result && $result->num_rows > 0):
                    while ($row = $result->fetch_assoc()):
                ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['bike_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['bike_model']); ?></td>
                        <td><?php echo htmlspecialchars($row['phone']); ?></td>
                        <td><?php echo htmlspecialchars($row['location']); ?></td>
                    </tr>
                <?php
                    endwhile;
                else:
                ?>
                    <tr>
                        <td colspan="7">No test ride bookings found.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>


    <!-- SERVICE APPOINTMENTS -->
    <?php elseif ($page == 'services'): ?>

        <h1>Service Appointments</h1>

        <div class="table-container">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Bike</th>
                    <th>Bike Number</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Services</th>
                    <th>Price</th>
                </tr>

                <?php
                $result = $conn->query("SELECT * FROM service_appointments ORDER BY id DESC");

                if ($result && $result->num_rows > 0):
                    while ($row = $result->fetch_assoc()):
                ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['phone']); ?></td>
                        <td><?php echo htmlspecialchars($row['company'] . " " . $row['model']); ?></td>
                        <td><?php echo htmlspecialchars($row['bike_number']); ?></td>
                        <td><?php echo htmlspecialchars($row['appointment_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['appointment_time']); ?></td>
                        <td><?php echo htmlspecialchars($row['services']); ?></td>
                        <td>₹<?php echo htmlspecialchars($row['total_price']); ?></td>
                    </tr>
                <?php
                    endwhile;
                else:
                ?>
                    <tr>
                        <td colspan="10">No service appointments found.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>


    <!-- CONTACT MESSAGES (Querying 'messages' table) -->
    <?php elseif ($page == 'messages'): ?>

        <h1>Contact Messages</h1>

        <div class="table-container">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Date</th>
                </tr>

                <?php
                $result = $conn->query("SELECT * FROM messages ORDER BY id DESC");

                if ($result && $result->num_rows > 0):
                    while ($row = $result->fetch_assoc()):
                ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['name'] ?? $row['full_name'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['message']); ?></td>
                        <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                    </tr>
                <?php
                    endwhile;
                else:
                ?>
                    <tr>
                        <td colspan="5">No messages found.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>


    <!-- REGISTERED USERS -->
    <?php elseif ($page == 'users'): ?>

        <h1>Registered Users</h1>

        <div class="table-container">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Registered On</th>
                </tr>

                <?php
                $result = $conn->query("SELECT * FROM users ORDER BY id DESC");

                if ($result && $result->num_rows > 0):
                    while ($row = $result->fetch_assoc()):
                ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                    </tr>
                <?php
                    endwhile;
                else:
                ?>
                    <tr>
                        <td colspan="4">No registered users found.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>

    <?php endif; ?>

</div>

</body>
</html>