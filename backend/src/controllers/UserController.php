<?php

class UserController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Método para crear un nuevo usuario
    public function createUser($userData) {
        $query = "INSERT INTO users (name, subname, dob, telephone, email, password, address, avatar, `desc`, role, prestige, language, created_at, updated_at, is_verified) 
                  VALUES (:name, :subname, :dob, :telephone, :email, :password, :address, :avatar, :desc, :role, :prestige, :language, NOW(), NOW(), 0)";

        $stmt = $this->db->prepare($query);
        $stmt->execute($userData);

        $userId = $this->db->lastInsertId();

        return $userId;
    }

    // Método para actualizar los datos de un usuario existente
    public function updateUser($userId, $newData) {
        $query = "UPDATE users SET name = :name, subname = :subname, dob = :dob, telephone = :telephone, email = :email, password = :password,
                  address = :address, avatar = :avatar, `desc` = :desc, role = :role, prestige = :prestige, language = :language, updated_at = NOW() WHERE id = :id";

        $stmt = $this->db->prepare($query);
        $newData['id'] = $userId;
        $stmt->execute($newData);

        return $stmt->rowCount() > 0;
    }

    // Método para eliminar un usuario
    public function deleteUser($userId) {
        $query = "DELETE FROM users WHERE id = :id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $userId);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    // Método para obtener un usuario por su ID
    public function getUserById($userId) {
        if (is_numeric($userId["id"])) {

            $query = "SELECT id, name, subname, email FROM users WHERE id = :id";

            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $userId["id"]);
            $stmt->execute();

            echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
        } else {
            echo json_encode(["error" => "User ID must be a number."]);
        }
    }
}

?>