<?php

require_once 'Quiz.php';
require_once 'Question.php';
require_once 'Option.php'; 


$newQuiz = new Quiz($db);

// $subject_id = isset($_GET['subject_id']) ? intval($_GET['subject_id']) : null;

// if ($subject_id === null) {
//     die("Invalid subject ID.");
// }

// $subject = new Subject($db);
// $subjectDetails = $subject->getSubjectById($subject_id);

// if (!$subjectDetails) {
//     die("Subject not found.");
// }

//$subjectName = htmlspecialchars($subjectDetails['subject_name']);

//handler for creating new quiz

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add-quiz'])) {
    try {
        $quiz = new Quiz($db);
        $quiz->setQuizTitle($_POST['quiz_title']);
        $quiz->setQuizText($_POST['quiz_text']);
        $quiz->setChapterId($_POST['chapter_id']);
        $quiz->setTimer($_POST['timer']);

        $newQuizId = $quiz->createQuiz();

        if ($newQuizId) {
            $totalObtainedScore = 0; // Initialize obtained score
            
            foreach ($_POST['questions'] as $questionData) {
                $question = new Question($db);
                $question->setQuestionText($questionData['question_text']);
                $question->setScore($questionData['score']);
                $question->setQuizId($newQuizId);
                $question->createQuestion();

                $totalObtainedScore += $questionData['score']; // Sum obtained score
            }

            // Calculate total possible score for the quiz
            $totalPossibleScore = $quiz->calculateTotalPossibleScore($newQuizId);

            // Calculate percentage
            $percentage = $quiz->calculatePercentage($totalObtainedScore, $totalPossibleScore);

            // Update quiz with total score and percentage (add a column for percentage if needed)
            $quiz->updateScore($newQuizId, $totalObtainedScore); // Assuming you want to store obtained score
            $quiz->updateTotalScore($newQuizId, $percentage); // You might need to create this method

            header("Location: ../quizzes_page.php");
            exit();
        } else {
            echo "<p style='color: red;'>Failed creating quiz.</p>";
        }
    } catch (Exception $ex) {
        echo "<p style='color: red;'>Error: " . htmlspecialchars($ex->getMessage()) . "</p>";
    }
}

//list all chapters



// deleting chapter

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['chapter_id'])) {
    $chapterId = intval($_POST['chapter_id']);

    try {
        $chapter = new Chapter($db);
        $chapter->setChapterId($chapterId);
        $chapter = $chapter->deleteChapter();

        if ($result) {
            // $_SESSION['message'] = 'User deleted successfully';
            header("Location: ../quizzes_page.php?subject_id=" . htmlspecialchars($subject_id));
            exit();
        } else {
            echo "Failed to delete chapter.";
        }
    } catch (Exception $ex) {
        echo "Error: " . htmlspecialchars($ex->getMessage());
    }

    if (isset($_GET['message'])) {
        echo "<p style='color: green;'>" . htmlspecialchars($_GET['message']) . "</p>";
    }
}


?>