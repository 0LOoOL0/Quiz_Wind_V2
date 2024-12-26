<?php

include 'Database_handler.php';

class Chapter
{

    private $db;
    private $subjectId;
    private $chapterId;
    private $chapterTitle;
    private $createdBy; // multiple teachers can change that

    public function __construct(Database $db)
    {
        $this->db = $db;

        $this->subjectId = null;
        $this->chapterId = null;
        $this->chapterTitle = null;
        $this->createdBy = null;
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

    public function getChapterTitle()
    {
        return $this->chapterTitle;
    }

    public function setChapterTitle($chapterTitle)
    {
        $this->chapterTitle = $chapterTitle;

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

    public function getChapterId()
    {
        return $this->chapterId;
    }

    public function setChapterId($chapterId)
    {
        $this->chapterId = $chapterId;

        return $this;
    }

    public function createChapter()
{
    if ($this->chapterTitle && $this->subjectId) {
        $sql = "INSERT INTO chapters (subject_id, chapter_title) VALUES (:subject_id, :chapter_title)";
        $stmt = $this->db->getConnection()->prepare($sql); // Prepare the SQL statement
        $stmt->execute([
            ':subject_id' => $this->subjectId,
            ':chapter_title' => $this->chapterTitle // Ensure this matches the SQL statement
        ]);
        return $this->db->getConnection()->lastInsertId(); // Return the last inserted ID
    } else {
        throw new Exception("Must set values for chapter title and subject ID.");
    }
}


    public function getChaptersBySubject($subjectId) {
        try {
            $sql = "SELECT * FROM chapters WHERE subject_id = ?";
            $stmt = $this->db->queryStatement($sql, [$subjectId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $ex) {
            echo "Something went wrong: " . $ex->getMessage();
            return [];
        }
    }

    //testing only worked
    function chapterList()
    {
        try {
            $sql = "Select * from chapters";
            $stmt = $this->db->queryStatement($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $ex) {
            echo "Something went wrong: " . $ex->getMessage();
        }
    }

    //deleting chapter
    public function deleteChapter($chapterId)
    {
        $sql = "DELETE FROM chapters WHERE chapter_id = :chapter_id";
        $stmt = $this->db->queryStatement($sql,[':chapter_id' => $chapterId]);
        return $stmt->rowCount() > 0; 
    }

    public function getChapterDetail($chapterId) {
        $sql = "SELECT c.chapter_title, c.chapter_id, q.quiz_title, q.quiz_text, q.quiz_id 
            FROM chapters c
            JOIN quizzes q ON c.chapter_id = q.chapter_id
            WHERE c.chapter_id = :chapter_id";
        $stmt = $this->db->queryStatement($sql, [':chapter_id' => $chapterId]);
        
        // Fetch a single record instead of all
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
