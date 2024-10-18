<?php

class CityController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getCityByName($values) {

        if (strlen($values["cityName"]) > 4) {
        
            $cityName = '%' . $values["cityName"] . '%'; // Asegurarse de usar comodines % para permitir coincidencias aproximadas

            $query = "SELECT * FROM cities WHERE name LIKE :cityName";

            try {
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':cityName', $cityName, PDO::PARAM_STR);
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
        } else {
            echo json_encode(false); 
        }
    }
}

?>