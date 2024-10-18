<?php

class UserController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Método para crear un nuevo usuario
    public function createUser($values) {

        $loginHash = bin2hex(random_bytes(32));

        // Query SQL para la inserción
        $query = "INSERT INTO users (name, city_id, avatar, login_hash) VALUES (:name, :cityId, :avatar, :loginHash)";

        // Preparar y ejecutar la consulta
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $values["name"]);
        $stmt->bindParam(':cityId', $values["cityId"]);
        $stmt->bindParam(':avatar', $values["avatar"]);
        $stmt->bindParam(':loginHash', $loginHash);
        $stmt->execute();

        // Obtener el ID del usuario insertado
        $userId = $this->db->lastInsertId();

        echo json_encode(["userId" => $userId, "loginHash" => $loginHash]);
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

    private function updateLoginHash($values) {
        if (is_numeric($values["id"])) {
            $randomHash = bin2hex(random_bytes(128)); // 128 bytes = 256 caracteres hexadecimales

            $query = "UPDATE users SET login_hash = :login_hash WHERE id = :id";

            try {
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':login_hash', $randomHash);
                $stmt->bindParam(':id', $values["id"]);
                $stmt->execute();

                // Verificar si se realizó la actualización
                if ($stmt->rowCount() > 0) {
                    return true;
                } else {
                    return false;
                }
            } catch (PDOException $e) {
                // Manejar errores de base de datos
                return false;
            }
        } else {
            return false;
        }
    }



    public function login($values) {
        if (isset($values["userId"]) && isset($values["loginHash"])) {

            $query = "SELECT id, login_hash FROM users WHERE id = :userId and login_hash = :loginHash";

            try {
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':userId', $values["userId"]);
                $stmt->bindParam(':loginHash', $values["loginHash"]);
                $stmt->execute();

                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($result) {
                
                    if ($this->updateLoginHash($result)) {

                        $query = "SELECT id, login_hash FROM users WHERE id = :id";

                        $stmt = $this->db->prepare($query);
                        $stmt->bindParam(':id', $result["id"]);
                        $stmt->execute();

                        $user = $stmt->fetch(PDO::FETCH_ASSOC);
                        echo json_encode(["userId" => $user['id'], "loginHash" => $user['login_hash']]);

                    } else {
                        echo json_encode(["error" => "Error en actualizar hash de login."]);
                    }
                } else {
                    echo json_encode("No logged");
                }

            } catch (PDOException $e) {
                echo json_encode(["error" => "Error en la base de datos: " . $e->getMessage()]);
            }
            
        } else {
            echo json_encode(["error" => "User telephone must be a number."]);
        }
    }


    public function checkLoginStatus($values) {

        if (isset($values["loggedUserId"]) && isset($values["loggedHash"])) {
            $userId = $values["loggedUserId"];
            $loginHash = $values["loggedHash"];

            $query = "SELECT id FROM users WHERE id = :user_id and login_hash = :login_hash";

            try {
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':user_id', $userId);
                $stmt->bindParam(':login_hash', $loginHash);
                $stmt->execute();

                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($result) {
                    return true;
                } else {
                    return false;
                }

            } catch (PDOException $e) {
                return ["error" => "Error en la base de datos: " . $e->getMessage()];
            }
        } else {
            return ["error" => "Missing loginHash parameter."];
        }

    }






}

?>