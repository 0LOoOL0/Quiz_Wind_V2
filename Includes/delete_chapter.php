<?php
require_once 'Chapter.php';

$chapter = new Chapter($db);
$subjectId = isset($_GET['subject_id']) ? intval($_GET['subject_id']) : null;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['chapter_id'])) {
    
    $chapterId = intval($_POST['chapter_id']); // Get the quiz ID
    $subjectId = $_POST['subject_id'] ?? null;


    $result = $chapter->deleteChapter($chapterId);

    if ($result) {
        // Redirect or display a success message
        header("Location: ../quizzes_page.php?subject_id=" . htmlspecialchars($subjectId));
        exit();
    } else {
        // Handle failure
        echo "Failed to delete quiz.";
    }
}



