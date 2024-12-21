<?php
require_once 'Quiz.php';

$newQuiz = new Quiz($db);

//for redirect
$subjectId = isset($_GET['subject_id']) ? intval($_GET['subject_id']) : null;

if ($subjectId === null) {
    die("Invalid subject ID create quiz.");
}

$subject = new Subject($db);
$subjectDetails = $subject->getSubjectById($subjectId);

if (!$subjectDetails) {
    die("Subject not found.");
}

//deleting quiz
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['quiz_id'])) {
    
    $chapterId = intval($_POST['quiz_id']);
    $subjectId = $_POST['subject_id'] ?? null;
    
    try {
        $quiz = new Quiz($db);
        $quiz->setChapterId($chapterId);
        $result = $quiz->deleteQuiz($quizId);

        if ($result) {
            // $_SESSION['message'] = 'User deleted successfully';
            header("Location: ../quizzes_page.php?subject_id=" . htmlspecialchars($subjectId));
            exit();
        } else {
            echo "Failed to delete user.";
        }
    } catch (Exception $ex) {
        echo "Error: " . htmlspecialchars($ex->getMessage());
    }

    if (isset($_GET['message'])) {
        echo "<p style='color: green;'>" . htmlspecialchars($_GET['message']) . "</p>";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['quiz_id'])) {
    
    $quizId = intval($_POST['quiz_id']); // Get the quiz ID

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

//get quizzes by chapters filter: 


