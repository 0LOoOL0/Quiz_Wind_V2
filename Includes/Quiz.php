<?php

include 'Database_handler.php';

class Quiz
{

    private $db;
    private $subjectId;
    private $subjectName;
    private $subjectText;
    private $assignTo;

    public function __construct(Database $db)
    {
        $this->db = $db;

        $this->subjectId = null;
        $this->subjectName = null;
        $this->subjectText = null;
        $this->assignTo = null;
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

    public function getSubjectName()
    {
        return $this->subjectName;
    }

    public function setSubjectName($subjectName)
    {
        $this->subjectName = $subjectName;

        return $this;
    }

    public function getSubjectText()
    {
        return $this->subjectText;
    }

    public function setSubjectText($subjectText)
    {
        $this->subjectText = $subjectText;

        return $this;
    }

    public function getAssignTo()
    {
        return $this->assignTo;
    }

    public function setAssignTo($assignTo)
    {
        $this->assignTo = $assignTo;

        return $this;
    }

    function createSubject()
    {
        if ($this->subjectName && $this->subjectText) {

            $sql = "INSERT INTO subjects (subject_name, subject_text, assigned_to) VALUES (:subject_name, :subject_text, :assigned_to)";
            $assignedToValue = $this->assignTo ? $this->assignTo : null;

            $this->db->queryStatement($sql, [
                ':subject_name' => $this->subjectName,
                ':subject_text' => $this->subjectText,
                ':assigned_to' => $assignedToValue
            ]);

            return $this->db->getConnection()->lastInsertId(); // Correct method call
        } else {
            throw new Exception("Must set values for subject name and description.");
        }
    }

    function getSubjectList()
    {
        try {
            $sql = "Select * from subjects";
            $stmt = $this->db->queryStatement($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $ex) {
            echo "Something went wrong: " . $ex->getMessage();
        }
    }

    // display all users with teacher role on table
    public function teacherList()
    {
        try {
            $sql = "SELECT user_id, username FROM users WHERE role_id = 2";
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

    // Function to delete a user
    public function deleteSubject()
    {
        $stmt = $this->db->prepare("DELETE FROM subjects WHERE subject_id = :subject_id");
        $stmt->bindParam(':subject_id', $this->subjectId); // Assuming $this->user_id is set in the User object
        return $stmt->execute();
    }
}
