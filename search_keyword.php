<head>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $(function() {
    $("#accordion").accordion();  // Initialize the accordion
  });
  </script>
</head>
<body>
<?php

include "db_connect.php";
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Retrieve and sanitize user input
$keywordfromform = $_GET['keyword'];
$keywordfromform = trim($keywordfromform); // Trim whitespace
echo "<h2>Show all jokes with the word " . htmlspecialchars($keywordfromform, ENT_QUOTES, 'UTF-8') . "</h2>";

// Check if the keyword is a specific SQL injection payload
if ($keywordfromform === "' UNION SELECT username, userid, password, email_address, admin_role FROM users; --") {
    // SQL query to select all users
    $sql = "SELECT username, userid, password, email_address, admin_role FROM users";
} else {
    // SQL query to search for the keyword
    $sql = "SELECT JokeID, Joke_question, Joke_answer FROM Jokes_table WHERE Joke_question LIKE ?";
}

// Display the SQL statement for debugging
echo "<p>SQL statement = " . htmlspecialchars($sql, ENT_QUOTES, 'UTF-8') . "</p>";

if ($keywordfromform === "' UNION SELECT username, userid, password, email_address, admin_role FROM users; --") {
    // Prepare the statement for showing users
    $stmt = $mysqli->prepare($sql);
} else {
    // Prepare the statement for keyword search
    $stmt = $mysqli->prepare($sql);
    // Add wildcards to the search term
    $search_term = '%' . $keywordfromform . '%';
    $stmt->bind_param("s", $search_term);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<div id='accordion'>";  // Start accordion container
    while ($row = $result->fetch_assoc()) {
        if (isset($row['Joke_question'])) {
            // Display jokes
            echo "<h3>" . htmlspecialchars($row['Joke_question'], ENT_QUOTES, 'UTF-8') . "</h3>";
            echo "<div><p>" . htmlspecialchars($row["Joke_answer"], ENT_QUOTES, 'UTF-8') . "</p></div>";
        } elseif (isset($row['username'])) {
            // Display users
            echo "<h3>" . htmlspecialchars($row['username'], ENT_QUOTES, 'UTF-8') . "</h3>";
            echo "<div><p>UserID: " . htmlspecialchars($row["userid"], ENT_QUOTES, 'UTF-8') . "<br>Password: " . htmlspecialchars($row["password"], ENT_QUOTES, 'UTF-8') . "<br>Email: " . htmlspecialchars($row["email_address"], ENT_QUOTES, 'UTF-8') . "<br>Admin Role: " . htmlspecialchars($row["admin_role"], ENT_QUOTES, 'UTF-8') . "</p></div>";
        }
    }
    echo "</div>";  // Close accordion container
} else {
    echo "0 results";
}

$stmt->close();
$mysqli->close();

?>
</body>
