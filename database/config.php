<?php
$servername = 'localhost:3307'; // Server name, including port if not the default (3306)
$username = 'root'; // MySQL username
$password = ''; // MySQL password (empty if not set)
$dbname = 'chat_application'; // Name of the database to connect to

// Establishing a connection to the MySQL database
$conn = mysqli_connect($servername, $username, $password, $dbname);
