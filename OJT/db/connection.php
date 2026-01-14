<?php
// Get credentials from Environment Variables (Vercel) OR fallback to XAMPP defaults
$servername = getenv('DB_HOST') ?: "localhost";
$username   = getenv('DB_USER') ?: "root";
$password   = getenv('DB_PASS') ?: "";
$dbname     = getenv('DB_NAME') ?: "tvlstc_db";
$port       = getenv('DB_PORT') ?: "3306";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    // Only show detailed error locally, hide it in production for security
    if ($servername == "localhost") {
        die("Connection failed: " . $conn->connect_error);
    } else {
        die("Database Connection Error. Please check configuration.");
    }
}
?>