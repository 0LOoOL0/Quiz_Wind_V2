<?php
require_once 'Chapter.php';
require_once 'Subject.php'; 

$newChapter = new Chapter($db);

// Get the subject_id from the URL
$subjectId = isset($_GET['subject_id']) ? intval($_GET['subject_id']) : null;

if ($subjectId === null) {
    die("Invalid subject ID chapter handler.");
}

// Fetch subject details
$subject = new Subject($db);
$subjectDetails = $subject->getSubjectById($subjectId);

if (!$subjectDetails) {
    die("Subject not found.");
}

$subjectName = htmlspecialchars($subjectDetails['subject_name']);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitted'])) {
    try {
        $chapter = new Chapter($db);
        $chapter->setChapterTitle($_POST['chapter_title']);
        $chapter->setSubjectId($subjectId); // Use the subject_id from the URL

        // Create the chapter
        $newChapterId = $chapter->createChapter();

        if ($newChapterId) {
            header("Location: ../quizzes_page.php?subject_id=" . htmlspecialchars($subjectId));
            exit();
        } else {
            echo "<p style='color: red;'>Failed to create chapter.</p>";
        }
    } catch (Exception $ex) {
        echo "<p style='color: red;'>Error: " . htmlspecialchars($ex->getMessage()) . "</p>";
    }
}

// deleting chapter

//delete chapter
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['chapter_id'])) {
    
    $chapterId = intval($_POST['chapter_id']); // Get chapter_id from the form
    $subjectId = isset($_POST['subject_id']) ? intval($_POST['subject_id']) : 0; // Get subject_id if available

    try {
        $chapter = new Chapter($db);
        $chapter->setChapterId($chapterId); // Set the chapter ID in the Chapter object
        $result = $chapter->deleteChapter($chapterId); // Call the delete method
        
        if ($result) {
            // Redirect with success message
            header("Location: ../quizzes_page.php?subject_id=" . htmlspecialchars($subjectId) . "&message=" . urlencode('Chapter deleted successfully'));
            exit();
        } else {
            echo "Failed to delete chapter.";
        }
    } catch (Exception $ex) {
        echo "Error: " . htmlspecialchars($ex->getMessage());
    }
}

// Display any messages passed via the URL
if (isset($_GET['message'])) {
    echo "<p style='color: green;'>" . htmlspecialchars($_GET['message']) . "</p>";
}


?>