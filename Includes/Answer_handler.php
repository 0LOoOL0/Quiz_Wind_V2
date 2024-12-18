<?php

//include 'Database.php'; // Include your database connection
require_once 'Answer.php'; // Include your QuizManager class
require_once 'Attempt.php'; // Include your QuizManager class
//require_once 'Attempt.php';

$quizAttemptManager = new Answer($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve user ID and quiz ID from the POST data
    $userId = htmlspecialchars($_POST['user_id']);
    $quizId = htmlspecialchars($_POST['quiz_id']);
    
    // Prepare an array to store answers
    $answers = [];

    // Loop through each question's answers
    foreach ($_POST['answers'] as $questionId => $answerData) {
        $selectedOptionId = htmlspecialchars($answerData['selected_option_id']);
        
        // Assuming a default score of 1.00
        $score = 1.00; // Replace with actual score retrieval logic if needed

        // Add to answers array
        $answers[] = [
            'question_id' => $questionId,
            'selected_option_id' => $selectedOptionId,
            'score' => $score
        ];
    }

    $answer = new Answer($db);

    //$questions = new Answer($db);
    $totalQuestions = $answer->countQuestionsByQuizId($quizId);
    $correctQuestions = $answer->countCorrectOptionsByQuizId($quizId);
    $percentageCorrect = ((double)$correctQuestions / (double)$totalQuestions) * 100;

    
    //$totalScore = $quizAttemptManager->calculateTotalScore($answers);

    // // Determine the attempt number
    $attemptNumber = $quizAttemptManager->calculateAttempts($userId, $quizId) + 1;

    // Save the new attempt
    $quizAttemptManager->saveAttempt($userId, $quizId, $attemptNumber, $percentageCorrect);


    // Create an instance of QuizManager and pass the database connection
    ;

    // Save the answers using the saveAnswers method
    if ($answer->saveAnswers($userId, $quizId, $answers)) {
        
        header("Location: ../result_page.php?quiz_id=" . urlencode($quizId));
        exit();
    } else {
        echo "Failed to save answers.";
    }
} else {
    //echo "Invalid request method.";
}
?>
