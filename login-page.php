```php
<?php
session_start();
require_once "db.php";

$login_error = "";
$signup_error = "";
$signup_success = "";

// Decide which form should be visible
$show_signup = false;

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $action = $_POST["action"] ?? "";

    // =====================================================
    // SIGN UP
    // =====================================================
    if ($action === "signup") {

        $show_signup = true;

        $full_name = trim($_POST["full_name"] ?? "");
        $email     = trim($_POST["email"] ?? "");
        $password  = $_POST["password"] ?? "";

        // Basic validation
        if ($full_name === "" || $email === "" || $password === "") {

            $signup_error = "All signup fields are required.";

        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $signup_error = "Please enter a valid email address.";

        } elseif (strlen($password) < 6) {

            $signup_error = "Password must be at least 6 characters.";

        } else {

            // Check whether email already ex
            $check_stmt = $conn->prepare(
                "SELECT id FROM users WHERE email = ?"
            );

            if (!$check_stmt) {

                $signup_error = "Database error. Please try again.";

            } else {

                $check_stmt->bind_param("s", $email);
                $check_stmt->execute();
                $check_stmt->store_result();

                if ($check_stmt->num_rows > 0) {

                    $signup_error = "Account with this email already exists.";

                } else {

                    // Hash password
                    $hashed_password = password_hash(
                        $password,
                        PASSWORD_DEFAULT
                    );

                    // Insert new user
                    $stmt = $conn->prepare(
                        "INSERT INTO users (full_name, email, password)
                         VALUES (?, ?, ?)"
                    );

                    if (!$stmt) {

                        $signup_error = "Database error. Please try again.";

                    } else {

                        $stmt->bind_param(
                            "sss",
                            $full_name,
                            $email,
                            $hashed_password
                        );

                        if ($stmt->execute()) {

                            $signup_success =
                                "Account created successfully! Please log in.";

                        } else {

                            $signup_error =
                                "Registration failed. Please try again.";
                        }

                        $stmt->close();
                    }
                }

                $check_stmt->close();
            }
        }
    }

    // =====================================================
    // LOGIN
    // =====================================================
    elseif ($action === "login") {

        $email    = trim($_POST["email"] ?? "");
        $password = $_POST["password"] ?? "";

        if ($email === "" || $password === "") {

            $login_error = "Please fill in all fields.";

        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $login_error = "Please enter a valid email address.";

        } else {

            // Find user
            $stmt = $conn->prepare(
                "SELECT id, full_name, email, password
                 FROM users
                 WHERE email = ?"
            );

            if (!$stmt) {

                $login_error = "Database error. Please try again.";

            } else {

                $stmt->bind_param("s", $email);
                $stmt->execute();

                $result = $stmt->get_result();

                if ($user = $result->fetch_assoc()) {

                    // Check password
                    if (password_verify($password, $user["password"])) {

                        // Login successful
                        $_SESSION["user_id"]    = $user["id"];
                        $_SESSION["user_name"]  = $user["full_name"];
                        $_SESSION["user_email"] = $user["email"];

                        // Redirect to profile
                        header("Location: profile.php");
                        exit();

                    } else {

                        $login_error = "Incorrect password.";
                    }

                } else {

                    $login_error = "No account found with this email.";
                }

                $stmt->close();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>BikeEase Motors | Login & Sign Up</title>

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="login-page.css">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>

        /* ================================
           LOGIN / SIGNUP TOGGLE
        ================================= */

        .auth-toggle {
            display: flex;
            justify-content: center;
            margin-bottom: 25px;
            background: #f0f0f0;
            border-radius: 8px;
            padding: 5px;
        }

        .toggle-btn {
            flex: 1;
            padding: 12px;
            border: none;
            background: transparent;
            font-size: 16px;
            font-weight: bold;
            color: #666;
            cursor: pointer;
            border-radius: 6px;
            transition: 0.3s;
        }

        .toggle-btn.active {
            background: #ff6b00;
            color: white;
        }

        /* ================================
           MESSAGES
        ================================= */

        .alert-msg {
            font-size: 15px;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .alert-error {
            color: #d9534f;
        }

        .alert-success {
            color: #5cb85c;
        }

    </style>

</head>

<body>

    <!-- ================================
         NAVBAR
    ================================= -->

    <div class="navbar">

        <a href="index.php">
            <div class="nav-img"></div>
        </a>

        <div class="nav-links">

            <a href="index.php">Home</a>

            <a href="service-appoinmentpage.php">
                Services
            </a>

            <a href="about-page.php">
                About Us
            </a>

            <a href="contact.php">
                Contact Us
            </a>

        </div>

        <div class="nav-right">

            <div class="nav-login">
                <a href="login-page.php">
                    Login
                </a>
            </div>

            <a href="admin-dashboard.php"
               class="admin-link">
                Admin
            </a>

        </div>

    </div>


    <!-- ================================
         LOGIN / SIGNUP CONTAINER
    ================================= -->

    <div class="login-container">

        <div class="login-box">

            <!-- Toggle Buttons -->

            <div class="auth-toggle">

                <button
                    type="button"
                    class="toggle-btn <?php echo !$show_signup ? 'active' : ''; ?>"
                    id="loginTab">

                    Login

                </button>

                <button
                    type="button"
                    class="toggle-btn <?php echo $show_signup ? 'active' : ''; ?>"
                    id="signupTab">

                    Sign Up

                </button>

            </div>


            <!-- ================================
                 LOGIN SECTION
            ================================= -->

            <div
                id="loginSection"
                style="<?php echo $show_signup ? 'display:none;' : 'display:block;'; ?>"
            >

                <h2>Login</h2>

                <p>
                    Welcome back! Please login to your account.
                </p>

                <?php if ($login_error !== ""): ?>

                    <p class="alert-msg alert-error">
                        <?php echo htmlspecialchars($login_error); ?>
                    </p>

                <?php endif; ?>


                <form
                    class="login-form"
                    method="POST"
                    action="login-page.php"
                >

                    <input
                        type="hidden"
                        name="action"
                        value="login"
                    >

                    <input
                        type="email"
                        name="email"
                        placeholder="Email Address"
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

            </div>


            <!-- ================================
                 SIGNUP SECTION
            ================================= -->

            <div
                id="signupSection"
                style="<?php echo $show_signup ? 'display:block;' : 'display:none;'; ?>"
            >

                <h2>Sign Up</h2>

                <p>
                    Create an account to manage your bookings and profile.
                </p>


                <?php if ($signup_error !== ""): ?>

                    <p class="alert-msg alert-error">
                        <?php echo htmlspecialchars($signup_error); ?>
                    </p>

                <?php endif; ?>


                <?php if ($signup_success !== ""): ?>

                    <p class="alert-msg alert-success">
                        <?php echo htmlspecialchars($signup_success); ?>
                    </p>

                <?php endif; ?>


                <form
                    class="login-form"
                    method="POST"
                    action="login-page.php"
                >

                    <input
                        type="hidden"
                        name="action"
                        value="signup"
                    >

                    <input
                        type="text"
                        name="full_name"
                        placeholder="Full Name"
                        required
                    >

                    <input
                        type="email"
                        name="email"
                        placeholder="Email Address"
                        required
                    >

                    <input
                        type="password"
                        name="password"
                        placeholder="Password (minimum 6 characters)"
                        minlength="6"
                        required
                    >

                    <button type="submit">
                        Create Account
                    </button>

                </form>

            </div>

        </div>

    </div>


    <!-- ================================
         TOGGLE SCRIPT
    ================================= -->

    <script>

        const loginTab = document.getElementById("loginTab");
        const signupTab = document.getElementById("signupTab");

        const loginSection =
            document.getElementById("loginSection");

        const signupSection =
            document.getElementById("signupSection");


        // Show Login
        loginTab.addEventListener("click", function () {

            loginTab.classList.add("active");
            signupTab.classList.remove("active");

            loginSection.style.display = "block";
            signupSection.style.display = "none";

        });


        // Show Signup
        signupTab.addEventListener("click", function () {

            signupTab.classList.add("active");
            loginTab.classList.remove("active");

            signupSection.style.display = "block";
            loginSection.style.display = "none";

        });

    </script>

</body>

</html>
```
