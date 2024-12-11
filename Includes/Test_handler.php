<?php
// Database connection
require_once 'db_connection.php';  // Adjust path as necessary

// Get quiz ID from the URL
$quizId = isset($_GET['quiz_id']) ? intval($_GET['quiz_id']) : null;

if ($quizId === null || $quizId <= 0) {
    die("Invalid quiz ID.");
}

// Fetch questions and options
$questions = [];
$query = $db->prepare("SELECT * FROM questions WHERE quiz_id = :quiz_id");
$query->execute([':quiz_id' => $quizId]);
$questions = $query->fetchAll(PDO::FETCH_ASSOC);

// Fetch options for each question
foreach ($questions as &$question) {
    $optionsQuery = $db->prepare("SELECT * FROM options WHERE question_id = :question_id");
    $optionsQuery->execute([':question_id' => $question['id']]); // Assuming 'id' is the primary key of the questions table
    $question['options'] = $optionsQuery->fetchAll(PDO::FETCH_ASSOC);
}
?>