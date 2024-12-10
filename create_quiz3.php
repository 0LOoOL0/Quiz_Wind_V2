<?php
include 'header.php';
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
            <div class="centering">
                <button id='add-question' class="button3">Create New Question</button>
                <button id='save-quiz' class="button1">Save All</button>
            </div>

            <div class="crud-rule">
                <h1>Quiz Detail</h1>
                <form id="quizForm" action="Includes/Quiz_handler.php" method="POST">
                    <table>
                        <tr>
                            <td>Add Title</td>
                            <td><input type="text" name="title" required></td>
                        </tr>
                        <tr>
                            <td>Add Description:</td>
                            <td><input type="text" name="description"></td>
                        </tr>
                        <tr>
                            <td><label for="Timer">Timer:</label></td>
                            <td><input type="text" id="timerInput" name="timerInput" pattern="\d{2}:\d{2}:\d{2}" placeholder="00:00:00" required></td>
                        </tr>
                        <tr>
                            <td><label for="chapter">Chapter:</label></td>
                            <td>
                                <select name="chooseChapter" id="Chapters" required>
                                    <option value="">Choose chapter...</option>
                                    <!-- Add more options here -->
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="question_count">Number of Questions:</label></td>
                            <td>
                                <input type="number" id="question_count" name="question_count" required min="1" max="50" style="height: 40px; width: 100%; font-size: 16px; padding: 10px; box-sizing: border-box; -moz-appearance: textfield;">
                                <!-- Hide the spinner controls for Firefox -->
                                <style>
                                    /* Hide the number input spinner */
                                    input[type=number]::-webkit-inner-spin-button,
                                    input[type=number]::-webkit-outer-spin-button {
                                        -webkit-appearance: none;
                                        margin: 0;
                                    }
                                </style>
                            </td>
                        </tr>
                    </table>
                    <div id="questions_container"></div>
                    <button type="submit">Create Quiz</button>
                </form>
            </div>

            <script>
                document.getElementById('question_count').addEventListener('change', function() {
                    const count = this.value;
                    const container = document.getElementById('questions_container');
                    container.innerHTML = ''; // Clear previous questions

                    // Generate questions based on the input count
                    for (let i = 0; i < count; i++) {
                        container.innerHTML += `
                <div class="popup-content3" style='margin-top:50px'>
                    <h2>Question ${i + 1}</h2>
                    <table>
                        <tr>
                            <td><input type="text" name="questions[${i}][text]" placeholder="Question Text" required></td>
                            <td style="widht:20px;"><input type="number" name="questions[${i}][score]" placeholder="Score" value="1.00" step="0.01" required></td>
                        </tr>
                    </table>
                    <h4>Options:</h4>
                    <table>
                        ${[0, 1, 2, 3].map(optionIndex => `
                            <tr>
                                <td><input type="text" name="questions[${i}][options][${optionIndex}][text]" placeholder="Option ${optionIndex + 1}" required></td>
                                <td><input type="checkbox" name="questions[${i}][options][${optionIndex}][is_correct]" value="1"></td>
                                <td>correct</td>
                            </tr>
                        `).join('')}
                    </table>
                </div>
            `;
                    }

                    // Disable the input field to lock the number of questions
                    this.disabled = true;
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