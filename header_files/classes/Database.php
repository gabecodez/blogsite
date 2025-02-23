<?php
class DatabaseException extends Exception {}

class Database {
    private $host;
    private $username;
    private $password;
    private $db_name;
    private $conn;

    public function __construct($host, $username, $password, $db_name) {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->db_name = $db_name;
        $this->connect();
    }

    // Establishes a database connection
    private function connect() {
        try {
            // Use PDO to connect to the database
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->db_name}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Use PDO::ATTR_EMULATE_PREPARES set to false to use real prepared statements
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
            // Handle connection errors
            throw new DatabaseException("Connection error: " . $e->getMessage());
        }
    }

    // Executes a query and returns the result
    public function query($sql, $params = []) {
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            throw new DatabaseException("Query error: " . $e->getMessage());
        }
    }
    

    // Method to fetch all rows from the executed query
    public function fetchAll($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function close() {
        $this->conn = null; // Close the connection
    }
    
}
?>