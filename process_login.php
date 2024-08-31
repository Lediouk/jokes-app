<html>
<head>

</head>
<?php 
session_start();
error_reporting(E_ALL); 
ini_set('display_errors', 1); 

include "db_connect.php";

$username = $_POST['username'];
$password = $_POST['password'];

echo "<h2>You attempted to login with " . $username . " and " . $password . "</h2>";

$sql = "SELECT userid, username, password FROM users WHERE username = '$username' AND password = '$password'";

echo "SQL = " . $sql . "<br>";

$result = $mysqli->query($sql);

if ($result->num_rows > 0) {    
    echo "Found 1 person with that username<br>";    
    $row = $result->fetch_assoc(); // Fetch the row as an associative array
    $userid = $row['userid']; // Assign the userid from the database result
    
    echo "<p>Login success</p>";         
    $_SESSION['username'] = $username;       
    $_SESSION['userid'] = $userid;    
} else {
    echo "0 results. Not logged in<br>";   
    $_SESSION = [];    
    session_destroy();
}

echo "Session variable = ";
print_r($_SESSION);

echo "<br>";

echo "<a href='index.php'>Return to main page</a>";
?>
</html>
