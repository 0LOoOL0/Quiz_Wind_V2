<?php

include 'Database_handler.php';
class Option {

    private $db;

    public $optionId;
    public $optionText;
    public $questionId;
    public $isCorrect;

    public function __construct($db) {
        $this->db = $db;
        $this->optionId = null;
        $this->optionText = null;
        $this->questionId = null;
        $this->isCorrect = null;
    }
    
    public function getOptionId()
    {
        return $this->optionId;
    }

    public function setOptionId($optionId)
    {
        $this->optionId = $optionId;

        return $this;
    }

    public function getOptionText()
    {
        return $this->optionText;
    }

    public function setOptionText($optionText)
    {
        $this->optionText = $optionText;

        return $this;
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

    public function getIsCorrect()
    {
        return $this->isCorrect;
    }

    public function setIsCorrect($isCorrect)
    {
        $this->isCorrect = $isCorrect;

        return $this;
    }

    public function createOption() {
        if ($this->optionText && $this->questionId && $this->isCorrect !== null) {
            $sql = "INSERT INTO options (option_text, question_id, is_correct) VALUES (:option_text, :question_id, :is_correct)";

            $this->db->queryStatement($sql, [
                ':option_text' => $this->optionText,
                ':question_id' => $this->questionId,
                ':is_correct' => $this->isCorrect
            ]);

            return $this->db->getConnection()->lastInsertId();
        } else {
            throw new Exception("Must set values for option");
        }
    }

}

?>