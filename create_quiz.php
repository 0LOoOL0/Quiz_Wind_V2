<?php

include 'header.php';
include 'Includes/Quiz_handler.php';
//include 'Includes/Chapter_handler.php';

?>

<script type="text/javascript" src="script.js"></script>

<section>
    <div class="content-head">
        <h1>Create New Quiz</h1>
    </div>
</section>

<div class="wrapper">
    <div class="container">
        <div class="questions">
            <div class="crud-rule-wide">
                <form action="Includes/Quiz_handler.php" method="POST">
                    <div class="crud-rule">
                        <h1>Quiz Detail</h1>
                        <table>
                            <tr>
                                <td>Add Title</td>
                                <td><input type="text" name="quiz_title" required></td>
                            </tr>
                            <tr>
                                <td>Add Description (Optional):</td>
                                <td><input type="text" name="quiz_text"></td>
                            </tr>
                            <tr>
                                <td><label for="timerInput">Timer:</label></td>
                                <td><input type="text" id="timerInput" name="timer" pattern="\d{2}:\d{2}:\d{2}" placeholder="00:00:00" required></td>
                            </tr>
                            <tr>
                                <td><label for="chapter">Chapter:</label></td>
                                <td>
                                    <select name="chapter" id="Chapters" required>
                                        <option value="">Choose chapter...</option>
                                        <?php
                                        $chapter = new Quiz($db);
                                        $chapterList = $chapter->chapterList();
                                        foreach ($chapterList as $chapter) {
                                            echo "<option value='" . $chapter['chapter_id'] . "'>" . $chapter['chapter_title'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="question_count">Number of Questions:</label></td>
                                <td>
                                    <input type="number" id="question_count" name="question_count" required min="1" max="50" style="height: 40px; width: 100%; font-size: 16px; padding: 10px; box-sizing: border-box; -moz-appearance: textfield;">
                                    <style>
                                        input[type=number]::-webkit-inner-spin-button,
                                        input[type=number]::-webkit-outer-spin-button {
                                            -webkit-appearance: none;
                                            margin: 0;
                                        }
                                    </style>
                                </td>
                            </tr>
                        </table>
                        <button id='add-quiz' class="button2" type="submit" name="add-quiz">Save Quiz</button>
                    </div>

                    <div id="questions_container"></div>
                </form>
            </div>

            <script>
                document.getElementById('question_count').addEventListener('change', function() {
                    const count = this.value;
                    const container = document.getElementById('questions_container');
                    container.innerHTML = '';
                    this.disabled = true;

                    for (let i = 0; i < count; i++) {
                        container.innerHTML += `
                <div class="popup-content3" style='margin-top:50px'>
                    <h2>Question ${i + 1}</h2>
                    <table>
                        <tr>
                            <td><input type="text" name="questions[${i}][question_text]" placeholder="Question Text" required></td>
                            <td><input type="number" name="questions[${i}][score]" placeholder="Score" value="1.00" step="0.01" required></td>
                        </tr>
                    </table>
                    <h4>Options:</h4>
                    <table>
                        ${[0, 1, 2, 3].map(optionIndex => `
                            <tr>
                                <td><input type="text" name="questions[${i}][options][${optionIndex}][option_text]" placeholder="Option ${optionIndex + 1}" required></td>
                                <td><input type="checkbox" name="questions[${i}][options][${optionIndex}][is_correct]" value="1"></td>
                                <td>Correct</td>
                            </tr>
                        `).join('')}
                    </table>
                </div>
            `;
                    }
                });
            </script>

            <!-- <div class="question-card" style="width:60%">
                <h1>question</h1>
                <div class="question-card-created">
                    <label for="option1">Short</label>
                    <label for="option2">Medium Length</label>
                    <label for="option3">This is a Considerably Longer Option This is a Considerably Longer Option</label>
                    <label for="option4">Another Option</label>
                </div>
                <button class="button4" style="width: 70%; margin-top:20px;">Remove</button>
            </div> -->

        </div>




    </div>