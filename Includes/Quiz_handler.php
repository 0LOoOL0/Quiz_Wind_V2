<?php

require_once 'Quiz.php';
require_once 'Question.php';
require_once 'Option.php'; 
require_once 'Chapter.php'; 

$subjectId = isset($_GET['subject_id']) ? intval($_GET['subject_id']) : null;

$quizId = isset($_GET['quiz_id']) ? intval($_GET['quiz_id']) : null;
$subjectId = $_POST['subject_id'] ?? null;

$userId = $_SESSION['user_id'] ?? null;
// if ($subjectId === null) {
//     die("Invalid subject ID creating quiz handler." );
// }


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add-quiz'])) {

    
    $subject_id = $_POST['subject_id'] ?? null;
    try {
        // Initialize quiz object
        $quiz = new Quiz($db);
        $quiz->setQuizTitle($_POST['quiz_title']);
        $quiz->setQuizText($_POST['quiz_text']); 
        $quiz->setChapterId($_POST['chapter_id']);
        $quiz->setTimer($_POST['timer']);
        $quiz->setSubjectId($_POST['subject_id']);
        $quiz->setUserId($_POST['user_id']);

        // Create quiz and check for success
        $newQuizId = $quiz->createQuiz($_POST['subject_id']);

        if ($newQuizId) {
            // Initialize obtained score
            $totalObtainedScore = 0; 
            
            // Check if questions are provided
            if (isset($_POST['questions']) && is_array($_POST['questions'])) {
                foreach ($_POST['questions'] as $questionData) {
                    if (!empty($questionData['question_text']) && isset($questionData['score'])) {
                        $question = new Question($db);
                        $question->setQuestionText($questionData['question_text']);
                        $question->setScore($questionData['score']);
                        $question->setQuizId($newQuizId);
                        $questionId = $question->createQuestion();

                        // Check if question was created successfully
                        if ($questionId) {
                            $totalObtainedScore += $questionData['score'];
                            
                            // Handle options if provided
                            if (isset($questionData['options']) && is_array($questionData['options'])) {
                                foreach ($questionData['options'] as $optionData) {
                                    if (!empty($optionData['option_text'])) {
                                        $option = new Option($db);
                                        $option->setOptionText($optionData['option_text']);
                                        $option->setQuestionId($questionId); // Link option to question

                                        // Check if the option is correct
                                        $option->setIsCorrect(isset($optionData['is_correct']) ? (bool)$optionData['is_correct'] : false);
                                        
                                        $option->createOption(); // Save the option
                                    }
                                }
                            }
                        }
                    }
                }
            }

            // Redirect to quizzes page
            header("Location: ../quizzes_page.php?subject_id=" . htmlspecialchars($subjectId));
            exit();
        } else {
            echo "<p style='color: red;'>Failed to create quiz.</p>";
        }
    } catch (Exception $ex) {
        echo "<p style='color: red;'>Error: " . htmlspecialchars($ex->getMessage()) . "</p>";
    }
}





?>