<?php
include 'header.php';
include 'Includes/auth.php';
include 'Includes/Answer_handler.php';

$userId = $_SESSION['user_id'] ?? null;
$quizId = $_GET['quiz_id'] ?? null;

$attempt = new Answer($db);
$score = $attempt->allAttemptList($userId, $quizId);
?>

<body class="page11">
    <div class="wrapper">
        <div class="container">
            <div class="spaceup">
                <form action="Includes/Answer_handler.php">
                    <div class="results">
                        <!-- <h1>Final Result</h1>
                        <p>100%</p>
                        <h2>Congrats!</h2> -->

                        <?php
                        
                        $attemptId = 1;
                        $test = new Answer($db);
                        $testScore = $test->convertScore($attemptId);


                        echo "<h1>Final Result</h1>";

                        $percentage = 50;

                        echo "<p>" . number_format($percentage) . "%</p>";
                            if ($percentage >= 80) {
                                echo "<h2>Congrats!</h2>"; // High score
                            } elseif ($percentage >= 50) {
                                echo "<h2>Good Job!</h2>"; // Average score
                            } else {
                                echo "<h2>Keep Trying!</h2>"; // Low score
                            }

                            
                        
                        
                        // echo "User ID: " . htmlspecialchars($userId) . "<br>";
                        // echo "Quiz ID: " . htmlspecialchars($quizId) . "<br>";
                        
                        // if (!empty($attemptList)) {
                        //     $latestAttempt = $attemptList[0]; // Get the latest attempt
                        //     $totalScore = $latestAttempt['total_score'];
                            
                        //     $maxScore = 100; // Assuming the max score is 100
                        //     $percentage = ($totalScore / $maxScore) * 100;
                        
                        //     echo "<p>" . number_format($percentage, 2) . "%</p>";
                        //     echo "<h2>" . htmlspecialchars($latestAttempt["total_score"]) . "</h2>"; // Corrected variable name
                        
                            
                        //     if ($percentage >= 80) {
                        //         echo "<h2>Congrats!</h2>"; // High score
                        //     } elseif ($percentage >= 50) {
                        //         echo "<h2>Good Job!</h2>"; // Average score
                        //     } else {
                        //         echo "<h2>Keep Trying!</h2>"; // Low score
                        //     }
                        // } else {
                        //     echo "No Attempts found for this User on this Quiz.";
                        // }
                        ?>

                    </div>
                    <div class="attempt-table">
                        <table>
                            <tr>
                                <th>ID</th>
                                <th>Score</th>
                                <th>Date attempt</th>
                            </tr>

                            <?php
                            //checpoint quiz -id
                            
                            //$attemptList = $attempt->getAttemptsByUser($userId);
                            $attemptList = $attempt->attemptList($userId, $quizId);

                            if (!empty($attemptList)) {
                                echo '<table>';
                                foreach ($attemptList as $attempt) {
                                    echo "<tr>
                                    
                                <!--<td>" . htmlspecialchars($attempt["user_id"]) . "</td>-->
                                <td></td>
                                <td>" . htmlspecialchars($attempt["attempt_number"]) . "</td>
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