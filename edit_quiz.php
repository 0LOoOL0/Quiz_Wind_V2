<?php
include 'header.php';
include 'Includes/Quiz_handler.php';
//include 'Includes/Quizzes_handler.php';

$subjectId = isset($_GET['subject_id']) ? intval($_GET['subject_id']) : null;
$quizId = isset($_GET['quiz_id']) ? intval($_GET['quiz_id']) : null;

$userId = $_SESSION['user_id'] ?? null;

$detail = new Quiz($db);
$quizData = $detail->loadQuiz($quizId);

if ($_SESSION['role_name'] !== 'Teacher') {
    echo '<div class="spaceMessage">
            <div class = "denied">
             <h2>Access Denied</h2>
            </div>
        </div>';
    die();
}



?>

<script type="text/javascript" src="script.js"></script>

<section>
    <div class="content-head">
        <h1>Edit Quiz</h1>
    </div>
</section>

<div class="wrapper">
    <div class="container">
        <div class="questions">
            <div class="crud-rule-wide">

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

                <?php
                

                try {
                    $detail = new Quiz($db);
                    $quizData = $detail->loadQuiz($quizId); // Load quiz data
                
                    if ($quizData) {
                        // Display the quiz title in an input field
                        echo "<label for='quiz_title'>Quiz Title:</label>";
                        echo "<input type='text' id='quiz_title' name='quiz_title' value='" . htmlspecialchars($quizData['quiz_title']) . "' readonly>"; // readonly to prevent editing
                
                        // Display the quiz text in an input field
                        echo "<label for='quiz_text'>Quiz Text:</label>";
                        echo "<input type='text' id='quiz_text' name='quiz_text' value='" . htmlspecialchars($quizData['quiz_text']) . "' readonly>"; // readonly to prevent editing
                
                        // Load questions for this quiz
                        $questionsData = $detail->loadQuizQuestions($quizId);
                
                        if ($questionsData) {
                            foreach ($questionsData as $questionData) {
                                // Check if 'question_text' is set
                                if (isset($questionData['question_text'])) {
                                    echo "<p>Question: " . htmlspecialchars($questionData['question_text']) . "</p>";
                                } else {
                                    echo "<p style='color: red;'>Question text not found.</p>";
                                }
                            }
                        } else {
                            echo "<p style='color: red;'>No questions found for this quiz.</p>";
                        }
                    } else {
                        echo "<p style='color: red;'>Quiz not found.</p>";
                    }
                } catch (Exception $ex) {
                    echo "<p style='color: red;'>Error: " . htmlspecialchars($ex->getMessage()) . "</p>";
                }

                ?>
            
            </div>
        </div>
    </div>