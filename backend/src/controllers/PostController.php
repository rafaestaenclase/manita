<?php

class PostController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function createPost($values) {
        foreach (['userId', 'categoryId', 'title', 'body'] as $key) {
            if (empty($values[$key])) {
                echo json_encode(["error" => "$key is required."]);
                return;
            }
        }

        $allowedKeys = ['userId', 'categoryId', 'title', 'body', 'imageUrl', 'reward', 'address', 'language'];
        $filteredValues = array_intersect_key($values, array_flip($allowedKeys));

        $query = "INSERT INTO posts (user_id, category_id, title, body, image_url, reward, address, language)
                  VALUES (:userId, :categoryId, :title, :body, :imageUrl, :reward, :address, :language)";


    
        try {
            $stmt = $this->db->prepare($query);
            
            foreach ($filteredValues as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
            
            $stmt->execute();

            $postId = $this->db->lastInsertId();

            echo json_encode($postId);
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error en la base de datos: " . $e->getMessage()]);
        }
    }







/*
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
*/






}

?>