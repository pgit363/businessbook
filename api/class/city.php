<?php
    class City{

        // Connection
        private $conn;

        // Table
        private $db_table = "states_districts";

        // Columns
        public $state_id;
        public $dist_id;
        public $name;
        public $timestamp;

        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL
        public function getCity(){
            $sqlQuery = "SELECT 
                            * 
                        FROM 
                            " . $this->db_table . " 
                        WHERE 
                            dist_id=?";
                            
            $stmt = $this->conn->prepare($sqlQuery);
            
            $stmt->bindParam(1, $this->dist_id);
            
            $stmt->execute();
            
            return $stmt;
        }

        // CREATE
        public function createCity(){
            $sqlQuery = "INSERT INTO
                            ". $this->db_table ."
                        SET
                            dist_id = :dist_id,
                            name = :name, 
                            timestamp = :timestamp";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            // sanitize
            $this->dist_id=htmlspecialchars(strip_tags($this->dist_id));
            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->timestamp=htmlspecialchars(strip_tags($this->timestamp));
        
            // bind data
            $stmt->bindParam(":dist_id", $this->dist_id);
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":timestamp", $this->timestamp);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // UPDATE
        public function getSingleCity(){
            $sqlQuery = "SELECT
                            *
                        FROM
                            ". $this->db_table ."
                        WHERE 
                            state_id = ?
                        AND
                            dist_id = ?
                        LIMIT 0,1";

            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->bindParam(1, $this->state_id);

            $stmt->bindParam(2, $this->dist_id);

            $stmt->execute();

            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->dist_id = $dataRow['dist_id'];
            $this->name = $dataRow['name'];
            $this->timestamp = $dataRow['timestamp'];
        }        

        //check record
        public function getCheckSingleCity(){
            $sqlQuery = "SELECT
                            *
                        FROM
                            ". $this->db_table ."
                        WHERE 
                            name = ?
                        AND
                            dist_id=?
                        LIMIT 0,1";

            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->bindParam(1, $this->name);

            $stmt->bindParam(2, $this->dist_id);

            $stmt->execute();

            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->dist_id = $dataRow['dist_id'];
            $this->name = $dataRow['name'];
            $this->timestamp = $dataRow['timestamp'];
        }        

        // UPDATE
        public function updateCity(){
            $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                        dist_id = :dist_id,
                        name = :name, 
                        timestamp = :timestamp
                    WHERE 
                        state_id = :state_id";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->dist_id=htmlspecialchars(strip_tags($this->dist_id));
            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->timestamp=htmlspecialchars(strip_tags($this->timestamp));
            $this->state_id=htmlspecialchars(strip_tags($this->state_id));
        
            // bind data
            $stmt->bindParam(":dist_id", $this->dist_id);
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":timestamp", $this->timestamp);
            $stmt->bindParam(":state_id", $this->state_id);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // DELETE
        function deleteCity(){
            $sqlQuery = "DELETE FROM 
                            " . $this->db_table . " 
                        WHERE 
                            state_id = ?
                        OR
                            dist_id = ?";
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->state_id=htmlspecialchars(strip_tags($this->state_id));
            $this->dist_id=htmlspecialchars(strip_tags($this->dist_id));
        
            $stmt->bindParam(1, $this->state_id);
            $stmt->bindParam(2, $this->dist_id);
        
            if($stmt->execute()){
                return true;
            }
            return false;
        }

    }
?>

