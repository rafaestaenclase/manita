<?php

class UserController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Método para crear un nuevo usuario
    public function createUser($values) {
        // Filtrar los valores proporcionados por el usuario
        $allowedKeys = ['name', 'subname', 'dob', 'telephone', 'email', 'password', 'address', 'avatar', 'desc', 'language'];
        $filteredValues = array_intersect_key($values, array_flip($allowedKeys));

        // Construir la consulta SQL dinámicamente
        $columns = implode(', ', array_keys($filteredValues));
        $params = ':' . implode(', :', array_keys($filteredValues));

        // Query SQL para la inserción
        $query = "INSERT INTO users ($columns) VALUES ($params)";

        
        // Preparar y ejecutar la consulta
        $stmt = $this->db->prepare($query);
        $stmt->execute($filteredValues);

        // Obtener el ID del usuario insertado
        $userId = $this->db->lastInsertId();


        echo json_encode($userId);
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
    public function deleteUser($values) {
        $query = "DELETE FROM users WHERE id = :id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $values);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    // Método para obtener un usuario por su ID
    public function getUserById($values) {
        if (is_numeric($values["id"])) {

            $query = "SELECT id, name, subname, email FROM users WHERE id = :id";

            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $values["id"]);
            $stmt->execute();

            echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
        } else {
            echo json_encode(["error" => "User ID must be a number."]);
        }
    }
}

?>