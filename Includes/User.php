<?php

include 'Database_handler.php';

class User
{

    private $db;
    private $userId;
    private $username;
    private $email;
    private $password;
    private $roleId;

    public function __construct(Database $db)
    {
        $this->db = $db;

        $this->username = null;
        $this->email = null;
        $this->password = null;
        $this->roleId = null;
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

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function getRoleId()
    {
        return $this->roleId;
    }

    public function setRoleId($roleId)
    {
        $this->roleId = $roleId;

        return $this;
    }

    public function registerUser()
    {
        if ($this->username && $this->password && $this->email) {

            $hashPass = password_hash($this->password, PASSWORD_DEFAULT);
            $roleId = 3;

            // Prepare SQL statement to prevent SQL injection
            $sql = "INSERT INTO users (username, email, password, role_id) VALUES (:username, :email, :password, :role_id)";

            // Execute the prepared statement
            $this->db->queryStatement($sql, [
                ':username' => $this->username,
                ':email' => $this->email,
                ':password' => $hashPass,
                ':role_id' => $roleId
            ]);

            // Return the last inserted ID
            return $this->db->getConnection()->lastInsertId();
        } else {
            // Throw an exception if any required fields are missing
            throw new Exception("Username, password, and email must be set.");
        }
    }

    // this one is for admin creating account for users and assigning roles to them
    function createUser()
    {
        if ($this->username && $this->password && $this->email && $this->roleId) {
            $hashPass = password_hash($this->password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (username, email, password, role_id) VALUES (:username, :email, :password, :role_id)";

            $this->db->queryStatement($sql, [
                ':username' => $this->username,
                ':email' => $this->email,
                ':password' => $hashPass,
                ':role_id' => $this->roleId
            ]);
            return $this->db->getConnection()->lastInsertId(); // Correct method call
        } else {
            throw new Exception("Username, password, email, and role ID must be set.");
        }
    }

    function getUserList()
    {
        try {
            $sql = "Select * from users";
            $stmt = $this->db->queryStatement($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $ex) {
            echo "Something went wrong: " . $ex->getMessage();
        }
    }


    function roleList()
    {
        try {
            $sql = "SELECT role_id, role_name FROM roles";
            $stmt = $this->db->queryStatement($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $ex) {
            echo "Something went wrong: " . $ex->getMessage();
        }
    }

    // Function to delete a user
    public function deleteUser()
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $this->userId); // Assuming $this->user_id is set in the User object
        return $stmt->execute();
    }

    public function login($username, $password)
    {
        $sql = "SELECT password FROM users WHERE username = :username";
        $stmt = $this->db->queryStatement($sql, [':username' => $username]);

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            // Debugging: Check fetched password hash
            // echo "Fetched password hash: " . $row['password']; // Uncomment for debugging

            if (password_verify($password, $row['password'])) {
                $_SESSION['username'] = $username;
                header("Location: ../subject_page.php");
                exit();
            } else {
                return 'Invalid username or password.';
            }
        } else {
            return 'Invalid username or password.';
        }
    }
}
