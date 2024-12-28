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

    public function saveAnswers($userId, $quizId, $answers) {
        // Prepare the SQL statement with named parameters
        $sqlInsert = "INSERT INTO answers (question_id, selected_option_id, score, user_id, quiz_id) 
                      VALUES (:question_id, :selected_option_id, :score, :user_id, :quiz_id)";
        
        // Loop through the answers and execute the prepared statement for each
        foreach ($answers as $questionId => $answer) {
            // Default selected_option_id to null
            $selectedOptionId = null; 
            $score = 0; // Default score to 0
    
            // Check if an option is selected
            if (isset($answer['selected_option_id']) && $answer['selected_option_id'] !== null) {
                // Set the selected option ID if an option is selected
                $selectedOptionId = $answer['selected_option_id'];
                // If an option is selected, set the score accordingly
                $score = isset($answer['score']) ? $answer['score'] : 0; // Use the provided score or default to 0
            }
    
            // If no option was selected, you may decide to skip the insertion.
            // Uncomment the next line if you do not want to save anything if no option is selected.
            // if ($selectedOptionId === null) continue;
    
            // Execute the statement using the queryStatement method
            $this->db->queryStatement($sqlInsert, [
                ':question_id' => $questionId,
                ':selected_option_id' => $selectedOptionId, // This can be null
                ':score' => $score,
                ':user_id' => $userId,
                ':quiz_id' => $quizId
            ]);
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

       //counting questions
       public function countQuestionsByQuizId($quizId)
       {
   
           $sql = "SELECT COUNT(*) AS question_count FROM questions WHERE quiz_id = :quiz_id";
           $stmt = $this->db->queryStatement($sql, [':quiz_id' => $quizId]);
           $result = $stmt->fetch(PDO::FETCH_ASSOC);
           return $result ? (int)$result['question_count'] : 0; // Return 0 if no result
       }
   
       //counting only correct questions
       public function countCorrectOptionsByQuizId($quizId, $userId) {
           $sql = "SELECT COUNT(*) AS correct_option_count
                   FROM questions q
                   JOIN (
                       SELECT question_id, MAX(created_at) AS latest_answer_time
                       FROM answers
                       WHERE user_id = :user_id
                       GROUP BY question_id
                   ) AS latest_answers ON q.question_id = latest_answers.question_id
                   JOIN answers a ON latest_answers.question_id = a.question_id 
                       AND latest_answers.latest_answer_time = a.created_at
                   JOIN options o ON a.selected_option_id = o.option_id
                   WHERE q.quiz_id = :quiz_id AND o.is_correct = 1";
       
           $stmt = $this->db->queryStatement($sql, [':quiz_id' => $quizId, ':user_id' => $userId]);
           $result = $stmt->fetch(PDO::FETCH_ASSOC);
       
           return $result ? (int)$result['correct_option_count'] : 0;
       }
   
       public function calculatePercentageCorrectByQuizId($quizId, $userId) {
           // Count total questions
           $totalQuestions = $this->countQuestionsByQuizId($quizId);
           
           // Count correct answers
           $correctQuestions = $this->countCorrectOptionsByQuizId($quizId, $userId);
           
           // Calculate the percentage
           $percentageCorrect = ($totalQuestions > 0) ? ((float)$correctQuestions / (float)$totalQuestions) * 100 : 0;
           
           return $percentageCorrect;
       }


    function allAttemptList($userId)
    {
        try {
            $sql = "SELECT a.*, q.quiz_title
            FROM attempts a 
            JOIN quizzes q ON a.quiz_id = q.quiz_id 
            WHERE a.user_id = :user_id
            ORDER BY a.created_at DESC";
            $stmt = $this->db->queryStatement($sql, [':user_id' => $userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $ex) {
            echo "Something went wrong: " . $ex->getMessage();
        }
    }
    


    function getParticipant()
    {
        $sql = "SELECT a.*, u.username, q.quiz_title
                FROM users u
                JOIN attempts a ON u.user_id = a.user_id
                JOIN quizzes q ON a.quiz_id = q.quiz_id
                WHERE a.user_id = 24
                AND a.attempt_id = (
                    SELECT MAX(a2.attempt_id)
                    FROM attempts a2
                    WHERE a2.quiz_id = a.quiz_id AND a2.user_id = a.user_id
                )
                GROUP BY q.quiz_title, u.username;";


        $stmt = $this->db->queryStatement($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Teacher get participants by id
    function getParticipantById($quizId)
    {
        $sql = "SELECT q.*, a.total_score, u.username 
            FROM quizzes q 
            JOIN attempts a ON a.quiz_id = q.quiz_id 
            JOIN users u ON a.user_id = u.user_id 
            WHERE q.quiz_id = :quiz_id";

        $stmt = $this->db->queryStatement($sql, [
            ':quiz_id' => $quizId
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
