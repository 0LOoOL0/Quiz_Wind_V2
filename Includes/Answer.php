<?php

include 'Database_handler.php';

class Answer
{

    private $db;
    private $questionId;
    private $selectedOptionId;
    private $userId;
    private $score;

    private $attemptId;
    private $attemptNumber;
    private $totalScore;

    public function __construct($db)
    {
        $this->db = $db;

        $this->questionId = null;
        $this->selectedOptionId = null;
        $this->userId = null;
        $this->score = null;

        $this->attemptNumber = null;
        $this->attemptId = null;
        $this->totalScore = null;
    }

    public function getQuestionId()
    {
        return $this->questionId;
    }

    public function setQuestionId($questionId)
    {
        $this->questionId = $questionId;

        return $this;
    }

    public function getSelectedOptionId()
    {
        return $this->selectedOptionId;
    }

    public function setSelectedOptionId($selectedOptionId)
    {
        $this->selectedOptionId = $selectedOptionId;

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

    public function getScore()
    {
        return $this->score;
    }

    public function setScore($score)
    {
        $this->score = $score;

        return $this;
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

    public function saveAnswers($userId, $quizId, $answers)
    {
        $sqlInsert = "INSERT INTO answers (question_id, selected_option_id, score, user_id, quiz_id) 
                      VALUES (:question_id, :selected_option_id, :score, :user_id, :quiz_id)";

        // Start a transaction
        $this->db->beginTransaction();

        try {
            foreach ($answers as $answer) {
                // Get the selected option ID
                $selectedOptionId = $answer['selected_option_id'];
                $questionId = $answer['question_id'];

                // Retrieve if the selected option is correct and get the corresponding score
                $sqlCheck = "SELECT is_correct, score FROM options 
                             JOIN questions ON options.question_id = questions.question_id 
                             WHERE options.option_id = :option_id AND questions.question_id = :question_id";

                $stmt = $this->db->queryStatement($sqlCheck, [
                    ':option_id' => $selectedOptionId,
                    ':question_id' => $questionId
                ]);

                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $score = 0.00;

                if ($result) {
                    // If the selected option is correct, use the defined score or the default score
                    if ($result['is_correct']) {
                        $score = $result['score'];
                    }
                }

                // Add to answers array with the calculated score
                $stmtInsert = $this->db->queryStatement($sqlInsert, [
                    ':question_id' => $questionId,
                    ':selected_option_id' => $selectedOptionId,
                    ':score' => $score,
                    ':user_id' => $userId,
                    ':quiz_id' => $quizId
                ]);
            }

            // Commit the transaction
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            // Rollback the transaction on error
            $this->db->rollBack();
            echo "Error: " . htmlspecialchars($e->getMessage());
            return false;
        }
    }

    function listAttempts($userId)
    {
        $stmt = $this->db->prepare("SELECT attempt FROM answers WHERE option_id = :user_id");
        $stmt->execute(['id' => $this->selectedOptionId]);
        $option = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->score = $option ? $option['score'] : 0;
    }

    // public function getAttemptsByUser($userId) {
    //     $sql = "SELECT a.attempt_id, a.quiz_id, a.attempt_number, a.total_score, a.created_at, 
    //                    q.quiz_text 
    //             FROM attempts a
    //             JOIN quizzes q ON a.quiz_id = q.quiz_id
    //             WHERE a.user_id = :user_id 
    //             ORDER BY a.created_at DESC";

    //     try {
    //         $stmt = $this->db->queryStatement($sql, [':user_id' => $userId]);
    //         if (!$stmt) {
    //             throw new Exception("Query failed: " . implode(", ", $this->db->errorInfo()));
    //         }
    //         return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all attempts as an associative array
    //     } catch (Exception $e) {
    //         echo "Error: " . $e->getMessage();
    //         return []; // Return an empty array on error
    //     }
    // }

    //checkpoint
    public function getAttemptsByUserAndQuiz($userId, $quizId)
    {
        $sql = "SELECT a.attempt_id, a.quiz_id, a.attempt_number, a.total_score, a.created_at, 
        q.quiz_text
        FROM attempts a
        JOIN quizzes q ON a.quiz_id = q.quiz_id
        WHERE a.user_id = :user_id AND a.quiz_id = :quiz_id
        ORDER BY a.created_at DESC";

        try {
            $stmt = $this->db->queryStatement($sql, [
                ':user_id' => $userId,
                ':quiz_id' => $quizId
            ]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all attempts as an associative array
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return []; // Return an empty array on error
        }
    }

    function attemptList($userId, $quizId)
    {
        try {
            $sql = "SELECT * FROM attempts WHERE user_id = :user_id AND quiz_id = :quiz_id";
            $stmt = $this->db->queryStatement($sql, [':user_id' => $userId, ':quiz_id' => $quizId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $ex) {
            echo "Something went wrong: " . $ex->getMessage();
        }
    }

    public function calculateScore()
    {
        $stmt = $this->db->prepare("SELECT score FROM options WHERE option_id = :option_id");
        $stmt->execute(['id' => $this->selectedOptionId]);
        $option = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->score = $option ? $option['score'] : 0;
    }

    // Function to calculate the number of attempts for a user on a specific quiz
    public function calculateAttempts($userId, $quizId)
    {
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
    public function saveAttempt($userId, $quizId, $attemptNumber, $totalScore)
    {
        $maxScore = 100; // Assuming the max score of the quiz is 100
        // Calculate the percentage score
        $percentageScore = ($maxScore > 0) ? ($totalScore / $maxScore) * 100 : 0;

        // Ensure the percentage score doesn't exceed the DECIMAL(5,2) limits
        if ($percentageScore > 100) {
            $percentageScore = 100; // Cap it at 100 if it exceeds
        }

        // Prepare the SQL statement for insertion
        $sql = "INSERT INTO attempts (user_id, quiz_id, attempt_number, total_score) 
                VALUES (:user_id, :quiz_id, :attempt_number, :total_score)";

        try {
            $this->db->queryStatement($sql, [
                ':user_id' => $userId,
                ':quiz_id' => $quizId,
                ':attempt_number' => $attemptNumber,
                ':total_score' => number_format($percentageScore, 2, '.', '') // Format to 2 decimal places
            ]);
            echo "Attempt saved successfully."; // Confirmation message
        } catch (Exception $ex) {
            echo "Error saving attempt: " . $ex->getMessage();
        }
    }

    // Function to calculate the total score based on provided answers
    public function calculateTotalScore($answers)
    {
        $totalScore = 0.00;

        foreach ($answers as $answer) {
            $selectedOptionId = $answer['selected_option_id'];
            $questionId = $answer['question_id'];

            // Check if the selected option is correct
            $sqlCheck = "SELECT is_correct, score FROM options 
                         JOIN questions ON options.question_id = questions.question_id 
                         WHERE options.option_id = :option_id AND questions.question_id = :question_id";

            $stmt = $this->db->queryStatement($sqlCheck, [
                ':option_id' => $selectedOptionId,
                ':question_id' => $questionId
            ]);

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result && $result['is_correct']) {
                $totalScore += $result['score']; // Add score if the answer is correct
            }
        }

        return $totalScore;
    }

    function displayAttemptFeedback($attemptList)
    {
        if (!empty($attemptList)) {
            $latestAttempt = $attemptList[0]; // Get the latest attempt
            $totalScore = $latestAttempt['total_score'];

            $maxScore = 100; // Assuming the max score is 100
            $percentage = ($maxScore > 0) ? ($totalScore / $maxScore) * 100 : 0; // Avoid division by zero

            echo "<p>" . number_format($percentage, 2) . "%</p>";
            echo "<h2>" . htmlspecialchars($totalScore) . "</h2>"; // Display total score

            if ($percentage >= 80) {
                echo "<h2>Congrats!</h2>"; // High score
            } elseif ($percentage >= 50) {
                echo "<h2>Good Job!</h2>"; // Average score
            } else {
                echo "<h2>Keep Trying!</h2>"; // Low score
            }
        } else {
            echo "No Attempts found for this User on this Quiz.";
        }
    }

    function allAttemptList($userId)
    {
        try {
            $sql = "SELECT a.*, q.quiz_title
        FROM attempts a 
        JOIN quizzes q ON a.quiz_id = q.quiz_id 
        WHERE a.user_id = :user_id";
            $stmt = $this->db->queryStatement($sql, [':user_id' => $userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $ex) {
            echo "Something went wrong: " . $ex->getMessage();
        }
    }


    // public function saveAnswer() {
    //     $stmt = $this->db->prepare("INSERT INTO answers (question_id, selected_option_id, score, user_id) VALUES (:question_id, :selected_option_id, :score, :user_id)");
    //     $stmt->execute([
    //         'question_id' => $this->questionId,
    //         'selected_option_id' => $this->selectedOptionId,
    //         'score' => $this->score,
    //         'user_id' => $this->userId
    //     ]);
    // }

}
