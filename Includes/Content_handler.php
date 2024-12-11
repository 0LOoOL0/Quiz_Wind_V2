<!-- quiz_content.php -->
<?php
// Check if the quiz ID was posted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quiz_id'])) {
    $_SESSION['selected_quiz'] = $_POST['quiz_id']; // Store the quiz ID in the session
    // Redirect to the page where you actually display the quiz content
    header("Location: quiz_content.php"); // Change to your quiz content page
    exit();
} else {
    // Handle the case where no quiz ID was provided
    header("Location: quizzes_page.php");
    exit();
}
?>