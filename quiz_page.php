<?php
include 'header.php';
include 'Includes/auth.php';
include 'Includes/Quiz_handler.php';
?>

<body class="page11">
    <div class="content-timer">
        <h1>10:00</h1>
    </div>

    <div class="wrapper">
        <div class="container">
            <div class="spaceup">
                <div class="questions">

                    <div class="content-question">

                        <h1>Choose an Option</h1>

                        <?php
                        $question = new Question($db);
                        $questionList = $question->listQuestion();
                        ?>

                        <?php foreach ($questionList as $question): ?>
                            <div class="question-card">
                                <div class="question">
                                    <h2><?php echo htmlspecialchars($question['question_text']); ?></h2>
                                    <div class="question-card-options">
                                        <?php foreach ($question['optionList'] as $index => $option): ?>
                                            <input type="radio" id="option_<?php echo $question['id'] . '_' . $index; ?>"
                                                name="options[<?php echo $question['id']; ?>]"
                                                value="<?php echo htmlspecialchars($option['id']); ?>">
                                            <label for="option_<?php echo $question['id'] . '_' . $index; ?>">
                                                <?php echo htmlspecialchars($option['option_text']); ?>
                                            </label>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>


                        <div class="question-card">
                            <h1>Choose an Option</h1>
                            <div class="question-card-options">
                                <input type="radio" id="option1" name="options" value="1">
                                <label for="option1">Short</label>

                                <input type="radio" id="option2" name="options" value="2">
                                <label for="option2">Medium Length</label>

                                <input type="radio" id="option3" name="options" value="3">
                                <label for="option3">This is a Considerably Longer Option This is a Considerably Longer Option</label>

                                <input type="radio" id="option4" name="options" value="4">
                                <label for="option4">Another Option</label>
                            </div>
                        </div>
                        <button class="button2"><a href="result_page.php">Submit Answers</a></button>
                    </div>

                </div>
            </div>
        </div>
</body>