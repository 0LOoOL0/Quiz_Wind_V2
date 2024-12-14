<?php
session_start(); // Start the session

// Check if the quiz has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_quiz"])) {
    // Store the answers in session variables
    $_SESSION["answers"] = $_POST["answers"];
}

// Check if the results button is clicked
if (isset($_POST["view_results"])) {
    header("Location: result.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quiz</title>
</head>
<body>
    <h1>Chapter Quiz</h1>
    <form method="post">
        <label>
            Question 1: What is 2 + 2?
            <input type="text" name="answers[question1]" required>
        </label><br>

        <label>
            Question 2: What is the capital of France?
            <input type="text" name="answers[question2]" required>
        </label><br>

        <input type="submit" name="submit_quiz" value="Submit Quiz">
        <input type="submit" name="view_results" value="View Results">
    </form>
</body>
</html>