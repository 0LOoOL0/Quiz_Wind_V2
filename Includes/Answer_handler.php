<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id']; // Example user identifier
    $answers = $_POST['options']; // Assuming your form uses the name "options"

    foreach ($answers as $questionId => $optionId) {
        // Save each answer to the database
        $db->saveAnswer($userId, $questionId, $optionId);
    }

    echo json_encode(['status' => 'success']);
}

?>