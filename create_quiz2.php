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
                <button id='add' class="button1">Save All</button>
            </div>

            <div class="crud-rule">
                <h1 style="text-align:center;">Quiz Detail</h1>
                <table>
                    <tr>
                        <td style='width:200px;'>Add Title</td>
                        <td><input type="text" style='width:110%; height:40px; border-radius:10px; margin:10px;' required></td>
                    </tr>
                    <tr>
                        <td style='width:200px;'>Add Description (Optional): </td>
                        <td><input type="text" style='width:110%; height:40px; border-radius:10px; margin:10px;'></td>
                    </tr>
                </table>
                <form action="Includes/Quiz_handler.php">
                    <table>
                        <tr>
                            <td style='width:210px;'><label for="Timer">Timer: </label></td>
                            <td><input type=text id='timerInput' name='timerInput' style='width:111%; height:40px; border-radius:10px;' pattern="\d{2}:\d{2}:\d{2}" placeholder="00:00:00" required>
                            </td>
                        </tr>
                    </table>
                </form>
                <table>
                    <tr>
                        <td style='width:210px;'><label for="chapter">Chapter:</label></td>
                        <td><select name='chooseChapter' id="Chapters" placeholder="Select Chapter" style='width:112%; height:50px; border-radius:10px;' required>
                                <option value="">choose chapter...</option>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>

            <div id="question-container">
                <div class="popup-create2">
                    <form action="Includes/Question_handler.php" method="post">
                        <div class="popup-content2">
                            <h1><label for="question">Create Question</label></h1>
                            <table>
                                <tr>
                                    <td style='width:40px;'><label for="questionText">Question:</label></td>
                                    <td><input type="text" name="questionText[]" required></td>
                                </tr>
                            </table>
                            <div class="crud-option">
                                <table>
                                    <?php for ($i = 0; $i < 4; $i++): ?>
                                        <tr>
                                            <td style='width:20px;'><label>Option:</label></td>
                                            <td>
                                                <input type="text" name="optionTexts[]" required />
                                            </td>
                                        </tr>
                                    <?php endfor; ?>
                                    <tr>
                                        <td style='width:20px;'><label>Correct answer:</label></td>
                                        <td>
                                            <select style='width:80%; border-radius:5px; margin-left: 10px; margin-top:20px;' name="isCorrect[]">
                                                <option value="">Select correct Answer....</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <script>
                let questionCount = 1;

                document.getElementById('add-question').addEventListener('click', function() {
                    const container = document.getElementById('question-container');

                    const newPopup = document.createElement('div');
                    newPopup.className = 'popup-create2';
                    newPopup.innerHTML = `
                <form action="Includes/Question_handler.php" method="post">
                    <div class="popup-content2" style='margin-top:100px'>
                        <h1><label for="question">Create Question</label></h1>
                        <table>
                            <tr>
                                <td style='width:40px;'><label for="questionText">Question:</label></td>
                                <td><input type="text" name="questionText[]" required></td>
                            </tr>
                        </table>
                        <div class="crud-option">
                            <table>
                        <?php for ($i = 0; $i < 4; $i++): ?>

                                <tr>
                                    <td style='width:20px;'><label>Option:</label></td>
                                    <td>
                                        <input type="text" name="optionTexts[]" required />
                                    </td>
                                </tr>
                                 <?php endfor; ?>
                                <tr>
                                    <td style='width:20px;'><label>Correct answer:</label></td>
                                    <td>
                                        <select style='width:80%; border-radius:5px; margin-left: 10px; margin-top:20px;' name="isCorrect[]">
                                            <option value="">Select correct Answer....</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <span class="button4" onclick="this.parentElement.parentElement.parentElement.remove()">Remove</span>
                    </div>
                </form>
            `;

                    container.appendChild(newPopup);
                    questionCount++;
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