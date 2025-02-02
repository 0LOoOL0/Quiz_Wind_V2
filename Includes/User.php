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
        // Check if all required fields are set
        if (!$this->username || !$this->password || !$this->email) {
            throw new Exception("Username, password, and email must be set.");
        }

        // Check if the username already exists
        if ($this->isUserExists($this->username, 'username')) {
            session_start();
            $_SESSION['error'] = "Username already exists.";
            header("Location: ../main.php");
            exit();
        }

        // Check if the email already exists
        if ($this->isUserExists($this->email, 'email')) {
            session_start();
            $_SESSION['error'] = "Email already exists.";
            header("Location: ../main.php");
            exit();
        }

        // Hash the password
        $hashPass = password_hash($this->password, PASSWORD_DEFAULT);
        $roleId = 3; // Default role ID

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
    }

    private function isUserExists($value, $type)
    {
        // Prepare SQL to check for existing username or email
        $column = ($type === 'username') ? 'username' : 'email';
        $sql = "SELECT COUNT(*) FROM users WHERE $column = :value";

        // Execute the prepared statement
        $stmt = $this->db->queryStatement($sql, [':value' => $value]);

        // Fetch the count
        $count = $stmt->fetchColumn();

        // Return true if user exists, false otherwise
        return $count > 0;
    }

    // this one is for admin creating account for users and assigning roles to them
    public function createUser()
    {
        // Ensure required fields are set
        if (!$this->username || !$this->password || !$this->email || !$this->roleId) {
            throw new Exception("Username, password, email, and role ID must be set.");
        }

        // Check if the username or email already exists
        if ($this->isUserExists($this->username, $this->email)) {
            session_start();
            $_SESSION['error'] = "Username or email already exists.";
            header("Location: ../Users_page.php");
            exit();
        }

        // Hash the password
        $hashPass = password_hash($this->password, PASSWORD_DEFAULT);

        // Prepare SQL statement to prevent SQL injection
        $sql = "INSERT INTO users (username, email, password, role_id) VALUES (:username, :email, :password, :role_id)";

        // Execute the prepared statement
        $this->db->queryStatement($sql, [
            ':username' => $this->username,
            ':email' => $this->email,
            ':password' => $hashPass,
            ':role_id' => $this->roleId
        ]);

        // Return the last inserted ID
        return $this->db->getConnection()->lastInsertId();
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
                session_start();
                $_SESSION['message'] = "Password updated successfully.";
                $_SESSION['message_type'] = "success"; // For styling
                header("Location: ../login.php");
                exit();
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

    public function resetUser($email, $newPassword)
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
                session_start();
                $_SESSION['message'] = "Password updated successfully.";
                $_SESSION['message_type'] = "success"; // For styling
                header("Location: ../login.php");
                exit();
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

    //edit users in user form
    public function changeUserDetail($userId, $newUsername, $newPassword = null)
    {
        $sql = "UPDATE users SET username = :username";

        if (!empty($newPassword)) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $sql .= ", password = :password";
        }

        $sql .= " WHERE user_id = :user_id";

        // Prepare parameters
        $params = [':username' => $newUsername, ':user_id' => $userId];

        if (!empty($newPassword)) {
            $params[':password'] = $hashedPassword;
        }

        // Execute the query using the queryStatement method
        $stmt = $this->db->queryStatement($sql, $params);

        // Check if the update was successful
        if ($stmt->rowCount() > 0) {
            return ['success' => true];
        } else {
            return ['success' => false, 'message' => 'Failed to update user.'];
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



    //populate users detail in edit form
    public function getUserById($userId)
    {
        $sql = "SELECT users.*, roles.* FROM users JOIN roles ON users.role_id = roles.role_id WHERE users.user_id = :user_id";
        $stmt = $this->db->queryStatement($sql, [':user_id' => $userId]);
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
        $stmt = $this->db->queryStatement($sql, [':user_id' => $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function usernameExists($username)
    {
        try {
            // Check if the username already exists
            $sql = "SELECT COUNT(*) FROM users WHERE username = :username";
            $stmt = $this->db->queryStatement($sql, [
                ':username' => $username
            ]);

            $count = $stmt->fetchColumn();

            return $count > 0; // Return true if username exists, false otherwise
        } catch (Exception $e) {
            // Handle any additional exceptions (logging, etc.)
            return false; // Optionally, handle the exception as needed
        }
    }

    public function updateUser($userId, $username)
    {
        if ($this->usernameExists($username)) {
            $_SESSION['error'] = "Username already exists.";
            return false; // Username already exists
        }

        // Proceed with updating the user...
        try {
            $sql = "UPDATE users SET username = :username WHERE user_id = :user_id";
            $stmt = $this->db->queryStatement($sql, [
                ':username' => $username,
                ':user_id' => $userId
            ]);

            return $stmt ? $stmt->rowCount() : false; // Check if the statement was successful
        } catch (Exception $e) {
            // Handle any additional exceptions
            return false;
        }
    }
}
