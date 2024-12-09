<?php
include 'header.php';
include 'Includes/Chapter_handler.php';
include 'Includes/Quizzes_handler.php';
include 'Includes/auth.php';
?>

<script type="text/javascript" src="script.js"></script>

<div class="popup-create">
    <div class="popup-content">
        <h3>Create new Chapter</h3>
        <form action="Includes/Chapter_handler.php?subject_id=<?= htmlspecialchars($subject_id) ?>" method="post">
            <div class="form-content">
                <p>Chapter Name</p>
                <input type="hidden" name="subject_id" value="<?= htmlspecialchars($subject_id) ?>">
                <input type="text" id="chapter_title" name="chapter_title" required>
            </div>
            <button type="submit" class="button1" name='submitted'>Add</button>
            <button type="button" class="button4" onclick="closePopup()">Cancel</button>
        </form>
    </div>
</div>

<section class="content-head">
    <h1><?= $subjectName ?></h1>
</section>


<div class="wrapper">
    <div class="container">
        <section class="content-body">
            <div class="crud-quiz">
                <button class="button3">Return</button>
                <button class="button3" id="add">Add Chapter</button>
                <button class="button3"><a href="create_quiz.php">Add quiz</a></button>
            </div>
            <div class="content-quiz">
                <div class="chapters">
                    <div class="sub-chapter">
                        <ul>
                            <?php

                            $subjectId = isset($_GET['subject_id']) ? (int)$_GET['subject_id'] : 0;

                            if ($subjectId <= 0) {
                                echo "Invalid subject ID.";
                                exit;
                            }

                            $chapter = new Chapter($db);
                            $chapterList = $chapter->getChaptersBySubject($subjectId);

                            if (!empty($chapterList)) {
                                foreach ($chapterList as $chapter) {
                                    // Display chapter title
                                    echo "<li>" . htmlspecialchars($chapter['chapter_title']) . "</li>";
                                }
                                echo "</ul>";
                            } else {
                                echo "No chapters found for this subject.";
                            }

                            ?>
                        </ul>
                    </div>
                </div>

                <div class="quizzes">
                    <?php
                    $quiz = new Quiz($db);
                    $quizList = $quiz->quizList();

                    if (!empty($quizList)) {
                        foreach ($quizList as $quiz) {
                            echo "<div class='sub-quiz'>
                                    <h2>". htmlspecialchars($quiz['quiz_title']) ."</h2>
                                    <h4>" .htmlspecialchars($quiz['quiz_text'])."</h4>
                                    <div class='quiz-buttons'>

                                        <button class='button1'><a href='rule_page.php'>Start</a></button>
                                        <button class='button3'>Edit Quiz</button>
                                        <form action='Includes/Quizzes_handler.php' method='post' style='display:inline;'>
                                        <input type='hidden' name='quiz_id' value='" . htmlspecialchars($quiz["quiz_id"]) . "' />
                                        <button type='submit' class='button4' onclick='return confirm(\"Are you sure you want to delete this quiz?\");'>Delete</button>
                                        </form>

                                    </div>
                                </div>";
                        }
                        echo "</div>";
                    } else {
                        echo " 0 Results";
                    }
                    ?>

                </div>
            </div>
        </section>
    </div>
</div>