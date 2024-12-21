<?php
require 'db_connection.php'; // Ensure your database connection is included

$chapterId = isset($_GET['chapter_id']) ? (int)$_GET['chapter_id'] : 0;

if ($chapterId <= 0) {
    echo json_encode([]); // Return an empty array if invalid
    exit;
}

$quiz = new Quiz($db); // Assuming you have a Quiz class
$quizzes = $quiz->getQuizzesByChapter($chapterId); // Fetch quizzes by chapter ID

echo json_encode($quizzes); // Return the quizzes in JSON format
?>