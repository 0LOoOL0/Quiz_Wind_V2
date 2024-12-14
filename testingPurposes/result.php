<?php
session_start(); // Start the session

// Check if answers are set
if (isset($_SESSION["answers"])) {
    $answers = $_SESSION["answers"];
    
    // Example correct answers
    $correctAnswers = [
        "question1" => "4",
        "question2" => "Paris"
    ];

    // Calculate score
    $score = 0;
    foreach ($answers as $key => $answer) {
        if (strtolower(trim($answer)) == strtolower(trim($correctAnswers[$key]))) {
            $score++;
        }
    }

    echo "<h1>Your Results</h1>";
    echo "You scored: $score out of " . count($correctAnswers) . "<br>";
    
    // Clear session data
    session_destroy();
} else {
    echo "No quiz answers found.";
}
?>