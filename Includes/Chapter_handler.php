<?php

require_once 'Chapter.php'; 

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

if (isset($_POST['submitted'])) {
    
    try {
    $chapter = new Chapter($db);
    $chapter->setChapterTitle($_POST['chapter_title']);
    $chapter->setSubjectId($_POST['subject_id']);

    $newChapterId = $chapter->createChapter();

    if ($newChapterId) {
        header("Location: quizzes_page.php");
        exit();
    } else {
        echo "<p style='color: red;'>Failed creating subject.</p>";
    }
    } catch (Exception $ex) {
        echo "<p style='color: red;'>Error: " . htmlspecialchars($ex->getMessage()) . "</p>";
    }
}

?>