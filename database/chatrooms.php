<?php
class Chatrooms
{
    private $id;
    private $userId;
    private $msg;
    private $createdOn;
    private $dbConn;

    // Getter and Setter for $id
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    // Getter and Setter for $userId
    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    // Getter and Setter for $msg
    public function getMsg()
    {
        return $this->msg;
    }

    public function setMsg($msg)
    {
        $this->msg = $msg;
    }

    // Getter and Setter for $createdOn
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;
    }

    // Getter and Setter for $dbConn
    public function getDbConn()
    {
        return $this->dbConn;
    }

    // Constructor to establish database connection
    public function __construct()
    {
        require_once './database/config.php'; // Include the database config file
        $db = new DbConnect(); // Create a new DbConnect object
        $this->dbConn = $db->connect(); // Assign the database connection
    }

    // Method to save chatroom message to the database
    public function saveChatroom()
    {
        $sql = "INSERT INTO `chatrooms`( `userid`, `msg`) VALUES (?, ?)";
        $stmt = $this->dbConn->prepare($sql); // Prepare the SQL statement
        $stmt->bind_param("is", $this->userId, $this->msg); // Bind parameters

        try {
            // Execute the prepared statement
            if ($stmt->execute()) {
                return true; // Return true if the query is successful
            } else {
                return false; // Return false if the query fails
            }
        } catch (Exception $e) {
            // Catch any exceptions and print the error message
            echo 'Error: ' . $e->getMessage();
            return false;
        } finally {
            // Close the statement to free resources
            $stmt->close();
        }
    }

    // Destructor to close the database connection when the object is destroyed
    public function __destruct()
    {
        if ($this->dbConn) {
            $this->dbConn->close();
        }
    }


    public function getAllmsg()
    {

        $stmt = $this->dbConn->prepare("SELECT c.*, u.name FROM chatrooms c JOIN users u ON(c.userid = u.id)");

        // Execute the query
        $stmt->execute();

        // Get the result set from the statement
        $result = $stmt->get_result();
        return $result;

        // Close the statement
        $stmt->close();
    }
}
