<?php
include 'header.php';
include 'Includes/auth.php';
include 'Includes/Quiz_handler.php';
include 'Includes/Answer_handler.php';

$quizId = isset($_GET['quiz_id']) ? intval($_GET['quiz_id']) : null;
?>

<body class="">
    <div class="content-timer">
        <?php
        $timer = new Question($db);
        $getTimer = $timer->quizTimer($quizId); // Fetch the timer data

        if (!empty($getTimer)) { // Check if $getTimer has results
            foreach ($getTimer as $row) { // Iterate over the results
                // Assume the timer is in 'HH:MM:SS' format
                $timerValue = $row['timer'];
                echo "<h1 id='quiz-timer' data-timer='$timerValue'>" . htmlspecialchars($timerValue) . "</h1>";
            }
        } else {
            echo "No Timer";
        }
        ?>
    </div>

    <script>
    // Function to start countdown
    function startCountdown(duration) {
        var timerDisplay = document.getElementById('quiz-timer');
        var timerParts = duration.split(':');
        var totalSeconds = (+timerParts[0]) * 3600 + (+timerParts[1]) * 60 + (+timerParts[2]);

        // Check localStorage for remaining time
        var remainingTime = localStorage.getItem('remainingTime');
        if (remainingTime) {
            totalSeconds = parseInt(remainingTime, 10);
        }

        var countdown = setInterval(function() {
            var hours = Math.floor(totalSeconds / 3600);
            var minutes = Math.floor((totalSeconds % 3600) / 60);
            var seconds = totalSeconds % 60;

            // Format the time
            timerDisplay.textContent = 
                (hours < 10 ? '0' : '') + hours + ':' +
                (minutes < 10 ? '0' : '') + minutes + ':' +
                (seconds < 10 ? '0' : '') + seconds;

            // Decrease totalSeconds by 1
            totalSeconds--;

            // Store remaining time in localStorage
            localStorage.setItem('remainingTime', totalSeconds);

            // Stop the countdown when it reaches zero
            if (totalSeconds < 0) {
                clearInterval(countdown);
                timerDisplay.textContent = "Time's up!";
                localStorage.removeItem('remainingTime'); // Clear the stored time
                disableSubmitButton(); // Disable the submit button
                clearRadioButtons(); // Clear radio button selections
                document.getElementById('quiz-form').submit(); // Automatically submit the form
            }
        }, 1000);
    }

    // Function to disable the submit button
    function disableSubmitButton() {
        document.getElementById('submit-button').disabled = true; // Disable the button
    }

    // Function to clear all radio button selections
    function clearRadioButtons() {
        const radios = document.querySelectorAll('input[type="radio"]');
        radios.forEach(radio => {
            radio.checked = false; // Uncheck each radio button
        });
    }

    // Get the timer value from the database
    var timerValue = document.getElementById('quiz-timer').getAttribute('data-timer');
    startCountdown(timerValue);

    const quizId = <?php echo json_encode($quizId); ?>;

    // Redirect to rule_page with quiz_id when the back button is pressed
    window.onpopstate = function(event) {
        window.location.href = 'rule_page.php?quiz_id=' + encodeURIComponent(quizId);
    };

    // Push the current state to prevent going back immediately
    window.history.pushState(null, '', window.location.href);

    document.getElementById('submit-button').onclick = function(event) {
        // Prepare to submit the form
        const questions = document.querySelectorAll('.question-card');

        // Loop through questions to check radio button status
        questions.forEach(question => {
            const radios = question.querySelectorAll('input[type="radio"]');
            const isChecked = Array.from(radios).some(radio => radio.checked);
            const questionId = question.dataset.questionId; // Assuming each question card has a data-question-id attribute

            if (!isChecked) {
                // If no radio button is checked, add a hidden input to set isCorrect to 0
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = `answers[${questionId}][isCorrect]`;
                hiddenInput.value = '0';
                document.getElementById('quiz-form').appendChild(hiddenInput);
            }
        });

        // Disable button immediately to prevent multiple submissions
        this.disabled = true;

        // Allow the form to submit
        document.getElementById('quiz-form').submit();
        localStorage.removeItem('remainingTime'); // Clear the stored time on submission
    };
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

                        <form id="quiz-form" method="POST" action="Includes/AnswerNew_handler.php">
                            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($_SESSION['user_id']); ?>">
                            <input type="hidden" name="quiz_id" value="<?php echo htmlspecialchars($quizId); ?>">

                            <?php foreach ($questionList as $question): ?>
                                <div class="question-card">
                                    <h2><?php echo htmlspecialchars($question['question_text']); ?></h2>
                                    <div class="question-card-options">
                                        <?php foreach ($question['optionList'] as $index => $option): ?>
                                            <input type="radio" id="option_<?php echo $question['id'] . '_' . $index; ?>"
                                                name="answers[<?php echo $question['id']; ?>][selected_option_id]"
                                                value="<?php echo htmlspecialchars($option['id']); ?>" required>
                                            <label for="option_<?php echo $question['id'] . '_' . $index; ?>">
                                                <?php echo htmlspecialchars($option['option_text']); ?>
                                            </label>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                            <button type="submit" id='submit-button' class="button2">Submit Answers</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>