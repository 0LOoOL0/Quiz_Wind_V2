<?php

include 'Database_handler.php';

class Chapter
{

    private $db;
    private $subjectId;
    private $chapterTitle;
    private $createdBy; // multiple teachers can change that

    public function __construct(Database $db)
    {
        $this->db = $db;

        $this->subjectId = null;
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

   
    // function createChapter()
    // {
    //     if ($this->chapterTitle) {

    //         $sql = "INSERT INTO chapters (chapter_title, subject_id, created_by) VALUES (:chapter_text, :subject_id, :created_by)";

    //         $this->db->queryStatment($sql, [
    //             ':chapter_text' => $this->chapterTitle,
    //             ':subject_id' => $this->subjectId,
    //             ':createdBy' => $this->createdBy
    //         ]);

    //         return $this->db->getConnection()->lastInsertId(); // Correct method call
    //     } else {
    //         throw new Exception("Must set values for chapter name and description.");
    //     }
    // }

    function createChapter() {
        if ($this->chapterTitle && $this->subjectId) {
            $sql = "INSERT INTO chapters (subject_id, chapter_title) VALUES (:subject_id, :chapter_title)";
            $this->db->queryStatment($sql, [
                ':subject_id' => $this->subjectId,
                ':chapter_name' => $this->chapterTitle
            ]);
            return $this->db->getConnection()->lastInsertId();
        } else {
            throw new Exception("Must set values for chapter name and subject ID.");
        }
    }


// retreive chapters from database
    public function getChaptersBySubject($subjectId) {
        try {
            $sql = "SELECT * FROM chapters WHERE subject_id = ?";
            $stmt = $this->db->queryStatment($sql, [$subjectId]);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $ex) {
            echo "Something went wrong: " . $ex->getMessage(); 
        }
    }


    // function getSubjectList()
    // {
    //     try {
    //         $sql = "Select * from subjects";
    //         $stmt = $this->db->queryStatment($sql);
    //         return $stmt->fetchAll(PDO::FETCH_ASSOC);
    //     } catch (Exception $ex) {
    //         echo "Something went wrong: " . $ex->getMessage();
    //     }
    // }

    // // display all users with teacher role on table
    // public function teacherList()
    // {
    //     try {
    //         $sql = "SELECT user_id, username FROM users WHERE role_id = 2";
    //         $stmt = $this->db->queryStatment($sql);

    //         // Check if the statement executed correctly
    //         if ($stmt) {
    //             $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //             if (empty($result)) {
    //                 echo "No teachers found.";
    //             }
    //             return $result;
    //         } else {
    //             echo "Query failed.";
    //         }
    //     } catch (Exception $ex) {
    //         echo "Something went wrong: " . $ex->getMessage();
    //     }
    // }

    // // Function to delete a user
    // public function deleteSubject()
    // {
    //     $stmt = $this->db->prepare("DELETE FROM subjects WHERE subject_id = :subject_id");
    //     $stmt->bindParam(':subject_id', $this->subjectId); // Assuming $this->user_id is set in the User object
    //     return $stmt->execute();
    // }

 
}
