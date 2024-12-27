<?php
require_once 'Subject.php'; // Include your Subject class

header('Content-Type: application/json'); // Set content type to JSON

if (isset($_GET['subject_id'])) {
    // Sanitize the input to prevent XSS
    $subjectId = htmlspecialchars($_GET['subject_id']);
    
    // Create an instance of the Subject class
    $subjectDetail = new Subject($db);
    
    // Fetch subject details
    $detail = $subjectDetail->getSubjectsDetailById($subjectId);
    
    // Return subject details as a JSON response
    if ($detail) {
        echo json_encode($detail);
    } else {
        echo json_encode(['success' => false, 'message' => 'Subject not found.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}

//update subject details
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updated'])) {
    
    $subjectId = $_POST['subject_id']; 
    $subjectName = $_POST['subject_name']; 
    $subjectDescription = $_POST['subject_text'];
    $assignedTeachers = $_POST['assigned_to'] ?? [];

    try {
        $subject = new Subject($db);
        
        // Update subject information
        $result = $subject->updateSubject($subjectId, $subjectName, $subjectDescription);

        if ($result['success']) {
            // Now handle the assigned teachers if needed
            if (!empty($assignedTeachers)) {
                // Assuming you have a method to update assigned teachers
                $subject->updateAssignedTeachers($subjectId, $assignedTeachers);
            }

            // Redirect to the subject page after successful update
            header("Location: ../subject_page.php");
            exit();
        } else {
            echo "Failed to update subject information.";
        }

    } catch (Exception $e) {
        // Handle any exceptions that occur
        echo "Error: " . htmlspecialchars($e->getMessage());
    }
}

?>