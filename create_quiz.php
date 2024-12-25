<?php
include 'header.php';
include 'Includes/Quiz_handler.php';
include 'Includes/Chapter_handler.php';
include 'Includes/Quizzes_handler.php';

$subjectId = isset($_GET['subject_id']) ? intval($_GET['subject_id']) : null;
$subjectId = isset($_GET['subject_id']) ? (int)$_GET['subject_id'] : 0;
$userId = $_SESSION['user_id'] ?? null;
?>

<script type="text/javascript" src="script.js"></script>


<div class="overlay2">
    <section class="content-head3">
        <h1>
            Create new Quiz for <?= $subjectName ?>
        </h1>
    </section>
</div>

<div class="wrapper">
    <div class="container">
        <div class="questions">
            <div class="crud-rule-wide">

                <form action="Includes/Quiz_handler.php" method="POST">
                    <input type="hidden" name="subject_id" value="<?php echo htmlspecialchars($subjectId); ?>">
                    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($userId); ?>">
                    <div class="crud-rule">
                        <h1>Quiz Detail</h1>
                        <table>
                            <tr>
                                <td>Add Title:</td>
                                <td><input type="text" name="quiz_title" required></td>
                            </tr>
                            <tr>
                                <td>Add Description:</td>
                                <td><input type="text" name="quiz_text"></td>
                            </tr>
                            <tr>
                                <td><label for="timerInput">Timer:</label></td>
                                <td><input type="text" id="timerInput" name="timer" pattern="\d{2}:\d{2}:\d{2}" placeholder="00:00:00" required></td>
                            </tr>
                            <tr>
                                <td><label for="chapter">Chapter:</label></td>
                                <td>
                                    <select name="chapter_id" id="Chapters" required>
                                        <option value="">Choose chapter...</option>
                                        <?php
                                        //$subjectId = isset($_GET['subject_id']) ? intval($_GET['subject_id']) : null;
                                        $chapter = new Quiz($db);  // Changed variable name to avoid confusion

                                        $chapterList = [];
                                        if ($subjectId !== null) {
                                            $chapterList = $chapter->chapterList($subjectId);
                                        }
                                        ?>
                                        <?php foreach ($chapterList as $chapter): ?>
                                            <option value="<?php echo htmlspecialchars($chapter['chapter_id']); ?>">
                                                <?php echo htmlspecialchars($chapter['chapter_title']); ?>
                                            </option>
                                        <?php endforeach; ?>
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

            <!-- <form id="yourFormId">
                <label for="quiz_title">Quiz Title:</label>
                <input type="text" id="quiz_title" name="quiz_title" value="<?php echo htmlspecialchars($quizData['quiz_title']); ?>" readonly>

                <label for="quiz_text">Quiz Text:</label>
                <input type="text" id="quiz_text" name="quiz_text" value="<?php echo htmlspecialchars($quizData['quiz_text']); ?>" readonly>

                <label for="question_count">Number of Questions:</label>
                <input type="number" id="question_count" name="question_count" min="1" required>

                <div id="questions_container"></div>

                <button type="submit">Submit Quiz</button>
            </form> -->

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
                                <td>
                                    <input type="text" name="questions[${i}][options][${optionIndex}][option_text]" placeholder="Option ${optionIndex + 1}" required>
                                </td>
                                <td>
                                    <input type="checkbox" name="questions[${i}][options][${optionIndex}][is_correct]" value="1" onclick="handleCheckboxClick(this)">
                                </td>
                                <td>Correct</td>
                            </tr>
                        `).join('')}
                    </table>
                </div>
            `;
                    }
                });

                function handleCheckboxClick(checkbox) {
                    const questionContainer = checkbox.closest('.popup-content3');
                    const checkboxes = questionContainer.querySelectorAll('input[type="checkbox"]');

                    checkboxes.forEach(cb => {
                        if (cb !== checkbox) {
                            cb.checked = false; // Uncheck other checkboxes
                        }
                    });
                }

                // Add validation on form submission
                document.getElementById('yourFormId').addEventListener('submit', function(event) {
                    const inputs = this.querySelectorAll('input[required]');
                    let valid = true;

                    inputs.forEach(input => {
                        if (input.type === 'text' || input.type === 'number') {
                            // Trim the input value to check for empty spaces
                            if (input.value.trim() === '') {
                                valid = false;
                                input.classList.add('error'); // Optional: Add an error class for styling
                            } else {
                                input.classList.remove('error'); // Remove error class if valid
                            }
                        }
                    });

                    if (!valid) {
                        event.preventDefault(); // Prevent form submission if invalid
                        alert('Please fill out all required fields.'); // Optional alert
                    }
                });
            </script>

        </div>




    </div>