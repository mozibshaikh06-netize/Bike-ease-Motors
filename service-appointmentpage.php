
<?php

require_once "db.php";


// =======================================
// SAVE APPOINTMENT TO DATABASE
// =======================================

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $full_name = $_POST["fullname"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $company = $_POST["company"];
    $model = $_POST["model"];
    $bike_number = $_POST["bike_number"];
    $date = $_POST["date"];
    $time = $_POST["time"];

    $services = $_POST["services"];
    $total_price = $_POST["total_price"];
    $total_time = $_POST["total_time"];


    // Insert appointment

    $sql = "INSERT INTO service_appointments
            (
                full_name,
                email,
                phone,
                company,
                model,
                bike_number,
                appointment_date,
                appointment_time,
                services,
                total_price,
                total_time
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";


    $stmt = $conn->prepare($sql);


    $stmt->bind_param(
        "sssssssssdi",
        $full_name,
        $email,
        $phone,
        $company,
        $model,
        $bike_number,
        $date,
        $time,
        $services,
        $total_price,
        $total_time
    );


    if ($stmt->execute()) {

        echo "<script>

                alert('Appointment Booked Successfully!');

                window.location.href='service-appoinmentpage.php';

              </script>";

        exit();

    } else {

        echo "<script>

                alert('Something went wrong. Please try again.');

              </script>";
    }


    $stmt->close();
}

?>


<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Book Appointment | BikeEase Motors</title>


    <link rel="stylesheet"
          href="service-appointmentpage.css">

    <link rel="stylesheet"
          href="style.css">


    <!-- Font Awesome Icons -->

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

</head>


<body>


<!-- =======================================
     NAVBAR
======================================= -->

<div class="navbar">

    <div class="nav-img"></div>


    <div class="nav-links">

        <a href="index.php">Home</a>

        <a href="service-appoinmentpage.php">Services</a>

        <a href="about-page.php">About Us</a>

        <a href="contact.php">Contact Us</a>

    </div>


    <!-- Right Side -->

    <div class="nav-right">

        <div class="nav-login">

            <a href="login-page.php">Login</a>

        </div>


        <a href="admin-dashboard.php"
           class="admin-link">

            Admin

        </a>

    </div>

</div>



<!-- =======================================
     MAIN CONTAINER
======================================= -->

<form id="appointmentForm"
      method="POST"
      action="service-appoinmentpage.php">


<div class="main-container">


    <!-- ===================================
         PAGE HEADING
    ==================================== -->

    <div class="page-heading">

        <h1>Book Your Service Appointment</h1>

        <p>

            Fill in your details below and select the services you need.
            Our certified mechanics will take care of the rest.

        </p>

    </div>



    <!-- ===================================
         CUSTOMER DETAILS
    ==================================== -->

    <div class="form-box">

        <h2>Customer Details</h2>


        <div class="form-grid">


            <!-- Full Name -->

            <div class="input-box">

                <label>Full Name</label>

                <input
                    type="text"
                    name="fullname"
                    id="fullname"
                    placeholder="Enter your full name">

            </div>



            <!-- Email -->

            <div class="input-box">

                <label>Email Address</label>

                <input
                    type="email"
                    name="email"
                    id="email"
                    placeholder="Enter your email">

            </div>



            <!-- Phone -->

            <div class="input-box">

                <label>Phone Number</label>

                <input
                    type="tel"
                    name="phone"
                    id="phone"
                    placeholder="Enter phone number">

            </div>



            <!-- Bike Company -->

            <div class="input-box">

                <label>Bike Company</label>

                <select
                    name="company"
                    id="company">

                    <option>Select Company</option>

                    <option>Honda</option>

                    <option>Hero</option>

                    <option>TVS</option>

                    <option>Bajaj</option>

                    <option>Yamaha</option>

                    <option>Suzuki</option>

                    <option>KTM</option>

                    <option>Royal Enfield</option>

                </select>

            </div>



            <!-- Bike Model -->

            <div class="input-box">

                <label>Bike Model</label>

                <input
                    type="text"
                    name="model"
                    id="model"
                    placeholder="Enter Bike Model">

            </div>



            <!-- Bike Number -->

            <div class="input-box">

                <label>Bike Registration Number</label>

                <input
                    type="text"
                    name="bike_number"
                    id="bike_number"
                    placeholder="MH12AB1234">

            </div>



            <!-- Appointment Date -->

            <div class="input-box">

                <label>Select Appointment Date</label>

                <input
                    type="date"
                    name="date"
                    id="date">

            </div>



            <!-- Time Slot -->

            <div class="input-box">

                <label>Select Time Slot</label>

                <select
                    name="time"
                    id="time">

                    <option>Select Time</option>

                    <option>09:00 AM - 10:00 AM</option>

                    <option>10:00 AM - 11:00 AM</option>

                    <option>11:00 AM - 12:00 PM</option>

                    <option>12:00 PM - 01:00 PM</option>

                    <option>02:00 PM - 03:00 PM</option>

                    <option>03:00 PM - 04:00 PM</option>

                    <option>04:00 PM - 05:00 PM</option>

                    <option>05:00 PM - 06:00 PM</option>

                </select>

            </div>


        </div>

    </div>



    <!-- ===================================
         SERVICES SECTION
    ==================================== -->

    <div class="service-section">

        <h2>Select Services</h2>

        <p>

            Choose one or more services for your bike.
            Service price and estimated time are shown below each service.

        </p>


        <div class="service-grid">


            <!-- =================================
                 LEFT COLUMN
            ================================== -->

            <div class="service-column">


                <!-- Service 1 -->

                <div class="service-card">

                    <input
                        type="checkbox"
                        name="service[]"
                        value="General Bike Service">

                    <div class="service-info">

                        <h3>General Bike Service</h3>

                        <p>Price : ₹1200</p>

                        <small>
                            Estimated Time : 150 Minutes
                        </small>

                    </div>

                </div>



                <!-- Service 2 -->

                <div class="service-card">

                    <input
                        type="checkbox"
                        name="service[]"
                        value="Engine Oil Change">

                    <div class="service-info">

                        <h3>Engine Oil Change</h3>

                        <p>Price : ₹500</p>

                        <small>
                            Estimated Time : 30 Minutes
                        </small>

                    </div>

                </div>



                <!-- Service 3 -->

                <div class="service-card">

                    <input
                        type="checkbox"
                        name="service[]"
                        value="Bike Wash">

                    <div class="service-info">

                        <h3>Bike Wash</h3>

                        <p>Price : ₹200</p>

                        <small>
                            Estimated Time : 20 Minutes
                        </small>

                    </div>

                </div>



                <!-- Service 4 -->

                <div class="service-card">

                    <input
                        type="checkbox"
                        name="service[]"
                        value="Brake Adjustment">

                    <div class="service-info">

                        <h3>Brake Adjustment</h3>

                        <p>Price : ₹200</p>

                        <small>
                            Estimated Time : 20 Minutes
                        </small>

                    </div>

                </div>



                <!-- Service 5 -->

                <div class="service-card">

                    <input
                        type="checkbox"
                        name="service[]"
                        value="Air Filter Cleaning">

                    <div class="service-info">

                        <h3>Air Filter Cleaning</h3>

                        <p>Price : ₹150</p>

                        <small>
                            Estimated Time : 20 Minutes
                        </small>

                    </div>

                </div>



                <!-- Service 6 -->

                <div class="service-card">

                    <input
                        type="checkbox"
                        name="service[]"
                        value="Tyre Replacement">

                    <div class="service-info">

                        <h3>Tyre Replacement</h3>

                        <p>Price : ₹2500</p>

                        <small>
                            Estimated Time : 60 Minutes
                        </small>

                    </div>

                </div>



                <!-- Service 7 -->

                <div class="service-card">

                    <input
                        type="checkbox"
                        name="service[]"
                        value="Battery Replacement">

                    <div class="service-info">

                        <h3>Battery Replacement</h3>

                        <p>Price : ₹2000</p>

                        <small>
                            Estimated Time : 30 Minutes
                        </small>

                    </div>

                </div>


            </div>



            <!-- =================================
                 RIGHT COLUMN
            ================================== -->

            <div class="service-column">


                <!-- Service 8 -->

                <div class="service-card">

                    <input
                        type="checkbox"
                        name="service[]"
                        value="Chain Cleaning">

                    <div class="service-info">

                        <h3>
                            Chain Cleaning & Lubrication
                        </h3>

                        <p>Price : ₹150</p>

                        <small>
                            Estimated Time : 20 Minutes
                        </small>

                    </div>

                </div>



                <!-- Service 9 -->

                <div class="service-card">

                    <input
                        type="checkbox"
                        name="service[]"
                        value="Brake Pad Replacement">

                    <div class="service-info">

                        <h3>Brake Pad Replacement</h3>

                        <p>Price : ₹700</p>

                        <small>
                            Estimated Time : 45 Minutes
                        </small>

                    </div>

                </div>



                <!-- Service 10 -->

                <div class="service-card">

                    <input
                        type="checkbox"
                        name="service[]"
                        value="Spark Plug Replacement">

                    <div class="service-info">

                        <h3>Spark Plug Replacement</h3>

                        <p>Price : ₹250</p>

                        <small>
                            Estimated Time : 15 Minutes
                        </small>

                    </div>

                </div>



                <!-- Service 11 -->

                <div class="service-card">

                    <input
                        type="checkbox"
                        name="service[]"
                        value="Tyre Puncture Repair">

                    <div class="service-info">

                        <h3>Tyre Puncture Repair</h3>

                        <p>Price : ₹150</p>

                        <small>
                            Estimated Time : 30 Minutes
                        </small>

                    </div>

                </div>



                <!-- Service 12 -->

                <div class="service-card">

                    <input
                        type="checkbox"
                        name="service[]"
                        value="Battery Check">

                    <div class="service-info">

                        <h3>Battery Check</h3>

                        <p>Price : ₹100</p>

                        <small>
                            Estimated Time : 10 Minutes
                        </small>

                    </div>

                </div>



                <!-- Service 13 -->

                <div class="service-card">

                    <input
                        type="checkbox"
                        name="service[]"
                        value="Clutch Adjustment">

                    <div class="service-info">

                        <h3>Clutch Adjustment</h3>

                        <p>Price : ₹200</p>

                        <small>
                            Estimated Time : 20 Minutes
                        </small>

                    </div>

                </div>



                <!-- Service 14 -->

                <div class="service-card">

                    <input
                        type="checkbox"
                        name="service[]"
                        value="Engine Tuning">

                    <div class="service-info">

                        <h3>Engine Tuning</h3>

                        <p>Price : ₹700</p>

                        <small>
                            Estimated Time : 60 Minutes
                        </small>

                    </div>

                </div>


            </div>

        </div>

    </div>



    <!-- ===================================
         BOOKING SUMMARY
    ==================================== -->

    <div class="summary-box">

        <h2>Booking Summary</h2>


        <div class="summary-row">

            <span>Total Selected Services</span>

            <span id="serviceCount">0</span>

        </div>


        <div class="summary-row">

            <span>Estimated Service Time</span>

            <span id="totalTime">
                0 Minutes
            </span>

        </div>


        <div class="summary-row total-price">

            <span>Total Service Cost</span>

            <span id="totalPrice">
                ₹0
            </span>

        </div>


        <button
            type="button"
            class="confirm-btn">

            Confirm Appointment

        </button>


    </div>


</div>

</form>



<script src="service-appoinmentpage.js"></script>


</body>

</html>


