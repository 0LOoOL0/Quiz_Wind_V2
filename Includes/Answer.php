<?php

include 'Database_handler.php';

class Answer
{

    private $db;
    private $questionId;
    private $selectedOptionId;
    private $userId;
    private $score;

    public function __construct($db)
    {
        $this->db = $db;

        $this->questionId = null;
        $this->selectedOptionId = null;
        $this->userId = null;
        $this->score = null;
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

    // function saveAnswer($userId) {
    //     // Prepare the SQL statement
    //     $sql = "INSERT INTO answers (question_id, selected_option_id, score, user_id) VALUES (:question_id, :selected_option_id, :score, :user_id)";

    //     // Execute the statement using the provided parameters
    //     $stmt = $this->db->queryStatement($sql, [
    //         ':question_id' => $this->questionId,
    //         ':selected_option_id' => $this->selectedOptionId,
    //         ':score' => $this->score,
    //         ':user_id' => $userId // Use the parameter passed to the function
    //     ]);

    //     // Return the number of affected rows to indicate success
    //     return $stmt->rowCount() > 0; // true if at least one row was inserted
    // }


    public function saveAnswers($userId, $quizId, $answers) {
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
    
    function listAttempts($userId) {
        $stmt = $this->db->prepare("SELECT attempt FROM answers WHERE option_id = :user_id");
        $stmt->execute(['id' => $this->selectedOptionId]);
        $option = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->score = $option ? $option['score'] : 0;
    }


    public function calculateScore()
    {
        $stmt = $this->db->prepare("SELECT score FROM options WHERE option_id = :option_id");
        $stmt->execute(['id' => $this->selectedOptionId]);
        $option = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->score = $option ? $option['score'] : 0;
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
