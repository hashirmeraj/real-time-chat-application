<?php
class chatrooms
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

    function __construct()
    {
        require_once './config.php';
        $db = new DbConnect();
        $this->dbConn = $db->connect();
    }

    public function saveChatroom()
    {

        $sql = "INSERT INTO `chatrooms`( `userid`, `msg`, `createdOn`) VALUES (?, ?, ?,)";
        $stmt = $this->dbConn->prepare($sql);
        
    }
}
