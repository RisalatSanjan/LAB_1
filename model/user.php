<?php

class User
{
    private $host = "localhost";
    private $db_name = "auth_system_db";
    private $username = "root";
    private $password = "";
    private $conn;

    public function __construct()
    {
        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name}",
                $this->username,
                $this->password
            );

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            die("Database Connection Failed: " . $e->getMessage());
        }
    }

    public function createUser($name, $email, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (name, email, password) 
                VALUES (:name, :email, :password)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ":name" => $name,
            ":email" => $email,
            ":password" => $hashedPassword
        ]);
    }

    public function findUserByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ":email" => $email
        ]);

        return $stmt->fetch();
    }

    public function emailExists($email)
    {
        $user = $this->findUserByEmail($email);

        if ($user) {
            return true;
        }

        return false;
    }
}