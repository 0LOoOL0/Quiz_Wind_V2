<?php
require_once 'Chapter.php';
require_once 'Subject.php'; 

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);


$chapter = new Chapter($db);

// Check if chapter_id is set in the POST request
if (isset($_POST['chapter_id'])) {
    $chapterId = intval($_POST['chapter_id']);

    // Check if chapter ID is valid
    if ($chapterId <= 0) {
        echo "Invalid chapter ID.";
        exit;
    }

    // Fetch chapter details
    $chapterDetails = $chapter->getChapterDetail($chapterId);

    if ($chapterDetails) {
        foreach ($chapterDetails as $quiz) { // Use $quiz to access current quiz details
    
            
        $subjectId = isset($_GET['subject_id']) ? (int)$_GET['subject_id'] : 0;

            echo "<div class='sub-quiz'>
                    <h2>" . htmlspecialchars($quiz['quiz_title']) . "</h2> 
                    <h4>" . htmlspecialchars($quiz['quiz_text']) . "</h4> 
                    <div class='quiz-buttons'>";

                        echo "<button class='button1'>
                            <a href='rule_page.php?quiz_id=" . htmlspecialchars($quiz['quiz_id']) . "' class='button1'>Start</a>
                        </button>";

                        echo "<div class='crud-button'>";

                        echo "<form action='Includes/delete_quiz.php' method='post'>
                                <input type='hidden' name='quiz_id' value='" . htmlspecialchars($quiz["quiz_id"]) . "' />
                                 <input type='hidden' name='subject_id' value='" . htmlspecialchars($subjectId) . "' />
                                <button type='submit' class='button4' onclick='return confirm(\"Are you sure you want to delete this quiz?\");'>Delete</button>
                            </form>";
    
            echo "</div>"; // Close quiz-buttons div
            echo "</div>"; // Close sub-quiz div
        }

    } else {
        echo "No details found for chapter ID: " . htmlspecialchars($chapterId);
    }
} else {
    echo "Chapter ID not set.";
}
?>