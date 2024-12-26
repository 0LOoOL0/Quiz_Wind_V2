<?php
require_once 'Quiz.php';

$newQuiz = new Quiz($db);
$subjectId = isset($_GET['subject_id']) ? intval($_GET['subject_id']) : null;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['quiz_id'])) {
    
    $quizId = intval($_POST['quiz_id']); // Get the quiz ID
    $subjectId = $_POST['subject_id'] ?? null;

    $chapterId = intval($_POST['quiz_id']);
    $subjectId = $_POST['subject_id'] ?? null;

    // Call your delete method
    $result = $newQuiz->deleteQuiz($quizId); // Make sure this method is defined in your Quiz class

    if ($result) {
        // Redirect or display a success message
        header("Location: ../quizzes_page.php?subject_id=" . htmlspecialchars($subjectId));
        exit();
    } else {
        // Handle failure
        echo "Failed to delete quiz.";
    }
}




