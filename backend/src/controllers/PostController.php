<?php

class PostController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function createPost($values) {
        foreach (['loggedUserId', 'title', 'body'] as $key) {
            if (empty($values[$key])) {
                echo json_encode(["error" => "$key is required."]);
                return;
            }
        }

        $allowedKeys = ['loggedUserId', 'title', 'body', 'neighborhood'];
        $filteredValues = array_intersect_key($values, array_flip($allowedKeys));

        $query = "INSERT INTO posts (user_id, title, body, neighborhood)
                  VALUES (:loggedUserId, :title, :body, :neighborhood)";

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


    public function getPostsByUserId($values) {

        if (isset($values["userId"])) {
            $userId = $values["userId"];

            $query = "SELECT * FROM posts WHERE user_id = :userId and active = 1";

            try {
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':userId', $userId);
                $stmt->execute();

                $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Return the posts and indication if there are more available
                echo json_encode(["posts" => $posts]);
            } catch (PDOException $e) {
                echo json_encode(["error" => "Database error: " . $e->getMessage()]);
            }
        } else {
            echo json_encode(["error" => "User ID parameter is required."]);
        }
        
    }


    public function getBoardPosts($values) {
        if (isset($values["loggedUserId"])) {
            $userId = $values["loggedUserId"];

            $query = "SELECT posts.*, users.avatar as user_avatar, users.name as user_name FROM posts JOIN users ON posts.user_id = users.id WHERE posts.user_id != :userId AND posts.active = 1;";

            try {
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':userId', $userId);
                $stmt->execute();

                $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Return the posts and indication if there are more available
                echo json_encode(["posts" => $posts]);
            } catch (PDOException $e) {
                echo json_encode(["error" => "Database error: " . $e->getMessage()]);
            }
        } else {
            echo json_encode(["error" => "User ID parameter is required."]);
        }
    }


    public function getPostById($values) {
        if (isset($values["postId"])) {
            $postId = $values["postId"];

            $query = "SELECT * FROM posts WHERE id = :postId";

            try {
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':postId', $postId);
                $stmt->execute();

                $post = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($post) {
                    echo json_encode($post);
                } else {
                    echo json_encode(["error" => "No post found with this ID."]);
                }
            } catch (PDOException $e) {
                echo json_encode(["error" => "Database error: " . $e->getMessage()]);
            }
        } else {
            echo json_encode(["error" => "User ID parameter is required."]);
        }
    }

    public function deletePostById($values) {
        if (isset($values["postId"])) {
            $postId = $values["postId"];
            $loggedUserId = $values["loggedUserId"];

            $query = "DELETE FROM posts WHERE id = :postId and user_Id = :userId";

            try {
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':postId', $postId);
                $stmt->bindParam(':userId', $loggedUserId);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    echo json_encode(["success" => "Post deleted successfully."]);
                } else {
                    echo json_encode(["error" => "No post found with this ID."]);
                }
            } catch (PDOException $e) {
                echo json_encode(["error" => "Database error: " . $e->getMessage()]);
            }
        } else {
            echo json_encode(["error" => "Post ID parameter is required."]);
        }
    }


}

?>