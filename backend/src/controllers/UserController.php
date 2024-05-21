<?php

class UserController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Método para crear un nuevo usuario
    public function createUser($values) {
        // Verificar si el correo electrónico o el teléfono ya existen
        $queryCheck = "SELECT COUNT(*) as count FROM users WHERE email = :email OR telephone = :telephone";
        $stmtCheck = $this->db->prepare($queryCheck);
        $stmtCheck->bindParam(':email', $values['email']);
        $stmtCheck->bindParam(':telephone', $values['telephone']);
        $stmtCheck->execute();
        $resultCheck = $stmtCheck->fetch(PDO::FETCH_ASSOC);

        // Si el correo electrónico o el teléfono ya existen, devuelve un error
        if ($resultCheck['count'] > 0) {
            echo json_encode(["error" => "El correo electrónico o el teléfono ya están registrados."]);
            return;
        }

        // Filtrar los valores proporcionados por el usuario
        $allowedKeys = ['name', 'subname', 'dob', 'telephone', 'email', 'password', 'address', 'avatar', 'desc', 'language'];

        $values['password'] = password_hash($values['password'], PASSWORD_DEFAULT);

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
        if (isset($values["telephone"]) && is_numeric($values["telephone"])) {

            $query = "SELECT id, password FROM users WHERE telephone = :telephone";

            try {
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':telephone', $values["telephone"]);
                $stmt->execute();

                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($result && password_verify($values["password"], $result['password'])) {

                    if ($this->updateLoginHash($result)) {

                        $query = "SELECT id, name, subname, email, login_hash FROM users WHERE id = :id";

                        $stmt = $this->db->prepare($query);
                        $stmt->bindParam(':id', $result["id"]);
                        $stmt->execute();

                        echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));

                    } else {
                        echo json_encode(["error" => "Error en actualizar hash de login."]);
                    }
                    
                } else {
                    echo json_encode(["error" => "Contraseña incorrecta."]);
                }

            } catch (PDOException $e) {
                echo json_encode(["error" => "Error en la base de datos: " . $e->getMessage()]);
            }
            
        } else {
            echo json_encode(["error" => "User telephone must be a number."]);
        }
    }








}

?>