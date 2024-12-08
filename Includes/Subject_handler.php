<?php

require_once 'Subject.php'; 

if (isset($_POST['submitted'])) {
    try {
    $subject = new Subject($db);
    $subject->setSubjectName($_POST['subject_name']);
    $subject->setSubjectText($_POST['subject_text']);
    $subject->setAssignTo($_POST['assigned_to']);

    $newSubjectId = $subject->createSubject();

    if ($newSubjectId) {
        header("Location: ../subject_page.php");
        exit();
    } else {
        echo "<p style='color: red;'>Failed creating subject.</p>";
    }
    } catch (Exception $ex) {
        echo "<p style='color: red;'>Error: " . htmlspecialchars($ex->getMessage()) . "</p>";
    }
}

//deleting subject
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['subject_id'])) {
    $subjectId = intval($_POST['subject_id']);

    try {
        $subject = new Subject($db);
        $subject->setSubjectId($subjectId);
        $result = $subject->deleteSubject();

        if ($result) {
            // $_SESSION['message'] = 'User deleted successfully';
            header("Location: ../subject_page.php");
            exit();
        } else {
            echo "Failed to delete user.";
        }
    } catch (Exception $ex) {
        echo "Error: " . htmlspecialchars($ex->getMessage());
    }

    if (isset($_GET['message'])) {
        echo "<p style='color: green;'>" . htmlspecialchars($_GET['message']) . "</p>";
    }
}

?>
