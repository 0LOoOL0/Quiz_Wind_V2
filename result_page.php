<?php

include 'header.php';
include 'Includes/auth.php';
include 'Includes/Answer_handler.php';
include 'Includes/Quiz_handler.php';

$userId = $_SESSION['user_id'] ?? null;
$quizId = $_GET['quiz_id'] ?? null;

$attempt = new Answer($db);
$score = $attempt->allAttemptList($userId, $quizId);

$totalQuestions = $attempt->countQuestionsByQuizId($quizId);
$correctQuestions = $attempt->countCorrectOptionsByQuizId($quizId);
$percentageCorrect = ((float)$correctQuestions / (float)$totalQuestions) * 100;

?>

<body class="page">
    <div class="wrapper">
        <div class="container">
            <div class="spaceup">
                <form action="Includes/Answer_handler.php">
                    <div class="results">

                        <?php

                        echo "<h1>Final Result</h1>";
                        echo "<p>" . number_format($percentageCorrect) . "%</p>";
                        if ($percentageCorrect >= 80) {
                            echo "<h2>Congrats!</h2>";
                        } elseif ($percentageCorrect >= 50) {
                            echo "<h2>Good Job!</h2>";
                        } else {
                            echo "<h2>Keep Trying!</h2>";
                        }

                        ?>

                    </div>

                    <div class="attempt-table">
                        <div class="cal">

                            <?php
                            echo "<h2>Number of total questions: " . htmlspecialchars($totalQuestions) . "</h2>";
                            echo "<h2>Number of correct questions: " . htmlspecialchars($correctQuestions) . "</h2>";
                            echo "<h2>precentage: " . round($percentageCorrect, 2) . " %</h2>";
                            ?>

                        </div>
                        <div class="attempt-count">

                            <?php
                            $attemptCount = new Attempt($db);
                            $attemptCounts = $attemptCount->countAttempts($userId, $quizId);
                            echo "<h2>Number of Attempts: " . htmlspecialchars($attemptCounts) . "</h2>"; // Use $attemptCounts to get the count
                            ?>

                        </div>
                        <table>

                            <?php
                            $attemptList = $attempt->attemptList($userId, $quizId);

                            if (!empty($attemptList)) {
                                echo '<table><tr>
                                    <th>Score</th>
                                    <th>Date attempt</th>
                                </tr>';
                                foreach ($attemptList as $attempt) {
                                    echo "<tr>
                                    <td>" . htmlspecialchars($attempt["total_score"]) . "</td>
                                    <td>" . htmlspecialchars($attempt["created_at"]) . "</td>
                                </tr>";
                                }
                                echo "</table>";
                            } else {
                                echo "Theres are no subjects avilable, Create new one!";
                            }
                            ?>

                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>