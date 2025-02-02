<?php
include 'header.php';
include 'Includes/auth.php';
include 'Includes/Participant_handler.php';
include 'Includes/Quiz_handler.php';

$quizId = isset($_GET['quiz_id']) ? intval($_GET['quiz_id']) : null;
$userId = $_SESSION['user_id'] ?? null;

if ($_SESSION['role_name'] !== 'Teacher') {
    echo '<div class="spaceMessage">
            <div class = "denied">
             <h2>Access Denied</h2>
            </div>
        </div>';
    die();
}

$result = new Quiz($db);
$highestScore = $result->highScore($quizId);
$lowestScore = $result->lowScore($quizId);
$averageScore = $result->averageScore($quizId);
?>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    canvas {
        max-width: 600px;
        margin: auto;
    }

    .chart-container {
        /* width: 50%; */
        max-width: 800px;
        height: 400px;
        margin: 30px;
        padding: 20px;
        box-sizing: border-box;
        background: white;
        border-radius: 20px;
        box-shadow: 1px 3px 1px rgba(0, 0, 0, 0.2);
    }
</style>

<body>

    <div class="overlay2">
        <section class="content-head3">
            <h1>Results</h1>
        </section>
    </div>

    <div class="wrapper">
        <div class="container">
            <div class="participants">

                <div class="chart-container">
                    <canvas id="scoreChart" width="1000" height="600"></canvas>
                </div>

                <div class="users-table">
                    <div class="calResults">
                        <h2>Highest Score: <?php echo htmlspecialchars($highestScore); ?></h2>
                        <h2>Lowest Score: <?php echo htmlspecialchars($lowestScore); ?></h2>
                        <h2>Average Score: <?php echo htmlspecialchars($averageScore); ?></h2>
                    </div>
                    <table>
                        <?php
                        $participant = new Answer($db);
                        $participantList = $participant->getParticipantById($quizId);

                        if (!empty($participantList)) {
                            echo "<tr>
                                <th>Username</th>
                                <th>Quiz Title</th>
                                <th>Total Score</th>
                                <th>Date Taken</th>
                            </tr>";

                            foreach ($participantList as $p) {
                                echo "<tr>
                                    <td>" . htmlspecialchars($p["username"]) . "</td>
                                    <td>" . htmlspecialchars($p["quiz_title"]) . "</td>
                                    <td>" . htmlspecialchars($p["total_score"]) . "</td>
                                    <td>" . htmlspecialchars($p["created_at"]) . "</td>
                                </tr>";
                            }
                        } else {
                            echo "<p>No results found.</p>";
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
    const highestScore = <?php echo json_encode((float)$highestScore); ?>;
    const lowestScore = <?php echo json_encode((float)$lowestScore); ?>;
    const averageScore = <?php echo json_encode((float)$averageScore); ?>;

    const ctx = document.getElementById('scoreChart').getContext('2d');
    const scoreChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Highest Score', 'Lowest Score', 'Average Score'],
            datasets: [{
                label: 'Scores',
                data: [highestScore, lowestScore, averageScore],
                backgroundColor: ['#2564ac', '#2564ac', '#2564ac'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Score',
                        font: {
                            size: 20
                        }
                    },
                    ticks: {
                        font: {
                            size: 20
                        }
                    }
                },
                x: {
                    ticks: {
                        font: {
                            size: 20
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: false,
                    labels: {
                        font: {
                            size: 20
                        }
                    }
                }
            }
        }
    });
</script>

</body>