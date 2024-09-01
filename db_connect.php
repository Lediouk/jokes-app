<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Fetch environment variables
$host = getenv('DB_HOST');
$port = getenv('DB_PORT');
$username = getenv('DB_USER');
$user_pass = getenv('DB_PASS');
$database_in_use = getenv('DB_NAME');

// Path to SSL certificate file
$ssl_cert = 'C:\\MAMP\\htdocs\\jokes-part2\\certs\\BaltimoreCyberTrustRoot.crt.pem'; // Update this path

$mysqli = new mysqli($host, $username, $user_pass, $database_in_use, $port);

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
