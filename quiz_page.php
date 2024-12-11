<?php
include 'header.php';
include 'Includes/auth.php';
include 'Includes/Quiz_handler.php';


?>

<body class="page11">
    <div class="content-timer">
        <!-- <h1 id="quiz-timer"><?php echo htmlspecialchars($timer); ?></h1> -->
        <h1 id="quiz-timer">10:00</h1>
    </div>

    <script>
        // Convert timer from string to seconds
        let timerElement = document.getElementById('quiz-timer');
        let timeParts = timerElement.innerText.split(':');
        let timeInSeconds = parseInt(timeParts[0]) * 60 + parseInt(timeParts[1]);

        // Countdown function
        function startTimer() {
            let countdown = setInterval(function() {
                if (timeInSeconds <= 0) {
                    clearInterval(countdown);
                    handleTimeout();
                } else {
                    timeInSeconds--;
                    let minutes = Math.floor(timeInSeconds / 60);
                    let seconds = timeInSeconds % 60;
                    timerElement.innerText = (minutes < 10 ? '0' : '') + minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
                }
            }, 1000);
        }

        // Handle actions when the timer runs out
        function handleTimeout() {
            // Show a popup message
            alert("Time ran out on the quiz!");

            // Save selected answers (here, you might want to send a request to your server)
            saveSelectedAnswers();

            // Redirect to results page after a short delay
            setTimeout(function() {
                window.location.href = "result_page.php";
            }, 2000); // Adjust the delay as needed
        }

        // Function to save selected answers
        function saveSelectedAnswers() {
            const formData = new FormData(document.querySelector('quiz-form')); // Assuming your questions are in a form
            fetch('save_answers.php', { // Create a separate endpoint to handle the saving
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

                        <h1>Choose an Option</h1>

                        <?php
                        $question = new Question($db);
                        $questionList = $question->listQuestion();
                        
                        ?>

                        <form id="quiz-form">
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
                        </form>

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