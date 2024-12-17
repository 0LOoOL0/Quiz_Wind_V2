<?php
require_once 'Quiz.php';

$newQuiz = new Quiz($db);

//for redirect
$subject_id = isset($_GET['subject_id']) ? intval($_GET['subject_id']) : null;

if ($subject_id === null) {
    die("Invalid subject ID create quiz.");
}

$subject = new Subject($db);
$subjectDetails = $subject->getSubjectById($subject_id);

if (!$subjectDetails) {
    die("Subject not found.");
}

//deleting quiz
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['quiz_id'])) {
    
    $chapterId = intval($_POST['quiz_id']);
    $subject_id = $_POST['subject_id'] ?? null;
    
    try {
        $quiz = new Quiz($db);
        $quiz->setChapterId($chapterId);
        $result = $quiz->deleteQuiz();

        if ($result) {
            // $_SESSION['message'] = 'User deleted successfully';
            header("Location: ../quizzes_page.php?subject_id=" . htmlspecialchars($subject_id));
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


