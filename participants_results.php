<?php
include 'header.php';
include 'Includes/auth.php';
include 'Includes/Participant_handler.php';

$quizId = isset($_GET['quiz_id']) ? intval($_GET['quiz_id']) : null;
$userId = $_SESSION['user_id'] ?? null;
?>

<section class="content-head">
    <h1>Participants</h1>
</section>

<div class="wrapper">
    <div class="container">
        <div class="participants">
            <!-- <div class="search-content">
                <input type="search" id="search" placeholder="Search">
                <button class="button3">Search</button>
                <button class="button3" id="add">Reset All</button>
                <div class="sorting">
                    <button class="button3">Highest</button>
                    <button class="button3">Lowest</button>
                    <button class="button3">Average</button>
                </div>
            </div> -->

                        <!-- Chart Container -->
                        <div class="chart-container">
                <canvas id="scoreChart"></canvas>
            </div>

            <div class="users-table">
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
                            
                            // Prepare data for the pie chart
                            $scores = [];
                            foreach ($participantList as $p) {
                                echo "<tr>
                                        <td>" . htmlspecialchars($p["username"]) . "</td>
                                        <td>" . htmlspecialchars($p["quiz_title"]) . "</td>
                                        <td>" . htmlspecialchars($p["total_score"]) . "</td>
                                        <td>" . htmlspecialchars($p["created_at"]) . "</td>
                                    </tr>";
                                // Collect total scores for the pie chart
                                $scores[$p["quiz_title"]] = ($scores[$p["quiz_title"]] ?? 0) + $p["total_score"];
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Prepare data for the pie chart
    const scores = <?php echo json_encode(array_values($scores)); ?>;
    const quizTitles = <?php echo json_encode(array_keys($scores)); ?>;

    // Create the pie chart
    const ctx = document.getElementById('scoreChart').getContext('2d');
    const scoreChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: quizTitles,
            datasets: [{
                label: 'Total Scores',
                data: scores,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Total Scores by Quiz Title'
                }
            },
            layout: {
                padding: {
                    left: 20,
                    right: 20,
                    top: 20,
                    bottom: 20
                }
            },
            elements: {
                arc: {
                    borderWidth: 1 // Ensures a clear separation between pie sections
                }
            }
        }
    });

    // Set the background color of the canvas to white
    document.getElementById('scoreChart').style.backgroundColor = 'white';
</script>
