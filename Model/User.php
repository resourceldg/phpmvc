<?php
class User
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    public function createUser($username, $hashedPassword)
    {
        // Preparar la consulta SQL para insertar un nuevo usuario
        $stmt = $this->pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");

        // Bind de los parámetros
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashedPassword);

        // Ejecutar la consulta
        return $stmt->execute();
    }
    public function deleteUser($userId) {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$userId]);
    }
    public function getUserByUsername($username)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch();
    }

    public function getAllUsers()
    {
        $stmt = $this->pdo->query("SELECT * FROM users");
        return $stmt->fetchAll();
    }

    public function getUserByUsernameAndRoleId($username)
    {
        $stmt = $this->pdo->prepare("SELECT fk_role_id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $id = $stmt->fetch();

        if ($id) {
            return $id['fk_role_id'];
        } else {
            return null; // Devolver null si el usuario no existe o la contraseña es incorrecta
        }
    }


}

