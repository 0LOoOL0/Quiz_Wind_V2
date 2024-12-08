<?php

require_once 'Chapter.php';
require_once 'Subject.php'; 

// if (isset($_POST['submitted'])) {
//     try {
//     $subject = new Subject($db);
//     $subject->setSubjectName($_POST['subject_name']);
//     $subject->setSubjectText($_POST['subject_text']);
//     $subject->setAssignTo($_POST['assigned_to']);

//     $newSubjectId = $subject->createSubject();

//     if ($newSubjectId) {
//         header("Location: ../subject_page.php");
//         exit();
//     } else {
//         echo "<p style='color: red;'>Failed creating subject.</p>";
//     }
//     } catch (Exception $ex) {
//         echo "<p style='color: red;'>Error: " . htmlspecialchars($ex->getMessage()) . "</p>";
//     }
// }

$newChapter = new Chapter($db);

$subject_id = isset($_GET['subject_id']) ? intval($_GET['subject_id']) : null;

if ($subject_id === null) {
    die("Invalid subject ID.");
}

$subject = new Subject($db);
$subjectDetails = $subject->getSubjectById($subject_id);

if (!$subjectDetails) {
    die("Subject not found.");
}

$subjectName = htmlspecialchars($subjectDetails['subject_name']);


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitted'])) {
    
    try {
    $chapter = new Chapter($db);
    $chapter->setChapterTitle($_POST['chapter_title']);
    $chapter->setSubjectId($_POST['subject_id']);

    $newChapterId = $chapter->createChapter();

    if ($newChapterId) {
        header("Location: ../quizzes_page.php?subject_id=" . htmlspecialchars($subject_id));
        exit();
    } else {
        echo "<p style='color: red;'>Failed creating subject.</p>";
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