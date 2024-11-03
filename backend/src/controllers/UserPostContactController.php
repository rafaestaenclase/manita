<?php

class UserPostContactController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function contacted($values) {
        // Asegúrate de que $values contenga 'loggedUserId' y 'postId'
        $loggedUserId = $values["loggedUserId"];
        $postId = $values["postId"];

        // Query SQL para la inserción en la tabla user_post_contact
        $query = "INSERT IGNORE INTO user_post_contact (user_id, post_id) VALUES (:userId, :postId)";

        // Preparar y ejecutar la consulta
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':userId', $loggedUserId);
        $stmt->bindParam(':postId', $postId);

        // Intentar ejecutar la inserción
        try {
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                echo json_encode(["status" => "success", "message" => "Contacto registrado."]);
            } else {
                echo json_encode(["status" => "info", "message" => "Ya has contactado este post anteriormente."]);
            }
        } catch (PDOException $e) {
            echo json_encode(["status" => "error", "message" => $e->getMessage()]);
        }
    }

    public function getContactsForPostByOwner($values) {
        $postId = $values["postId"];
        $loggedUserId = $values["loggedUserId"];

        $query = "
            SELECT u.id, u.name, u.avatar 
            FROM users u
            JOIN user_post_contact upc ON u.id = upc.user_id
            JOIN posts p ON upc.post_id = p.id
            WHERE upc.post_id = :postId AND p.user_id = :loggedUserId
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':postId', $postId);
        $stmt->bindParam(':loggedUserId', $loggedUserId);
        
        try {
            $stmt->execute();
            $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if (count($contacts) > 0) {
                echo json_encode(["status" => "success", "contacts" => $contacts]);
            } else {
                echo json_encode(["status" => "info", "message" => "No hay contactos para este post."]);
            }
        } catch (PDOException $e) {
            echo json_encode(["status" => "error", "message" => $e->getMessage()]);
        }
    }


}

?>