<?php
require_once "db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $full_name = $_POST["full_name"] ?? "";
    $email     = $_POST["email"] ?? "";
    $bike_name = $_POST["bike_name"] ?? "";
    $bike_model= $_POST["bike_model"] ?? "";
    $phone     = $_POST["phone"] ?? "";
    $location  = $_POST["location"] ?? "";

    $stmt = $conn->prepare(
        "INSERT INTO test_rides
        (full_name, email, bike_name, bike_model, phone, location)
        VALUES (?, ?, ?, ?, ?, ?)"
    );

    $stmt->bind_param(
        "ssssss",
        $full_name,
        $email,
        $bike_name,
        $bike_model,
        $phone,
        $location
    );

    if ($stmt->execute()) {
        $message = "Test ride request submitted successfully!";
    } else {
        $message = "Something went wrong. Please try again.";
    }

    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="test-ride-page.css">
    <title>test-ride-page</title>
</head>
<body>
     <div class="navbar">

    <div class="nav-img"></div>

    <div class="nav-links">

        <a href="index.php">Home</a>
        <a href="service-appointmentpage.php">Services</a>
        <a href="about-page.php">About Us</a>
        <a href="contact.php">Contact Us</a>

    </div>

    <!-- Right Side -->
    <div class="nav-right">

        <div class="nav-login">
            <a href="login-page.html">Login</a>
        </div>
        <a href="admin-login.php" class="admin-link">Admin</a>

    </div>

</div>

<!-- form ====================================================== -->

<div class="form-box-container">

    <!-- Left Side Image -->
    <div class="form-box-left">
        <div class="test-ride-left-img-one"></div>
        <div class="test-ride-left-img-two"></div>
    </div>

    <!-- Right Side Form -->
    <div class="form-box-right">

        <h1>Book a Test Ride</h1>

        <p>
            To book your test ride now, kindly fill in your information below.
        </p>

<?php if (!empty($message)): ?>
    <p class="success-message"><?php echo htmlspecialchars($message); ?></p>
<?php endif; ?>

<form method="POST" class="test-ride-form">
        

            <input type="text" name="full_name" placeholder="Full Name" required>
<input type="email" name="email" placeholder="Email Address" required>
<input type="text" name="bike_name" placeholder="Bike Name" required>
<input type="text" name="bike_model" placeholder="Bike Model" required>
<input type="tel" name="phone" placeholder="Phone Number" required>
<input type="text" name="location" placeholder="Location" required>

<div class="checkbox-section">
    <input type="checkbox" id="agree" name="agree" required>
    <label for="agree">
        I agree to the Privacy Policy, Terms & Conditions and authorize
        BikeEase Motors to contact me through phone, SMS, WhatsApp,
        email and other communication channels.
    </label>

</div>

<button type="submit">Submit</button>

            

        </form>

    </div>

</div>

</body>
</html>