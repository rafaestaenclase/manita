<?php

class PostController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function createPost($values) {
        foreach (['loggedUserId', 'categoryId', 'title', 'body'] as $key) {
            if (empty($values[$key])) {
                echo json_encode(["error" => "$key is required."]);
                return;
            }
        }

        $allowedKeys = ['loggedUserId', 'categoryId', 'title', 'body', 'imageUrl', 'reward', 'address', 'language'];
        $filteredValues = array_intersect_key($values, array_flip($allowedKeys));

        $query = "INSERT INTO posts (user_id, category_id, title, body, image_url, reward, address, language)
                  VALUES (:loggedUserId, :categoryId, :title, :body, :imageUrl, :reward, :address, :language)";

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
            $page = isset($values["page"]) ? intval($values["page"]) : 1;
            $limit = 5;

            $offset = max(0, ($page - 1) * $limit);

            // Adjust the limit to fetch one additional post to check if there are more available
            $limitForQuery = $limit + 1;

            $query = "SELECT * FROM posts WHERE user_id = :userId LIMIT :limit OFFSET :offset";

            try {
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':userId', $userId);
                $stmt->bindParam(':limit', $limitForQuery, PDO::PARAM_INT); // Using the adjusted limit
                $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
                $stmt->execute();

                $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Check if there are more posts available
                $hasMore = count($posts) > $limit;

                // If there are more posts than we are going to display, remove the last post
                if ($hasMore) {
                    array_pop($posts);
                }

                // Return the posts and indication if there are more available
                echo json_encode(["posts" => $posts, "hasMore" => $hasMore]);
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