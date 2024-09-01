<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Modify these settings according to the account on your Azure MySQL server.
$host = "jokeys-server.mysql.database.azure.com"; // Full server name with domain
$port = "3306"; // Default MySQL port
$username = "ahbddshdku"; // Generated username
$user_pass = "#$###kdsdaSDAS"; // Replace with the actual password
$database_in_use = "jokeys-database"; // Name of your database

// Path to SSL certificate file
$ssl_cert = '/home/site/wwwroot/certs/BaltimoreCyberTrustRoot.crt.pem'; // Update this path

$mysqli = new mysqli($host, $username, $user_pass, $database_in_use, $port);

// Check if SSL certificates are needed
if ($mysqli->connect_error) {
    die("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
}

// Set SSL options
$mysqli->ssl_set(NULL, NULL, $ssl_cert, NULL, NULL);
$mysqli->real_connect($host, $username, $user_pass, $database_in_use, $port, NULL, MYSQLI_CLIENT_SSL);

if ($mysqli->connect_error) {
    die("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
}

echo $mysqli->host_info . "<br>";
?>
