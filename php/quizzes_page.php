<?php
include 'header.php';

?>

<script type="text/javascript" src="java.js"></script>

<!-- <div class="popup-create">
    <div class="popup-content">
        <h3>Create new Chapter</h3>
        <form action="quizzes_page.php" method="post">
            <div class="form-content">
                <p>Chapter Name</p>
                <input type="text" id="chapter_name" name="chapter_name" required>
            </div>
            <button type="submit" name='submitted' style="background-color: rgb(89, 218, 100);">Add</button>
            <button type="button" onclick="closePopup()" style="background-color: rgb(231, 59, 59);">Cancel</button>
        </form>
    </div>
</div> -->

<section class="content-head">
    <h1><span>
            Select Quiz of your choosing
        </span></h1>
</section>

<div class="wrapper">
    <div class="container">
        <section class="content-body">
            <div class="crud-quiz">
                <button class="buttons">Return</button>
                <button class="buttons" id="add">Add Chapter</button>
                <button class="buttons"><a href="create_quiz.php">Add quiz</a></button>
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
                            <button class="buttons">Edit Quiz</button>
                            <button class="delete">Delete</button>
                        </div>
                    </div>
                    <div class="sub-quiz">
                        <h2>Quiz</h2>
                        <h4>Discription Discription Discription Discription</h4>
                        <div class="quiz-buttons">
                            <button class="buttons"><a href="rule_page.php">Start</a></button>
                            <button class="buttons">Edit Quiz</button>
                            <button class="delete" style="background-color: red;">Delete</button>
                        </div>
                    </div>
                    <div class="sub-quiz">
                        <h2>Quiz</h2>
                        <h4>Discription Discription Discription Discription</h4>
                        <div class="quiz-buttons">
                            <button class="buttons">Start</button>
                            <button class="buttons">Edit Quiz</button>
                            <button class="delete" style="background-color: red;">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>