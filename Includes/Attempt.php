<?php
class Attempt {
    private $db;
    private $quizId;
    private $userId;
    private $result;
    private $attemptTime;

    public function __construct($db) {
        $this->db = $db;
    }

    // Setters
    public function setQuizId($quizId) {
        $this->quizId = $quizId;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function setResult($result) {
        $this->result = $result;
    }

    public function setAttemptTime($attemptTime) {
        $this->attemptTime = $attemptTime;
    }

    // Save attempt to the database
    public function save() {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO attempts (quiz_id, user_id, result, attempt_time) 
                VALUES (:quiz_id, :user_id, :result, NOW())
            ");
            $stmt->execute([
                'quiz_id' => $this->quizId,
                'user_id' => $this->userId,
                'result' => $this->result
            ]);
        } catch (Exception $e) {
            throw new Exception("Error saving attempt: " . $e->getMessage());
        }
    }

    // Fetch the latest attempt for a specific quiz and user
    public function getLatestAttempt() {
        try {
            $stmt = $this->db->prepare("
                SELECT result, attempt_time 
                FROM attempts 
                WHERE quiz_id = :quiz_id AND user_id = :user_id 
                ORDER BY attempt_time DESC 
                LIMIT 1
            ");
            $stmt->execute(['quiz_id' => $this->quizId, 'user_id' => $this->userId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Error fetching latest attempt: " . $e->getMessage());
        }
    }

    // Fetch all attempts for a specific quiz and user
    public function getAllAttempts() {
        try {
            $stmt = $this->db->prepare("
                SELECT attempt_time, result 
                FROM attempts 
                WHERE quiz_id = :quiz_id AND user_id = :user_id 
                ORDER BY attempt_time DESC
            ");
            $stmt->execute(['quiz_id' => $this->quizId, 'user_id' => $this->userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Error fetching all attempts: " . $e->getMessage());
        }
    }
}
?>