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

    public function getUserByid($id)
    {
        // SQL query to select the user with the given id
        $sql = "SELECT * FROM users WHERE id = ?";

        // Prepare the statement
        $stmt = $this->dbConn->prepare($sql);

        // Bind the id parameter (integer type)
        $stmt->bind_param("i", $id);

        // Execute the query
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        // Fetch the user data (if found)
        if ($result->num_rows > 0) {
            return $result->fetch_assoc(); // Return user data as an associative array
        } else {
            return null; // No user found with the provided id
        }

        // Close the statement
        $stmt->close();
    }

    public function getRestUserByid($id)
    {
        // SQL query to get the latest message for each user except the given id
        $sql = "SELECT u.*, c.msg, c.createdOn
            FROM users u
            JOIN chatrooms c ON u.id = c.userid
            WHERE u.id != ? 
            AND c.createdOn = (
                SELECT MAX(c2.createdOn) 
                FROM chatrooms c2 
                WHERE c2.userid = u.id
            )
            ORDER BY c.createdOn DESC";

        // Prepare the statement
        $stmt = $this->dbConn->prepare($sql);

        // Bind the id parameter (integer type)
        $stmt->bind_param("i", $id);

        // Execute the query
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        // Close the statement
        $stmt->close();

        return $result;
    }




    public function getUserByName($name)
    {
        // SQL query to get a single user matching the name
        $sql = "SELECT u.*, c.msg, c.createdOn
        FROM users u
        JOIN chatrooms c ON u.id = c.userid
        WHERE LOWER(u.name) LIKE LOWER(?) 
        AND c.createdOn = (
            SELECT MAX(c2.createdOn) 
            FROM chatrooms c2 
            WHERE c2.userid = u.id
        )
        ORDER BY c.createdOn DESC
        "; // 

        // Prepare the statement
        $stmt = $this->dbConn->prepare($sql);

        // Modify the search term for the LIKE query
        $searchTerm = "%{$name}%";

        // Bind the search term (string type)
        $stmt->bind_param("s", $searchTerm);

        // Execute the query
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        return $result;

        // Close the statement
        $stmt->close();

        return $user; // Return user data as an associative array
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


    public function updateLogoutStatus($loggedinId, $lastLogin)
    {
        // SQL query to update the user's login status
        $sql = "UPDATE `users` SET `login_status`= ?, `last_login`= ? WHERE `id` = ?";

        // Prepare the statement
        $stmt = $this->dbConn->prepare($sql);

        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($this->dbConn->error));
        }

        // Bind the parameters
        $stmt->bind_param('isi', $loginStatus, $lastLogin, $loggedinId);

        // Set the login status
        $loginStatus = 0; // 0 for logged out

        // Execute the query
        $success = $stmt->execute();

        // Close the statement
        $stmt->close();

        // Return the result
        return $success;
    }
}
