<?php
// Configuration for XAMPP (default settings)
$hostname = "localhost";
$username = "root"; // Default XAMPP username
$password = "";    // Default XAMPP password (often empty)
$database = "udaan"; // Your specified database name

// 1. Create a new MySQLi connection object
$conn = new mysqli($hostname, $username, $password, $database);

// 2. Check the connection status
if ($conn->connect_error) {
    // Stop script execution and print the connection error
    die("Connection failed: " . $conn->connect_error);
}

// 3. Set the character set to ensure proper data handling (optional, but recommended)
$conn->set_charset("utf8mb4");

// Note: The global variable $conn is now available for database queries
// in any file that includes this one.
?>