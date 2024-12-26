<?php
include 'header.php';
include 'Includes/Chapter_handler.php';
include 'Includes/Quizzes_handler.php';
include 'Includes/auth.php';

$userId = $_SESSION['user_id'] ?? null;
$userName = $_SESSION['user_id'] ?? null;
$roleId = $_SESSION['role_id'] ?? null;
$roleName = $_SESSION['role_name'] ?? null;

$quiz = new Quiz($db);
$quizByChapters = $quiz->getQuizzesByChapter($chapterId);

$subjectId = isset($_GET['subject_id']) ? (int)$_GET['subject_id'] : 0;
$subjectId = isset($_GET['subject_id']) ? intval($_GET['subject_id']) : null;

if ($subjectId <= 0) {
    echo "Invalid subject ID.";
    exit;
}

function userHasPermission($roleName, $action)
{
    // Define permissions
    $permissions = [
        'Admin' => ['create', 'edit', 'delete'],
        'Teacher' => ['create', 'edit', 'delete'],
        'Student' => ['view'],
        // Add other roles as needed
    ];

    return isset($permissions[$roleName]) && in_array($action, $permissions[$roleName]);
}
?>

<script>
function displayChapterDetails(chapterId) {
    var xhr = new XMLHttpRequest();
    
    xhr.onload = function() {
        if (xhr.status === 200) {
            // Display the response in the designated div
            document.getElementById('chapter-details').innerHTML = xhr.responseText;

            // Hide the quiz list when chapter details are displayed
            document.getElementById('quiz-list').style.display = 'none'; // Assuming the quiz list has this ID
        } else {
            console.error("Error fetching chapter details:", xhr.status, xhr.statusText);
            document.getElementById('chapter-details').innerHTML = "Error fetching chapter details: " + xhr.status + " " + xhr.statusText;
        }
    };

    // Open a POST request to fetch chapter details
    xhr.open('POST', 'Includes/get_chapter.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
    // Send the chapter_id in the request body
    xhr.send('chapter_id=' + encodeURIComponent(chapterId));
}
</script>

<script type="text/javascript" src="script.js"></script>

<div class="popup-create">
    <div class="popup-content">
        <h3>Create new Chapter</h3>
        <form action="Includes/Chapter_handler.php?subject_id=<?= htmlspecialchars($subjectId) ?>" method="post">
            <div class="form-content">
                <p>Chapter Name</p>
                <input type="hidden" name="subject_id" value="<?= htmlspecialchars($subjectId) ?>">
                <input type="text" id="chapter_title" name="chapter_title" required>
            </div>
            <button type="submit" class="button1" name='submitted'>Add</button>
            <button type="button" class="button4" onclick="closePopup()">Cancel</button>
        </form>
    </div>
</div>

<div class="overlay2">
    <section class="content-head3">
        <h1><?= $subjectName ?></h1>
    </section>
</div>

<?php

?>

<div class="wrapper">
    <div class="container">
        <section class="content-body">

            <div class="crud-quiz">
                <button class="button3" id="add">Add Chapter</button>
                <button class="button3">
                    <a href="create_quiz.php?subject_id=<?php echo htmlspecialchars($subjectId); ?>">Add Quiz</a>
                </button>
            </div>

            <div class="content-quiz">
                <div class="chapters">
                    <div class="sub-chapter">
                        <ul>
                        <?php

                                $chapter = new Chapter($db);
                                $chapterList = $chapter->getChaptersBySubject($subjectId);

                                // Display the list of chapters
                                if (!empty($chapterList)) {
                                    foreach ($chapterList as $chapterItem) {
                                        $chapterId = htmlspecialchars($chapterItem['chapter_id']);
                                        $chapterTitle = htmlspecialchars($chapterItem['chapter_title']);
                                        
                                        // Button for displaying chapter details
                                        echo "<div id='chapterList'>
                                            <li class='buttonQuiz' onclick='displayChapterDetails($chapterId)'>$chapterTitle"; // Use onclick to call JavaScript
                                        
                                        if (userHasPermission($roleName, 'delete')) {
                                            echo "<form action='Includes/delete_chapter.php' method='post' style='display:inline;'>
                                                <input type='hidden' name='chapter_id' value='" . htmlspecialchars($chapterId) . "' />
                                                <input type='hidden' name='subject_id' value='" . htmlspecialchars($subjectId) . "' />
                                                <button type='submit' class='button6' onclick='return confirm(\"Are you sure you want to delete this chapter?\");'>X</button>
                                            </form>";
                                        }
                                        
                                        echo "</li></div>";
                                    }
                                } else {
                                    echo "No chapters found for this subject.";
                                }

                                // Place to display chapter details
                                

                                ?>
                        </ul>
                    </div>
                </div>

                <div class="quizzes">

                    <?php

                    echo "<div id='chapter-details' class='chapter-details'></div>";

                    

                    $quizList = $quiz->quizList($subjectId);

                    if (!empty($quizList)) {
                        foreach ($quizList as $quiz) {
                            echo "<div class='sub-quiz'>
                                    <h2>" . htmlspecialchars($quiz['quiz_title']) . "</h2>
                                    <h4>" . htmlspecialchars($quiz['quiz_text']) . "</h4>
                                    <div class='quiz-buttons'>";

                            if (userHasPermission($roleName, 'view')) {
                                echo "<button class='button1'>
                                        <a href='rule_page.php?quiz_id=" . htmlspecialchars($quiz['quiz_id']) . "' class='button1'>Start</a>
                                    </button>";
                            }

                            echo "<div class='crud-button'>";

                            if (userHasPermission($roleName, 'delete')) {
                                echo "<form action='Includes/delete_quiz.php' method='post'>
                                        <input type='hidden' name='quiz_id' value='" . htmlspecialchars($quiz["quiz_id"]) . "' />
                                        <input type='hidden' name='subject_id' value='" . htmlspecialchars($subjectId) . "' />
                                        
                                        <button type='submit' class='button4' onclick='return confirm(\"Are you sure you want to delete this quiz?\");'>Delete</button>
                                    </form>";
                            }

                            echo "</div>"; // Close crud-button div
                            echo "</div>"; // Close quiz-buttons div
                            echo "</div>"; // Close sub-quiz div
                        }
                    } else {
                        echo "this subject has no quiz, create one!";
                    }

                    ?>

                </div>
            </div>

        </section>
    </div>
</div>