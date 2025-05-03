<?php
class Database {
    private $host = "localhost";
    private $db_name = "kihumuro_hospital";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password,
                array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
                )
            );
        } catch(PDOException $exception) {
            // Log the error instead of displaying it directly
            error_log("Database Connection Error: " . $exception->getMessage());
            // Return a user-friendly message
            throw new Exception("Unable to connect to the database. Please try again later.");
        }

        return $this->conn;
    }
}
?> 