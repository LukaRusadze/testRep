<?php
class DBConnect
{
    protected $host;
    protected $username;
    protected $password;
    protected $dbname;
    protected $charset;

    public function __construct($host, $username, $password, $dbname, $charset)
    {
        // Initializing variables
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
        $this->charset = $charset;
    }
    
    public function Connect()
    {
        try {

            // Connecting to MySQL database using PHP PDO
            $pdo = new PDO("mysql:host={$this->host};charset={$this->charset}", $this->username, $this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Creating the database if it does not exist
            $pdo->query("CREATE DATABASE IF NOT EXISTS {$this->dbname}");
            $pdo->query("use {$this->dbname}");

            // Creating the table if it doesn't exist
            $pdo->query("CREATE TABLE IF NOT EXISTS users (
                    id INT(1) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    firstName VARCHAR(255) NOT NULL,
                    lastName VARCHAR(255) NOT NULL,
                    email VARCHAR(255) NOT NULL
                    )");
                
            return [true, $pdo];
        } catch (PDOException $ex) {
            return [false, "Exception: " . $ex->getMessage()];
        }
    }
}
