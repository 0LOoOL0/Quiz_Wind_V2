<?php
if (isset($_GET['q'])) {
    $query = $_GET['q'];
    $stmt = $pdo->prepare("SELECT quiz_title FROM quizzes WHERE quiz_title LIKE :query");
    $stmt->execute(['query' => '%' . $query . '%']);

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if ($results) {
        foreach ($results as $result) {
            echo "<div>" . htmlspecialchars($result['quiz_title']) . "</div>";
        }
    } else {
        echo "<div>No results found.</div>";
    }
}
?>