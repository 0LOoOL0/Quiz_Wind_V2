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
        var totalSeconds = (+timerParts[0]) * 60 * 60 + (+timerParts[1]) * 60 + (+timerParts[2]);

        var countdown = setInterval(function() {
            var hours = Math.floor(totalSeconds / 3600);
            var minutes = Math.floor((totalSeconds % 3600) / 60);
            var seconds = totalSeconds % 60;

            // Format the time
            timerDisplay.textContent = (hours < 10 ? '0' : '') + hours + ':' +
                (minutes < 10 ? '0' : '') + minutes + ':' +
                (seconds < 10 ? '0' : '') + seconds;

            // Decrease totalSeconds by 1
            totalSeconds--;

            // Stop the countdown when it reaches zero
            if (totalSeconds < 0) {
                clearInterval(countdown);
                timerDisplay.textContent = "Time's up!";
                document.getElementById('quiz-form').submit(); // Automatically submit the form
            }
        }, 1000);
    }

    // Get the timer value from the data attribute
    var timerValue = document.getElementById('quiz-timer').getAttribute('data-timer');
    startCountdown(timerValue);

    const quizId = <?php echo json_encode($quizId); ?>;

    // Redirect to rule_page with quiz_id when the back button is pressed
    window.onpopstate = function() {
        window.location.href = 'rule_page.php?quiz_id=' + encodeURIComponent(quizId);
    };

    // Push the current state to prevent going back immediately
    window.history.pushState(null, '', window.location.href);

    document.getElementById('submit-button').onclick = function(event) {
        event.preventDefault(); // Prevent default form submission

        const answers = {};
        const questions = document.querySelectorAll('.question'); // Assuming each question has a class 'question'

        questions.forEach((question) => {
            const questionId = question.getAttribute('data-question-id'); // Assuming each question has a data attribute for ID
            const selectedOption = question.querySelector('input[type="radio"]:checked'); // Get the checked radio button

            if (selectedOption) {
                // If an option is selected, record its value and score
                answers[questionId] = {
                    selected_option_id: selectedOption.value,
                    score: parseInt(selectedOption.getAttribute('data-score')) || 0 // Use the score from the selected option
                };
            } else {
                // If no option is selected, record a score of 0
                answers[questionId] = {
                    selected_option_id: null,
                    score: 0
                };
            }
        });

        // Submit the gathered answers through an AJAX request or directly
        fetch('your_save_answers_endpoint.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ userId: <?php echo json_encode($userId); ?>, quizId: quizId, answers: answers }),
        })
        .then(response => response.json())
        .then(data => {
            // Handle response
            console.log(data);
            // Optionally redirect or show a message here
        })
        .catch((error) => {
            console.error('Error:', error);
        });
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
                            value="<?php echo htmlspecialchars($option['id']); ?>">
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