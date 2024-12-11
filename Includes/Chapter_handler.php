<?php
require_once 'Chapter.php';
require_once 'Subject.php'; 

$newChapter = new Chapter($db);

// Get the subject_id from the URL
$subject_id = isset($_GET['subject_id']) ? intval($_GET['subject_id']) : null;

if ($subject_id === null) {
    die("Invalid subject ID chapter handler.");
}

// Fetch subject details
$subject = new Subject($db);
$subjectDetails = $subject->getSubjectById($subject_id);

if (!$subjectDetails) {
    die("Subject not found.");
}

$subjectName = htmlspecialchars($subjectDetails['subject_name']);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitted'])) {
    try {
        $chapter = new Chapter($db);
        $chapter->setChapterTitle($_POST['chapter_title']);
        $chapter->setSubjectId($subject_id); // Use the subject_id from the URL

        // Create the chapter
        $newChapterId = $chapter->createChapter();

        if ($newChapterId) {
            header("Location: ../quizzes_page.php?subject_id=" . htmlspecialchars($subject_id));
            exit();
        } else {
            echo "<p style='color: red;'>Failed to create chapter.</p>";
        }
    } catch (Exception $ex) {
        echo "<p style='color: red;'>Error: " . htmlspecialchars($ex->getMessage()) . "</p>";
    }
}

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