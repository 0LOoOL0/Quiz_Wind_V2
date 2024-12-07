<?php
include 'header.php';

?>

<script type="text/javascript" src="script.js"></script>

<div class="popup-create">
    <div class="popup-content">
        <h3>Create new Chapter</h3>
        <form action="quizzes_page.php" method="post">
            <div class="form-content">
                <p>Chapter Name</p>
                <input type="text" id="chapter_name" name="chapter_name" required>
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
                            <li>chapter</li>
                            <li>chapter</li>
                            <li>chapter</li>
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