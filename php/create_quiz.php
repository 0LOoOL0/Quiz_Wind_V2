<?php
include 'header.php';
?>

<script type="text/javascript" src="java.js"></script>

<body class="create_quiz_bakcground">
<div class="wrapper">
    <div class="container">
        <div class="questions">
            <div class="crud-rule">
                <h2>Select Timer</h2>
                <table>
                    <tr>
                        <td style='width:100px;'><label for="Timer">Timer:</label></td>
                        <td><select name='chooseTime' style='width:110%; height:50px; border-radius:10px;' required>
                                <option value="none">No Timer</option>
                                <option value="0">0:10</option>
                                <option value="1">0:15</option>
                                <option value="2">0:30</option>
                                <option value="3">1:00</option>
                                <option value="4">1:30</option>
                                <option value="5">2:00</option>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>

            
            <div class="crud-question">
                <form action="Includes/question_handler.inc.php" method="post">
                    <div class="new-question">
                        <h2><label for="question">Create Question</label></h2>
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
                                            <input type="text" name="optionTexts[]" id="option<?php echo $i; ?>" style='width:800px;' required />
                                        </td>
                                        <td style='width:100px;'><label for="isCorrect<?php echo $i; ?>">Correct Answer?</label></td>
                                        <td>
                                            <input type="checkbox" name="isCorrect[]" value="<?php echo $i; ?>" id="isCorrect<?php echo $i; ?>">
                                        </td>
                                    </tr>
                                <?php endfor; ?>
                            </table>
                        </div>
                        <button class="buttons" type="submit">Submit Question</button>

                    </div>
                </form>
            </div>

            <div class="content-question">
                
                <?php
                ?>
            </div>
        </div>
    </div>
</div>
</body>