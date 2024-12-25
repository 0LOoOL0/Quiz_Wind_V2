<?php

include 'Database_handler.php';

class Subject
{

    private $db;
    private $subjectId;
    private $subjectName;
    private $subjectText;
    private $assignTo;
    private $createdBy;

    public function __construct(Database $db)
    {
        $this->db = $db;

        $this->subjectId = null;
        $this->subjectName = null;
        $this->subjectText = null;
        $this->assignTo = null;
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

    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;

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

    //outdated:
    // function createSubject()
    // {
    //     if ($this->subjectName && $this->subjectText) {

    //         $sql = "INSERT INTO subjects (subject_name, subject_text, assigned_to) VALUES (:subject_name, :subject_text, :assigned_to)";
    //         $assignedToValue = $this->assignTo ? $this->assignTo : null;

    //         $this->db->queryStatement($sql, [
    //             ':subject_name' => $this->subjectName,
    //             ':subject_text' => $this->subjectText,
    //             ':assigned_to' => $assignedToValue
    //         ]);

    //         return $this->db->getConnection()->lastInsertId(); // Correct method call
    //     } else {
    //         throw new Exception("Must set values for subject name and description.");
    //     }
    // }

    function createSubject() 
{
    if ($this->subjectName && $this->subjectText) {
        // Step 1: Insert the new subject
        $sql = "INSERT INTO subjects (subject_name, subject_text, created_by) VALUES (:subject_name, :subject_text, :created_by)";
        
        $this->db->queryStatement($sql, [
            ':subject_name' => $this->subjectName,
            ':subject_text' => $this->subjectText,
            ':created_by' => $this->createdBy // Assuming you have a createdBy property
        ]);

        $subjectId = $this->db->getConnection()->lastInsertId(); // Get the newly created subject ID

        // Step 2: Assign teachers if any are provided
        if (!empty($this->assignTo) && is_array($this->assignTo)) {
            $stmt = $this->db->getConnection()->prepare("INSERT INTO subject_assignments (subject_id, user_id) VALUES (:subject_id, :user_id)");
            foreach ($this->assignTo as $userId) {
                $stmt->execute([
                    ':subject_id' => $subjectId,
                    ':user_id' => $userId
                ]);
            }
        }

        return $subjectId; // Return the new subject ID
    } else {
        throw new Exception("Must set values for subject name and description.");
    }
}

function getAssignedSubjects($userId)
{
    $sql = "SELECT s.subject_id, s.subject_name, s.subject_text
            FROM subjects s
            JOIN subject_assignments sa ON s.subject_id = sa.subject_id
            WHERE sa.user_id = :user_id";
    
    $stmt = $this->db->getConnection()->prepare($sql);
    $stmt->execute([':user_id' => $userId]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all results as an associative array
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

    public function getSubjectById($subject_id) {
        $sql = "SELECT * FROM subjects WHERE subject_id = :subject_id LIMIT 1"; // Adjust table name as necessary
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->execute([':subject_id' => $subject_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Fetch the subject details
    }

    // for editing get details first
    function getSubjectsDetails($assignmentId) {
        $sql = "SELECT a.*, u.username, s.subject_name , s.subject_text
        FROM subject_assignments a
        JOIN users u ON a.user_id = u.user_id 
        JOIN subjects s ON a.subject_id = s.subject_id 
        WHERE a.assignment_id = :assignment_id";
                $stmt = $this->db->queryStatement($sql, [':assignment_id' => $assignmentId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
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
        $stmt->bindParam(':subject_id', $this->subjectId);
        return $stmt->execute();
    }
}
