<?php
class Users
{
    // Private properties
    private $id;
    private $name;
    private $email;
    private $loginStatus;
    private $lastLogin;

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
        require_once './config.php';
        $db = new DbConnect();
    }
}
