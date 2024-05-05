<?php

class DBConnection {

    
    private $host = 'localhost';
    private $dbname = 'mydatabase';
    private $username = 'root';
    private $password = '';
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbname, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}

class BaseModel {
    protected $table;
    protected $conn;

    public function __construct() {
        $connection = new DBConnection();
        $this->conn = $connection->getConnection();
    }

    public function all() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($data) {
        $query = "INSERT INTO " . $this->table . " SET ";
        foreach ($data as $key => $value) {
            $query .= $key . " = :" . $key . ", ";
        }
        $query = rtrim($query, ', ');
        $stmt = $this->conn->prepare($query);
        foreach ($data as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    public function update($data, $id) {
        $query = "UPDATE " . $this->table . " SET ";
        foreach ($data as $key => $value) {
            $query .= $key . " = :" . $key . ", ";
        }
        $query = rtrim($query, ', ');
        $query .= " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        foreach ($data as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->rowCount();
    }
}
