<?php
session_start();
require_once "db.php";

// Redirect to login if user is not logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login-page.php");
    exit();
}

$user_id = $_SESSION["user_id"];

// Fetch fresh user data from database
$stmt = $conn->prepare("SELECT full_name, email, created_at FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile | BikeEase Motors</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="login-page.css">
</head>
<body>

    <!-- Navbar -->
    <div class="navbar">
        <a href="index.php"><div class="nav-img"></div></a>
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="service-appoinmentpage.php">Services</a>
            <a href="about-page.php">About Us</a>
            <a href="contact.php">Contact Us</a>
        </div>
        <div class="nav-right">
            <div class="nav-login">
                <a href="logout.php">Logout</a>
            </div>
            <a href="admin-dashboard.php" class="admin-link">Admin</a>
        </div>
    </div>

    <!-- Profile Section -->
    <div class="login-container">
        <div class="login-box" style="text-align: left;">
            <h2 style="text-align: center;">User Profile</h2>
            <p style="text-align: center;">Welcome back to BikeEase Motors!</p>

            <div style="margin-top: 30px; font-size: 18px; line-height: 2;">
                <p><strong>Full Name:</strong> <?php echo htmlspecialchars($user["full_name"]); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user["email"]); ?></p>
                <p><strong>Member Since:</strong> <?php echo date("F j, Y", strtotime($user["created_at"])); ?></p>
            </div>

           <div style="margin-top: 30px; display: flex; flex-direction: column; gap: 12px;">
    <!-- Top Row: Book Service & Log Out -->
    <div style="display: flex; gap: 15px;">
        <a href="service-appointmentpage.php" style="flex: 1; text-align: center; background: #ff6b00; color: white; padding: 12px; border-radius: 8px; text-decoration: none; font-weight: bold;">Book Service</a>
        <a href="logout.php" style="flex: 1; text-align: center; background: #333; color: white; padding: 12px; border-radius: 8px; text-decoration: none; font-weight: bold;">Log Out</a>
    </div>

    <!-- Bottom Row: Explore Button -->
    <a href="index.php" style="text-align: center; background: #ea4a22ff; color: white; padding: 12px; border-radius: 8px; text-decoration: none; font-weight: bold; transition: 0.3s;">Explore Bikes & Showroom</a>
</div>
        </div>
    </div>

</body>
</html>