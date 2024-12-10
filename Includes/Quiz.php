<?php

include 'Database_handler.php';

class Quiz
{

    private $db;
    private $quizId;
    private $quizTitle;
    private $quizText;
    private $chapterId;
    private $timer;
    private $createdBy;
    
    //for select
    private $chapterName;


    public function __construct(Database $db)
    {
        $this->db = $db;

        $this->quizId = null;
        $this->quizTitle = null;
        $this->quizText = null;
        $this->chapterId = null;
        $this->timer = null;
        $this->createdBy = null;
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

    public function getQuizTitle()
    {
        return $this->quizTitle;
    }

    public function setQuizTitle($quizTitle)
    {
        $this->quizTitle = $quizTitle;

        return $this;
    }

    public function getQuizText()
    {
        return $this->quizText;
    }

    public function setQuizText($quizText)
    {
        $this->quizText = $quizText;

        return $this;
    }

    public function getChapterId()
    {
        return $this->chapterId;
    }

    public function setChapterId($chapterId)
    {
        $this->chapterId = $chapterId;

        return $this;
    }

    public function getTimer()
    {
        return $this->timer;
    }

    public function setTimer($timer)
    {
        $this->timer = $timer;

        return $this;
    }

    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }
    
    //for select chapter for the quiz
    function chapterList()
    {
        try {
            $sql = "SELECT chapter_id, chapter_title, subject_id FROM chapters WHERE subject_id = 1";
            $stmt = $this->db->queryStatement($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $ex) {
            echo "Something went wrong: " . $ex->getMessage();
        }
    }
   
    public function createQuiz()
{
    if ($this->quizTitle && $this->quizText) {
        $sql = "INSERT INTO quizzes (quiz_title, quiz_text, chapter_id, created_by, timer) VALUES (:quiz_title, :quiz_text, :chapter_id, :created_by, :timer)";
        $createdByValue = $this->createdBy ? $this->createdBy : null;

        // Use prepared statement correctly
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':quiz_title' => $this->quizTitle, // Correct variable
            ':quiz_text' => $this->quizText,
            ':chapter_id' => $this->chapterId,
            ':created_by' => $createdByValue,
            ':timer' => $this->timer
        ]);

        return $this->db->getConnection()->lastInsertId(); // Correct method call
    } else {
        throw new Exception("Must set values for quiz");
    }
}

    //for quizzes_page
    function quizList()
    {
        try {
            $sql = "Select * from quizzes";
            $stmt = $this->db->queryStatement($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $ex) {
            echo "Something went wrong: " . $ex->getMessage();
        }
    }

    // display all chapters
    public function teacherList()
    {
        try {
            $sql = "SELECT chapter_id, chapter_title FROM chapters WHERE chapter_id = 1";
            $stmt = $this->db->queryStatement($sql);

            // Check if the statement executed correctly
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
    public function deleteQuiz()
    {
        $stmt = $this->db->prepare("DELETE FROM quizzes WHERE quiz_id = :quiz_id");
        $stmt->bindParam(':quiz_id', $this->quizId);
        return $stmt->execute();
    }
}
