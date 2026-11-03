<?php
session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = $_POST["username"] ?? "";
    $password = $_POST["password"] ?? "";

    if ($username === "admin" && $password === "admin123") {

        $_SESSION["admin_logged_in"] = true;
        $_SESSION["admin_username"] = "Admin";

        header("Location: admin-dashboard.php");
        exit();

    } else {

        $error = "Invalid username or password .";

    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Admin Login - BikeEase Motors</title>
<link rel="stylesheet"
      href="admin-login.css">   

</head>

<body class="admin-login-page">

    <div class="admin-login-box">

        <div class="admin-login-icon">
            🏍️
        </div>

        <h1>BikeEase Motors</h1>

        <h2>Admin Login</h2>

        <?php if (!empty($error)): ?>

            <p class="admin-error">
                <?php echo htmlspecialchars($error); ?>
            </p>

        <?php endif; ?>

        <form method="POST">

            <input
                type="text"
                name="username"
                placeholder="Admin Username"
                required
            >

            <input
                type="password"
                name="password"
                placeholder="Password"
                required
            >

            <button type="submit">
                Login
            </button>

        </form>

        <a href="index.php"
           class="back-home">
            ← Back to Home
        </a>

    </div>

</body>

</html>