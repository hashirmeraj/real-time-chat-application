<?php
class Users
{
    // Private properties
    private $id;
    private $name;
    private $email;
    private $loginStatus;
    private $lastLogin;
    private $dbConn;

    // Getter for $id
    public function getId()
    {
        return $this->id;
    }

    // Setter for $id
    public function setId($id)
    {
        $this->id = $id;
    }

    // Getter for $name
    public function getName()
    {
        return $this->name;
    }

    // Setter for $name
    public function setName($name)
    {
        $this->name = $name;
    }

    // Getter for $email
    public function getEmail()
    {
        return $this->email;
    }

    // Setter for $email
    public function setEmail($email)
    {
        $this->email = $email;
    }

    // Getter for $loginStatus
    public function getLoginStatus()
    {
        return $this->loginStatus;
    }

    // Setter for $loginStatus
    public function setLoginStatus($loginStatus)
    {
        $this->loginStatus = $loginStatus;
    }

    // Getter for $lastLogin
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    // Setter for $lastLogin
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;
    }

    public function __construct()
    {
        require_once './database/config.php';
        $db = new DbConnect();
        $this->dbConn = $db->connect();
    }
    public function save()
    {
        // SQL query with 4 placeholders (name, email, login_status, last_login)
        $sql = "INSERT INTO `users`(`name`, `email`, `login_status`, `last_login`) VALUES (?, ?, ?, ?)";

        // Prepare the statement
        $stmt = $this->dbConn->prepare($sql);

        // Bind all parameters in one call to bind_param
        // 's' for string, 'i' for integer, 's' for string (for last_login)
        $stmt->bind_param("ssis", $this->name, $this->email, $this->loginStatus, $this->lastLogin);

        try {
            // Execute the prepared statement
            if ($stmt->execute()) {
                return true; // Return true if the query is successful
            } else {
                return false; // Return false if the query fails
            }
        } catch (Exception $e) {
            // Catch any exceptions and print the error message
            echo $e->getMessage();
        }

        // Close the statement
        $stmt->close();
    }

    public function getUserByEmail($email)
    {
        // SQL query to select the user with the given email
        $sql = "SELECT * FROM users WHERE email = ?";

        // Prepare the statement
        $stmt = $this->dbConn->prepare($sql);

        // Bind the email parameter (string type)
        $stmt->bind_param("s", $email);

        // Execute the query
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        // Fetch the user data (if found)
        if ($result->num_rows > 0) {
            return $result->fetch_assoc(); // Return user data as an associative array
        } else {
            return null; // No user found with the provided email
        }

        // Close the statement
        $stmt->close();
    }

    public function updateLoginStatus()
    {
        $sql = "UPDATE `users` SET `login_status`= ?,`last_login`= ? WHERE `id` = ?";

        $stmt = $this->dbConn->prepare($sql);

        $stmt->bind_param('isi', $this->loginStatus, $this->lastLogin, $this->id);

        // Execute the query
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
