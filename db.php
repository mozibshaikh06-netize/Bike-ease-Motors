<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Matches the exact database name from your screenshot
    $conn = new mysqli("localhost", "root", "", "bike-ease_motors"); 
    $conn->set_charset("utf8mb4");
} catch (Exception $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>