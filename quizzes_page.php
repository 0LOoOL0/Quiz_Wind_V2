<?php
include 'header.php';
include 'Includes/Chapter_handler.php';

?>

<script type="text/javascript" src="script.js"></script>

<div class="popup-create">
    <div class="popup-content">
        <h3>Create new Chapter</h3>
        <form action="Includes/Chapter_handler.php" method="post">
            <div class="form-content">
                <p>Chapter Name</p>
                <input type="text" id="chapter_title" name="chapter_title" required>
            </div>
            <button type="submit" class="button1" name='submitted'>Add</button>
            <button type="button" class="button4" onclick="closePopup()">Cancel</button>
        </form>
    </div>
</div>

<section class="content-head">
    <h1><span>
            Select Quiz of your choosing
        </span></h1>
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
                            <li>chapter</li>
                            <?php

                            //testing

                            //$subjectId = 1;

                            $subjectId = isset($_GET['subject_id']) ? (int)$_GET['subject_id'] : 0;
                            
                            if ($subjectId <= 0) {
                                echo "Invalid subject ID.";
                                exit;
                            }

                            $chapter = new Chapter($db);
                            $chapterList = $chapter->getChaptersBySubject($subjectId);
                            if (!empty($chapterList)) {
                                foreach ($chapterList as $chapter) {
                                    echo "<li>" . $chapter['subject_id'] . "'>" . htmlspecialchars($chapter['chapter_title']) . "</li>";
                                }
                            } else {
                                echo "No chapters found for this subject.";
                            }

                            //this is a test working when not assigned to subjects
                            
                            // $chapter = new Chapter($db);
                            // $chapterList = $chapter->chapterList();

                            // if (!empty($chapterList)) {
                            //     foreach ($chapterList as $chapter) {
                            //         echo "<li>". $chapter['chapter_title'] . "</li>";
                            //     }
                            // } else {
                            //     echo " 0 Results";
                            // }

                            ?>
                        </ul>
                    </div>
                </div>
                <div class="quizzes">
                    <div class="add-quiz">
                        <h2>Quiz</h2>
                        <p>Discription Discription Discription Discription</p>
                        <div class="quiz-buttons">
                            <button class="button3">Edit Quiz</button>
                            <button class="button4">Delete</button>
                        </div>
                    </div>
                    <div class="sub-quiz">
                        <h2>Quiz</h2>
                        <h4>Discription Discription Discription Discription</h4>
                        <div class="quiz-buttons">
                            <button class="button1"><a href="rule_page.php">Start</a></button>
                            <button class="button3">Edit Quiz</button>
                            <button class="button4">Delete</button>
                        </div>
                    </div>
                    <div class="sub-quiz">
                        <h2>Quiz</h2>
                        <h4>Discription Discription Discription Discription</h4>
                        <div class="quiz-buttons">
                            <button class="button1">Start</button>
                            <button class="button3">Edit Quiz</button>
                            <button class="button4">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>