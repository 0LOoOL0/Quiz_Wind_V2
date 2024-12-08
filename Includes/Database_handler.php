<?php
require_once 'Database.php';

// Create a new instance of Database
$db = new Database('localhost', 'root', '', 'quizwind_dbv2');

//testing database
// try {
//     $sql = "SELECT * FROM users WHERE username = :username";
//     $stmt = $db->prepare($sql);

//     // Execute the statement with parameters
//     $params = [':username' => 'lulwa2'];
//     $db->execute($stmt, $params);

//     // Fetch results
//     $user = $db->fetchSingle($stmt);
//     if ($user) {
//         echo "User found: " . htmlspecialchars($user['username']);
//     } else {
//         echo "User not found.";
//     }
// } catch (Exception $e) {
//     echo "An error occurred: " . $e->getMessage();
// }
