<?php

class CityController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllCities() {

            $query = "SELECT * FROM cities";

            try {
                $stmt = $this->db->prepare($query);
                $stmt->execute();

                $cities = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (empty($cities)) {
                    echo json_encode(["message" => "No cities found."]);
                } else {
                    echo json_encode($cities); 
                }

            } catch (PDOException $e) {
                echo json_encode(["error" => "Database error: " . $e->getMessage()]);
            }
    }
}

?>