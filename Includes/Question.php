<?php

include 'Database_handler.php';
class Question
{

    private $db;
    private $questionId;
    private $questionText;
    private $quizId;
    private $score;


    public function __construct(Database $db)
    {
        $this->db = $db;

        $this->questionId = null;
        $this->questionText = null;
        $this->quizId = null;
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

    public function getQuestionText()
    {
        return $this->questionText;
    }


    public function setQuestionText($questionText)
    {
        $this->questionText = $questionText;

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

    public function getScore()
    {
        return $this->score;
    }

    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    function createQuestion()
    {
        if ($this->questionText && $this->quizId && $this->score) {

            $sql = "INSERT INTO questions (question_text, quiz_id, score) VALUES (:question_text, :quiz_id, :score)";

            $this->db->queryStatement($sql, [
                ':question_text' => $this->questionText,
                ':quiz_id' => $this->quizId,
                ':score' => $this->score
            ]);

            return $this->db->getConnection()->lastInsertId(); // Correct method call
        } else {
            throw new Exception("Must set values for question");
        }

    }

    // function listQuestion()
    // {
    //     try {
    //         $sql = "Select * from questions";
    //         $stmt = $this->db->queryStatement($sql);
    //         return $stmt->fetchAll(PDO::FETCH_ASSOC);
    //     } catch (Exception $ex) {
    //         echo "Something went wrong: " . $ex->getMessage();
    //     }
    // }

   
    // public function listQuestion($quizId) {
    //     $sql = "SELECT q.question_id AS question_id, 
    //                    q.question_text, 
    //                    o.option_id AS option_id, 
    //                    o.option_text,
    //                    quiz.timer AS timer
    //             FROM questions q
    //             LEFT JOIN options o ON q.question_id = o.question_id
    //             JOIN quizzes quiz ON q.quiz_id = quiz.quiz_id
    //             WHERE q.quiz_id = :quiz_id"; 

    //     $stmt = $this->db->queryStatement($sql, [':quiz_id' => $quizId]);
    //     $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //     $questionList = [];
    //     $timer = null;
    //     foreach ($results as $row) {
    //         if ($timer === null) {
    //             $timer = $row['timer'];
    //         }
    //         if (!isset($questionList[$row['question_id']])) {
    //             $questionList[$row['question_id']] = [
    //                 'id' => $row['question_id'],
    //                 'question_text' => $row['question_text'],
    //                 'optionList' => []
    //             ];
    //         }
    //         if ($row['option_id'] !== null) {
    //             $questionList[$row['question_id']]['optionList'][] = [
    //                 'id' => $row['option_id'],
    //                 'option_text' => $row['option_text']
    //             ];
    //         }
    //     }

    //     return [
    //         'questions' => array_values($questionList),
    //         'timer' => $timer
    //     ];
    // }
    public function listQuestion($quizId) {
        
        $sql = "SELECT q.question_id AS question_id, q.question_text, o.option_id AS option_id, o.option_text
                FROM questions q
                LEFT JOIN options o ON q.question_id = o.question_id WHERE q.quiz_id = :quiz_id";
    
  
        $stmt = $this->db->prepare($sql);
       
        $stmt->bindParam(':quiz_id', $quizId, PDO::PARAM_INT);
        
     
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $questionList = [];
        foreach ($results as $row) {
            // Initialize question if it doesn't exist
            if (!isset($questionList[$row['question_id']])) {
                $questionList[$row['question_id']] = [
                    'id' => $row['question_id'],
                    'question_text' => $row['question_text'],
                    'optionList' => [] // Initialize options array
                ];
            }
            
            if ($row['option_id'] !== null) {
                $questionList[$row['question_id']]['optionList'][] = [
                    'id' => $row['option_id'],
                    'option_text' => $row['option_text']
                ];
            }
        }
    
        // Return reindexed array of questions
        return array_values($questionList);
    }

    function quizTimer($quizId) {
        $sql = "SELECT timer, quiz_title FROM quizzes WHERE quiz_id = :quiz_id";
        $stmt = $this->db->queryStatement($sql, [':quiz_id' => $quizId]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    public function optionList($questionId) {
        try {
            $sql = "SELECT option_text, is_correct FROM options WHERE question_id = :question_id";
            $stmt = $this->db->queryStatement($sql, [':question_id' => $questionId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $ex) {
            echo "Something went wrong: " . $ex->getMessage();
        }
    }

    public function deleteQuestion() {
        $stmt = $this->db->prepare("DELETE FROM questions WHERE question_id = :question_id");
        $stmt->bindParam(':question_id', $this->questionId);
        return $stmt->execute();
    }

}
