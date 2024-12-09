<?php
require_once 'Quizzes.php';

$newQuiz = new Quiz($db);

//for redirect
$subject_id = isset($_GET['subject_id']) ? intval($_GET['subject_id']) : null;
if ($subject_id === null) {
    die("Invalid subject ID.");
}

$subject = new Subject($db);
$subjectDetails = $subject->getSubjectById($subject_id);

if (!$subjectDetails) {
    die("Subject not found.");
}

//create new subject
// if (isset($_POST['submitted'])) {
//     try {
//         $subject = new Subject($db);
//         $subject->setSubjectName($_POST['subject_name']);
//         $subject->setSubjectText($_POST['subject_text']);
//         $subject->setAssignTo($_POST['assigned_to']);

//         $newSubjectId = $subject->createSubject();

//         if ($newSubjectId) {
//             header("Location: ../subject_page.php");
//             exit();
//         } else {
//             echo "<p style='color: red;'>Failed creating subject.</p>";
//         }
//     } catch (Exception $ex) {
//         echo "<p style='color: red;'>Error: " . htmlspecialchars($ex->getMessage()) . "</p>";
//     }
// }

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
