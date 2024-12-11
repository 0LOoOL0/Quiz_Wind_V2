<?php

require_once 'Quiz.php';
require_once 'Question.php';
require_once 'Option.php'; 
require_once 'Chapter.php'; 

// $subjectId = isset($_GET['subject_id']) ? intval($_GET['subject_id']) : null;

// if ($subjectId === null) {
//     die("Invalid subject ID creating quiz handler." );
// }


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add-quiz'])) {
    try {
        // Initialize quiz object
        $quiz = new Quiz($db);
        $quiz->setQuizTitle($_POST['quiz_title']);
        $quiz->setQuizText($_POST['quiz_text']); 
        $quiz->setChapterId($_POST['chapter_id']);
        $quiz->setTimer($_POST['timer']);
        $quiz->setSubjectId($_POST['subject_id']);

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
//list all chapters



// deleting chapter

// if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['chapter_id'])) {
//     $chapterId = intval($_POST['chapter_id']);

//     try {
//         $chapter = new Chapter($db);
//         $chapter->setChapterId($chapterId);
//         $chapter = $chapter->deleteChapter();

//         if ($result) {
//             // $_SESSION['message'] = 'User deleted successfully';
//             header("Location: ../quizzes_page.php?subject_id=" . htmlspecialchars($subject_id));
//             exit();
//         } else {
//             echo "Failed to delete chapter.";
//         }
//     } catch (Exception $ex) {
//         echo "Error: " . htmlspecialchars($ex->getMessage());
//     }

//     if (isset($_GET['message'])) {
//         echo "<p style='color: green;'>" . htmlspecialchars($_GET['message']) . "</p>";
//     }
// }


?>