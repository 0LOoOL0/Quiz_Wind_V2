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

    function isUsernameTaken($username)
    {
        $sql = "SELECT COUNT(*) FROM users WHERE username = :username";
        $result = $this->db->queryStatement($sql, [':username' => $username]);
        return $result > 0;
    }

    function isEmailTaken($email)
    {
        $sql = "SELECT COUNT(*) FROM users WHERE email = :email";
        $result = $this->db->queryStatement($sql, [':email' => $email]);
        return $result > 0;
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
            $sql = "SELECT u.*, r.role_name 
            FROM users u
            JOIN roles r ON u.role_id = r.role_id
            ORDER BY u.created_at ASC";
            $stmt = $this->db->queryStatement($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $ex) {
            echo "Something went wrong: " . $ex->getMessage();
        }
    }

    function getUserByEmail($email)
    {
        try {
            $sql = "SELECT * FROM users WHERE email = :email";
            $stmt = $this->db->queryStatement($sql, [':email' => $email]);
            return $stmt->fetch(PDO::FETCH_ASSOC); // Fetch a single user
        } catch (Exception $ex) {
            echo "Something went wrong: " . $ex->getMessage();
        }
    }

    public function resetPassword($email, $newPassword)
{
    // Check if the user exists
    $user = $this->getUserByEmail($email);

    if ($user) {
        // Hash the new password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update the password in the database
        $sql = "UPDATE users SET password = :password WHERE email = :email";
        $stmt = $this->db->queryStatement($sql, [
            ':password' => $hashedPassword,
            ':email' => $email
        ]);

        if ($stmt) {
            $_SESSION['message'] = "Password updated successfully.";
            $_SESSION['message_type'] = "success"; // For styling
            return true;
        } else {
            $_SESSION['message'] = "Failed to update password.";
            $_SESSION['message_type'] = "error"; // For styling
            return false;
        }
    } else {
        $_SESSION['message'] = "Email not found.";
        $_SESSION['message_type'] = "error"; // For styling
        return false;
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

    // public function editUser($userId, $username, $password = null)
    // {
    //     // Start building the SQL query
    //     $sql = "UPDATE users SET username = :username";

    //     // Add password conditionally if provided
    //     if (!empty($password)) {
    //         $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    //         $sql .= ", password = :password"; // Include password in the update
    //     }

    //     $sql .= " WHERE user_id = :user_id"; // Add the WHERE clause

    //     // Prepare and execute the statement using queryStatement
    //     $params = [
    //         ':username' => $username,
    //         ':user_id' => $userId
    //     ];

    //     if (!empty($password)) {
    //         $params[':password'] = $hashedPassword;
    //     }

    //     // Execute the query
    //     return $this->db->queryStatement($sql, $params);
    // }

    public function getUserById($userId)
    {
        // Prepare the SQL statement
        $stmt = $this->db->prepare("SELECT * FROM users WHERE user_id = :user_id");

        // Bind the user ID parameter
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);

        // Execute the statement
        $stmt->execute();

        // Fetch the user data as an associative array
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function login($username, $password)
    {
        // Prepare SQL statement
        $sql = "SELECT u.user_id, u.username, u.password, u.role_id, r.role_name 
        FROM users u
        JOIN roles r ON u.role_id = r.role_id
        WHERE u.username = :username";
        $stmt = $this->db->queryStatement($sql, [':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Validate the user
        if ($user && password_verify($password, $user['password'])) {
            // Start a session
            session_start();

            // Store user information in session
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_id'] = $user['user_id']; // Store user ID if needed
            $_SESSION['role_name'] = $user['role_name'];
            $_SESSION['role_id'] = $user['role_id']; // Store the role ID

            // Redirect to subject_page.php
            header("Location: ../subject_page.php");
            exit();
        } else {
            session_start();
            $_SESSION['error'] = "Invalid username or password.";
            // Redirect back to login page
            header("Location: ../login.php");
            exit();
        }
    }

    function getUsersData($userId)
    {
        $sql = "SELECT username, email FROM users WHERE user_id = :user_id";
        $stmt = $this->db->queryStatement($sql, [[':user_id' => $userId]]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
