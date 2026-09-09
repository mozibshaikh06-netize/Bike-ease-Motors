<?php
require_once "db.php";

$responseMessage = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $full_name = $_POST["full_name"] ?? "";
    $email     = $_POST["email"] ?? "";
    $subject   = $_POST["subject"] ?? "";
    $message   = $_POST["message"] ?? "";

    if (!empty($full_name) && !empty($email) && !empty($subject) && !empty($message)) {
        $stmt = $conn->prepare(
            "INSERT INTO messages (full_name, email, subject, message) VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("ssss", $full_name, $email, $subject, $message);

        if ($stmt->execute()) {
            $responseMessage = "Your message has been sent successfully!";
        } else {
            $responseMessage = "Something went wrong. Please try again.";
        }
        $stmt->close();
    } else {
        $responseMessage = "Please fill in all required fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - BikeEase Motors</title> 
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="contact.css">
</head>
<body>

<div class="navbar">
    <a href="index.php"><div class="nav-img"></div></a>

    <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="service-appointmentpage.php">Services</a>
        <a href="about-page.php">About Us</a>
        <a href="contact.php">Contact Us</a>
    </div>

    <!-- Right Side -->
    <div class="nav-right">
        <div class="nav-login">
            <a href="login-page.php">Login</a>
        </div>
        <a href="admin-dashboard.php" class="admin-link">Admin</a>
    </div>
</div>

<!-- Contact Heading -->
<div class="contact-heading">
    <h1>Contact Us</h1>
    <p>
        We'd love to hear from you! Whether you have questions about our bikes,
        need assistance with booking a service appointment, or want more
        information about our showroom, our team is always ready to help.
        Get in touch with us using the contact details or send us a message.
    </p>
</div>

<!-- Contact Section -->
<div class="contact-container">

    <!-- Left Side -->
    <div class="contact-info">
        <h2>Contact Information</h2>

        <div class="info-box">
            <i class="fa-solid fa-location-dot"></i>
            <div>
                <h3>Address</h3>
                <p>
                    BikeEase Motors<br>
                    FC Road, Shivajinagar,<br>
                    Pune, Maharashtra - 411005
                </p>
            </div>
        </div>

        <div class="info-box">
            <i class="fa-solid fa-phone"></i>
            <div>
                <h3>Phone</h3>
                <p>
                    +91 98765 43210<br>
                    +91 91234 56789
                </p>
            </div>
        </div>

        <div class="info-box">
            <i class="fa-solid fa-envelope"></i>
            <div>
                <h3>Email</h3>
                <p>
                    support@bikeeasemotors.com<br>
                    info@bikeeasemotors.com
                </p>
            </div>
        </div>

        <div class="info-box">
            <i class="fa-solid fa-clock"></i>
            <div>
                <h3>Working Hours</h3>
                <p>
                    Monday - Saturday<br>
                    9:00 AM - 7:00 PM<br><br>
                    Sunday<br>
                    10:00 AM - 4:00 PM
                </p>
            </div>
        </div>
    </div>

    <!-- Right Side Form -->
    <div class="contact-form">
        <h2>Send Us a Message .</h2>

        <?php if (!empty($responseMessage)): ?>
            <p style="color: green; font-weight: bold; margin-bottom: 15px;">
                <?php echo htmlspecialchars($responseMessage); ?>
            </p>
        <?php endif; ?>

        <form method="POST" action="contact.php">
            <input type="text" name="full_name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="text" name="subject" placeholder="Subject" required>
            <textarea name="message" placeholder="Write your message" required></textarea>
            <button type="submit">Send Message</button>
        </form>
    </div>

</div>

</body>
</html>