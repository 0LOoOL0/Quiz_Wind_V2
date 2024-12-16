<?php
include 'header.php';
include 'Includes/auth.php';
include 'Includes/Answer_handler.php';

$userId = $_SESSION['user_id'] ?? null;

?>

<section class="content-head">
    <h1>Attempts</h1>
</section>

<div class="wrapper">
    <div class="container">
        <div class="users-table">
            <table>
                <?php

                $attempt = new Answer($db);
                $allAttempt = $attempt->allAttemptList($userId);

                if (!empty($allAttempt)) {
                    echo '<table>';
                    echo '<tr>
                        <th>Quiz Name</th>
                        <th>Score</th>
                        <th>Date Attempted</th>
                        </tr>';
                    foreach ($allAttempt as $attempt) {
                        echo "<tr>
                            
                        <!--<td>" . htmlspecialchars($attempt["user_id"]) . "</td>-->
                        <td>" . htmlspecialchars($attempt["quiz_title"]) . "</td>
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
    </div>
</div>