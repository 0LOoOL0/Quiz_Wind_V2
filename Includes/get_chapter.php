<?php
require_once 'Chapter.php';
require_once 'Subject.php';
require_once 'Quiz.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); // Start session to access user data

$userId = $_SESSION['user_id'] ?? null;
$userName = $_SESSION['user_name'] ?? null;
$roleId = $_SESSION['role_id'] ?? null;
$roleName = $_SESSION['role_name'] ?? null;

$chapter = new Chapter($db);

// Check if chapter_id is set in the POST request
if (isset($_POST['chapter_id'])) {
    $chapterId = intval($_POST['chapter_id']);

    // Fetch quizzes associated with the chapter
    $quiz = new Quiz($db);
    $quizByChapters = $quiz->getQuizzesByChapter($chapterId);

    if ($quizByChapters) {
        foreach ($quizByChapters as $quiz) {
            echo "<div class='sub-quiz'>
                    <h2>" . htmlspecialchars($quiz['quiz_title']) . "</h2> 
                    <h4>" . htmlspecialchars($quiz['quiz_text']) . "</h4>
                    <div class='quiz-buttons'>";
            echo "<button class='button1'>
                    <a href='rule_page.php?quiz_id=" . htmlspecialchars($quiz['quiz_id']) . "' class='button1'>Start</a>
                </button>";
            echo "</div></div>"; // Close sub-quiz div
        }
    } else {
        echo "No quizzes found for this chapter.";
    }
} else {
    echo "Chapter ID not set.";
}
function userHasPermission($roleName, $action)
{
    // Define permissions
    $permissions = [
        'Admin' => ['edit', 'delete'],
        'Teacher' => ['create', 'edit', 'delete'],
        'Student' => ['view'],
        // Add other roles as needed
    ];

    return isset($permissions[$roleName]) && in_array($action, $permissions[$roleName]);
}
