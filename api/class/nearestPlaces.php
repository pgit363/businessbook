<?php
    class NearestPlaces{

        // Connection
        private $conn;

        // Table
        private $db_table = "users";

        // Columns
        public $id;
        public $name;
        public $longitude;
        public $latitude;
        public $department;
        public $distatnce;

        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }

        //GET ALL
        public function getNearestPlaces(){
            $sqlQuery = "SELECT id, name, department, latitude, longitude, 
                            SQRT( POW(69.1 * (latitude - ?), 2) + POW(69.1 * (? - longitude) * COS(latitude / 57.3), 2)) 
                        AS 
                            distance 
                        FROM 
                            " . $this->db_table . "
                        WHERE
                            department = ?
                        HAVING 
                            distance < 1.24274 
                        ORDER BY 
                            `distance`  
                        AND 
                            id
                        ASC";

            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->bindParam(1, $this->latitude);
            
            $stmt->bindParam(2, $this->longitude);

            $stmt->bindParam(3, $this->department);
            
            $stmt->execute();

            return $stmt;
        }

     
        // UPDATE
        // public function getNearestPlaces(){
        //     $sqlQuery = "SELECT id, department, latitude, longitude, 
        //                     SQRT( POW(69.1 * (latitude - ?), 2) + POW(69.1 * (? - longitude) * COS(latitude / 57.3), 2)) 
        //                 AS 
        //                     distance 
        //                 FROM 
        //                 ". $this->db_table ."
        //                 HAVING 
        //                     distance < 25 
        //                 ORDER BY 
        //                     distance";
        //     // $sqlQuery = "SELECT
        //     //                 *
        //     //             FROM
        //     //                 ". $this->db_table ."
        //     //             WHERE 
        //     //                 id = ?
        //     //             LIMIT 0,1";

        //     $stmt = $this->conn->prepare($sqlQuery);

        //     $stmt->bindParam(1, $this->latitude);

        //     $stmt->bindParam(2, $this->longitude);

        //     $stmt->execute();

        //     $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
        //     $this->name = $dataRow['name'];
        //     $this->department = $dataRow['department'];
        //     $this->latitude = $dataRow['latitude'];
        //     $this->longitude = $dataRow['longitude'];
        //     $this->type = $dataRow['distance'];
        // }        
    }
?>

