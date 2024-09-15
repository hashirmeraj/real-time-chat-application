<?php
date_default_timezone_set('Asia/Karachi'); // Change to your desired time zone

class DbConnect
{
    private $servername = 'localhost:3307'; // Server name, including port if not the default (3306)
    private $username = 'root'; // MySQL username
    private $password = ''; // MySQL password (empty if not set)
    private $dbname = 'chat_application'; // Name of the database to connect to

    // Establishing a connection to the MySQL database
    // Method to establish the database connection using try-catch
    public function connect()
    {
        try {
            // Create a connection
            $conn = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname);

            // Check connection
            if (mysqli_connect_errno()) {
                // Throw an exception in case of connection error
                throw new Exception("Connection failed: " . mysqli_connect_error());
            }

            return $conn; // Return the connection if successful
        } catch (Exception $e) {
            // Handle the exception and print an error message
            echo "Error: " . $e->getMessage();
        }
    }
}
