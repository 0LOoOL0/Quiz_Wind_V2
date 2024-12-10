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

    public function listQuestion() {
        // SQL query to fetch questions and their associated options
        $sql = "SELECT q.question_id AS question_id, q.question_text, o.option_id AS option_id, o.option_text
                FROM questions q
                LEFT JOIN options o ON q.question_id = o.question_id";
        
        // Execute the query
        $stmt = $this->db->queryStatement($sql);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Organize the results into a structured array
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
            
            // Add option only if it exists
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
    

    // display all chapters
    public function optionList()
    {
        try {
            $sql = "SELECT option_text, is_correct FROM options WHERE question_id = 1";
            $stmt = $this->db->queryStatement($sql);

            if ($stmt) {
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if (empty($result)) {
                    echo "No teachers found.";
                }
                return $result;
            } else {
                echo "Query failed.";
            }
        } catch (Exception $ex) {
            echo "Something went wrong: " . $ex->getMessage();
        }
    }

    // Function to delete a quiz
    public function deleteQuestion()
    {
        $stmt = $this->db->prepare("DELETE FROM question WHERE question_id = :question_id");
        $stmt->bindParam(':question_id', $this->questionId);
        return $stmt->execute();
    }

}
