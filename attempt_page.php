<?php
include 'header.php';
include 'Includes/auth.php';
include 'Includes/Answer_handler.php';

$userId = $_SESSION['user_id'] ?? null;

if ($_SESSION['role_name'] !== 'Student') {
    echo '<div class="spaceMessage">
            <div class = "denied">
             <h2>Access Denied</h2>
            </div>
        </div>';
    die();
}
?>

<div class="overlay2">
    <section class="content-head3">
        <h1>
            Attempts
        </h1>
    </section>
</div>

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
                    echo "no Attempts are available!";
                }

                ?>
            </table>
        </div>
    </div>
</div>