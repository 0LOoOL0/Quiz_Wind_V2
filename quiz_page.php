<?php
include 'header.php';
include 'Includes/auth.php';
include 'Includes/Quiz_handler.php';
include 'Includes/Answer_handler.php';

$quizId = isset($_GET['quiz_id']) ? intval($_GET['quiz_id']) : null;

?>

<body class="">
    <div class="content-timer">
        <h1 id="quiz-timer">10:00</h1>
    </div>

    <script>
        // Timer logic remains the same...

        function handleTimeout() {
            alert("Time ran out on the quiz!");
            saveSelectedAnswers();
            setTimeout(function() {
                window.location.href = "result_page.php";
            }, 2000);
        }

        function saveSelectedAnswers() {
            const formData = new FormData(document.getElementById('quiz-form')); // Ensure form ID matches
            fetch('submit_answers.php', { // Change to your submission handler
                method: 'POST',
                body: formData
            }).then(response => {
                if (!response.ok) {
                    console.error('Failed to save answers.');
                }
            });
        }

        // Start the timer
        startTimer();
    </script>

    <div class="wrapper">
        <div class="container">
            <div class="spaceup">
                <div class="questions">
                    <div class="content-question">
                        <h1>Answer Questions</h1>

                        <?php
                        $question = new Question($db);
                        $questionList = $question->listQuestion($quizId);
                        ?>

                        <form id="quiz-form" method="POST" action="Includes/Answer_handler.php">
                            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($_SESSION['user_id']); ?>">
                            <input type="hidden" name="quiz_id" value="<?php echo htmlspecialchars($quizId); ?>">

                            <?php foreach ($questionList as $question): ?>
                                <div class="question-card">
                                    <h2><?php echo htmlspecialchars($question['question_text']); ?></h2>
                                    <div class="question-card-options">
                                        <?php foreach ($question['optionList'] as $index => $option): ?>
                                            <input type="radio" id="option_<?php echo $question['id'] . '_' . $index; ?>"
                                                name="answers[<?php echo $question['id']; ?>][selected_option_id]"
                                                value="<?php echo htmlspecialchars($option['id']); ?>">
                                            <label for="option_<?php echo $question['id'] . '_' . $index; ?>">
                                                <?php echo htmlspecialchars($option['option_text']); ?>
                                            </label>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                            <button type="submit" class="button2">Submit Answers</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</body>