<?php

include 'Database_handler.php';
class Attempt {
    private $db;

    private $attemptId;
    private $userId;
    private $quizId;
    private $attemptNumber;
    private $totalScore;

    public function __construct($db) {
        $this->db = $db;

        $this->attemptId = null;
        $this->userId = null;
        $this->quizId = null;
        $this->attemptId = null;
        $this->attemptNumber = null;
        $this->totalScore = null;
    }

    public function getAttemptId()
    {
        return $this->attemptId;
    }

    public function setAttemptId($attemptId)
    {
        $this->attemptId = $attemptId;

        return $this;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    public function getQuizId()
    {
        return $this->quizId;
    }

    public function setQuizId($quizId)
    {
        $this->quizId = $quizId;

        return $this;
    }

    public function getAttemptNumber()
    {
        return $this->attemptNumber;
    }

    public function setAttemptNumber($attemptNumber)
    {
        $this->attemptNumber = $attemptNumber;

        return $this;
    }

    public function getTotalScore()
    {
        return $this->totalScore;
    }

    public function setTotalScore($totalScore)
    {
        $this->totalScore = $totalScore;

        return $this;
    }

    // Function to calculate the number of attempts for a user on a specific quiz
    public function calculateAttempts($userId, $quizId) {
        $sql = "SELECT COUNT(*) as attempt_number FROM attempts 
                WHERE user_id = :user_id AND quiz_id = :quiz_id";
        
        $stmt = $this->db->queryStatement($sql, [
            ':user_id' => $userId,
            ':quiz_id' => $quizId
        ]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['attempt_number'];
    }

    // Function to save a new attempt
    public function saveAttempt($userId, $quizId, $attemptNumber, $totalScore) {
        $sql = "INSERT INTO attempts (user_id, quiz_id, attempt_number, total_score) 
                VALUES (:user_id, :quiz_id, :attempt_number, :total_score)";
        
        $this->db->queryStatement($sql, [
            ':user_id' => $userId,
            ':quiz_id' => $quizId,
            ':attempt_number' => $attemptNumber,
            ':total_score' => $totalScore
        ]);
    }

    // Function to calculate the total score based on provided answers
    // public function calculateTotalScore($answers) {
    //     $totalScore = 0.00;

    //     foreach ($answers as $answer) {
    //         $selectedOptionId = $answer['selected_option_id'];
    //         $questionId = $answer['question_id'];

    //         // Check if the selected option is correct
    //         $sqlCheck = "SELECT is_correct, score FROM options 
    //                      JOIN questions ON options.question_id = questions.question_id 
    //                      WHERE options.option_id = :option_id AND questions.question_id = :question_id";
            
    //         $stmt = $this->db->queryStatement($sqlCheck, [
    //             ':option_id' => $selectedOptionId,
    //             ':question_id' => $questionId
    //         ]);

    //         $result = $stmt->fetch(PDO::FETCH_ASSOC);
    //         if ($result && $result['is_correct']) {
    //             $totalScore += $result['score']; // Add score if the answer is correct
    //         }
    //     }

    //     return $totalScore;
    // }

    public function countAttempts($userId, $quizId) {
        $sql = "SELECT COUNT(*) AS attempt_count 
                FROM attempts 
                WHERE user_id = :user_id AND quiz_id = :quiz_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $userId, ':quiz_id' => $quizId]);
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result['attempt_count'];
    }

    public function hasUserAlreadySubmitted($userId, $quizId) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM attempts WHERE user_id = :user_id AND quiz_id = :quiz_id");
        $stmt->execute([':user_id' => $userId, ':quiz_id' => $quizId]);
        return $stmt->fetchColumn() > 0; // Returns true if there are any submissions
    }

}
?>