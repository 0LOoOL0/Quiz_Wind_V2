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
    private $subjectId;
    private $userId;

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
        $this->subjectId = null;
        $this->userId = null;
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

    public function getSubjectId()
    {
        return $this->subjectId;
    }

    public function setSubjectId($subjectId)
    {
        $this->subjectId = $subjectId;

        return $this;
    }

    //for select chapter for the quiz
    function chapterList($subjectId)
    {
        try {
            $sql = "SELECT chapter_id, chapter_title FROM chapters WHERE subject_id = :subject_id";
            $stmt = $this->db->queryStatement($sql, ['subject_id' => $subjectId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $ex) {
            echo "Something went wrong: " . $ex->getMessage();
        }
    }

    public function createQuiz($subjectId) {
        // Ensure required properties are set
        if (empty($this->quizTitle) || empty($this->chapterId) || empty($subjectId)) {
            throw new Exception("Quiz title, chapter ID, and subject ID must be set.");
        }
    
        try {
            $sql = "INSERT INTO quizzes (quiz_title, quiz_text, chapter_id, created_by, timer, subject_id, user_id) 
                    VALUES (:quiz_title, :quiz_text, :chapter_id, :created_by, :timer, :subject_id, :user_id)";
            $createdByValue = $this->createdBy ?: null; // Null if not set
    
            // Prepare and execute the statement
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':quiz_title' => $this->quizTitle,
                ':quiz_text' => $this->quizText,
                ':chapter_id' => $this->chapterId,
                ':created_by' => $createdByValue,
                ':timer' => $this->timer,
                ':subject_id' => $subjectId, // Use the passed subjectId
                ':user_id' => $this->userId // Use the passed subjectId
            ]);
    
            // Return the ID of the newly created quiz
            return $this->db->getConnection()->lastInsertId();
        } catch (PDOException $e) {
            throw new Exception("Database error: " . $e->getMessage());
        }
    }

    //for quizzes_page
    function quizList($subjectId)
    {
        try {
            $sql = "SELECT quiz_id, quiz_title, quiz_text FROM quizzes WHERE subject_id = :subject_id";
            $stmt = $this->db->queryStatement($sql,[':subject_id' => $subjectId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $ex) {
            echo "Something went wrong: " . $ex->getMessage();
        }
    }

    // display all chapters
    public function teacherList()
    {
        try {
            $sql = "SELECT chapter_id, chapter_title FROM chapters WHERE chapter_id = :chapter_id";
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

    public function calculateScore($quizId)
    {
        $sql = "SELECT SUM(score) as total_score FROM questions WHERE quiz_id = :quiz_id";
        $stmt = $this->db->queryStatement($sql, [':quiz_id' => $quizId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['total_score'] ? (float)$result['total_score'] : 0;
    }

    public function updateScore($quizId, $totalScore)
    {
        $sql = "UPDATE quizzes SET total_score = :total_score WHERE quiz_id = :quiz_id";
        $this->db->queryStatement($sql, [
            ':total_score' => $totalScore,
            ':quiz_id' => $quizId
        ]);
    }


    public function calculateTotalPossibleScore($quizId)
    {
        $sql = "SELECT SUM(score) as total_possible_score FROM questions WHERE quiz_id = :quiz_id";
        $stmt = $this->db->queryStatement($sql, [':quiz_id' => $quizId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['total_possible_score'] ? (float)$result['total_possible_score'] : 0;
    }


    public function calculatePercentage($totalObtained, $totalPossible)
    {
        if ($totalPossible > 0) {
            return ($totalObtained / $totalPossible) * 100;
        }
        return 0; // Avoid division by zero
    }

    public function updateTotalScore($quizId, $totalScore)
    {
        $sql = "UPDATE quizzes SET total_score = :total_score WHERE quiz_id = :quiz_id";
        $this->db->queryStatement($sql, [
            ':total_score' => $totalScore,
            ':quiz_id' => $quizId
        ]);
    }

    // Function to delete a quiz
    public function deleteQuiz()
    {
        $stmt = $this->db->prepare("DELETE FROM quizzes WHERE quiz_id = :quiz_id");
        $stmt->bindParam(':quiz_id', $this->quizId);
        return $stmt->execute();
    }

    function getQuizzesByChapter($chapterId) {
        $quizzes = [];
        try {
            $stmt = $this->db->prepare("SELECT quiz_id, quiz_title, quiz_text FROM quizzes WHERE chapter_id = :chapter_id");
            $stmt->bindParam(':chapter_id', $chapterId, PDO::PARAM_INT);
            $stmt->execute();
    
            // Fetch all quizzes for the specified chapter
            $quizzes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Handle any errors
            error_log("Database error: " . $e->getMessage());
        }
    
        return $quizzes;
    }
    
    function getQuizById($userId) 
    {
        try {
            $sql = "SELECT q.quiz_id, q.quiz_title, q.quiz_text, s.subject_name 
            FROM quizzes q 
            JOIN subjects s ON q.subject_id = s.subject_id 
            WHERE q.user_id = :user_id";
            $stmt = $this->db->queryStatement($sql,[':user_id' => $userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $ex) {
            echo "Something went wrong: " . $ex->getMessage();
        }
    }

    function highScore($quizId) {
        try {
            $sql = "SELECT MAX(total_score) AS highest_score FROM attempts WHERE quiz_id = :quiz_id;";          
            $stmt = $this->db->queryStatement($sql,[':quiz_id' => $quizId]);

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? number_format($result['highest_score'], 2) : '0.00';

        } catch (Exception $ex) {
            echo "Something went wrong: " . $ex->getMessage();
        }
    }

    function lowScore($quizId) {
        try {
            $sql = "SELECT MIN(total_score) AS lowest_score FROM attempts WHERE quiz_id = :quiz_id;";          
            $stmt = $this->db->queryStatement($sql,[':quiz_id' => $quizId]);

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? number_format($result['lowest_score'], 2) : '0.00';return $result ? (int)$result['lowest_score'] : 0;

        } catch (Exception $ex) {
            echo "Something went wrong: " . $ex->getMessage();
        }
    }

    function averageScore($quizId) {
        try {
            $sql = "SELECT AVG(total_score) AS average_score FROM attempts WHERE quiz_id = :quiz_id;";          
            $stmt = $this->db->queryStatement($sql,[':quiz_id' => $quizId]);

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? number_format($result['average_score'], 2) : '0.00';

        } catch (Exception $ex) {
            echo "Something went wrong: " . $ex->getMessage();
        }
    }

    
}
