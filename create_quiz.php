<?php
include 'header.php';
?>

<script type="text/javascript" src="script.js"></script>


<section>
    <div class="content-head2">
        <h1>Create New Quiz</h1>
    </div>
</section>
    <div class="wrapper">
        <div class="container">
            <div class="questions">
                <div class="centering">
                    <button id='add' class="button3">Create New Question</button>
                    <button id='add' class="button1">Save All</button>
                </div>

                <div class="crud-rule">
                    <h1>Quiz</h1>
                        <table>
                            <tr>
                                <td style='width:300px;'>Add Quiz Title</td>
                                <td><input type="text" style='width:110%; height:50px; border-radius:10px; margin:10px;'></td>
                            </tr>
                            <tr>
                                <td style='width:250px;'>Add Quiz Description (Optional)</td>
                                <td><input type="text" style='width:110%; height:50px; border-radius:10px; margin:10px;'></td>
                            </tr>
                        </table>
                    <h1>Select Timer</h1>
                    <table>
                        <tr>
                            <td style='width:100px;'><label for="Timer">Timer:</label></td>
                            <td><select name='chooseTime' style='width:110%; height:50px; border-radius:10px;' required>
                                    <option value="0">No Timer...</option>
                                    <option value="1">0:10</option>
                                    <option value="2">0:15</option>
                                    <option value="3">0:30</option>
                                    <option value="4">1:00</option>
                                    <option value="5">1:30</option>
                                    <option value="6">2:00</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="popup-create">
                    <form action="" method="post">
                        <div class="popup-content">
                            <h1><label for="question">Create Question</label></h1>
                            <table>
                                <tr>
                                    <td style='width:40px;'><label for="questionText">Question:</label></td>
                                    <td><input type="text" id="question" name="questionText" required></td>
                                </tr>
                            </table>
                            <div id="crud-option">
                                <table>
                                    <?php for ($i = 0; $i < 4; $i++): ?>
                                        <tr>
                                            <td style='width:20px;'><label for="option<?php echo $i; ?>">Option:</label></td>
                                            <td>
                                                <input type="text" name="optionTexts[]" id="option<?php echo $i; ?>" required />
                                            </td>
                                        </tr>
                                    <?php endfor; ?>
                                    <tr>
                                        <td style='width:20px;'><label>Correct answer:</label></td>
                                        <td>
                                            <select type="" style='width:930px; height:50px; border-radius:10px; margin-left: 10px; margin-top:20px;' name="isCorrect[]">
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
                            <button type="submit" class="button1" name='submitted'>Add Question</button>
                            <button type="button" class="button4" onclick="closePopup()">cancel</button>
                        </div>
                    </form>
                </div>

                <div class="question-card" style="width:60%">
                    <h1>question</h1>
                    <div class="question-card-created">
                        <label for="option1">Short</label>
                        <label for="option2">Medium Length</label>
                        <label for="option3">This is a Considerably Longer Option This is a Considerably Longer Option</label>
                        <label for="option4">Another Option</label>
                    </div>
                    <button class="button4" style="width: 70%; margin-top:20px;">Remove</button>
                </div>
                <div class="question-card" style="width:60%">
                    <h1>question</h1>
                    <div class="question-card-created">
                        <label for="option1">Short</label>
                        <label for="option2">Medium Length</label>
                        <label for="option3">This is a Considerably Longer Option This is a Considerably Longer Option</label>
                        <label for="option4">Another Option</label>
                    </div>
                    <button class="button4" style="width: 70%; margin-top:20px;">Remove</button>
                </div>
                <div class="question-card" style="width:60%">
                    <h1>question</h1>
                    <div class="question-card-created">
                        <label for="option1">Short</label>
                        <label for="option2">Medium Length</label>
                    </div>
                    <button class="button4" style="width: 70%; margin-top:20px;">Remove</button>
                </div>
                
            </div>
        </div>