<?php
    class Marketing{

        // Connection
        private $conn;

        // Table
        private $db_table = "marketing";

        // Columns
        public $id;
        public $name;
        public $marketing_banner;
        public $timestamp;

        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL
        public function getMarketing(){
            $sqlQuery = "SELECT 
                            * 
                        FROM 
                            " . $this->db_table . "";

            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->execute();

            return $stmt;
        }

        // CREATE
        public function createMarketing(){
            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET
                        id = :id, 
                        name = :name, 
                        marketing_banner = :marketing_banner, 
                        timestamp = :timestamp";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->id=htmlspecialchars(strip_tags($this->id));
            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->marketing_banner=htmlspecialchars(strip_tags($this->marketing_banner));
            $this->timestamp=htmlspecialchars(strip_tags($this->timestamp));              
        
            // bind data
            $stmt->bindParam(":id", $this->id);
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":marketing_banner", $this->marketing_banner);
            $stmt->bindParam(":timestamp", $this->timestamp);
           
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // UPDATE
        public function getSingleMarketing(){
            $sqlQuery = "SELECT
                            *
                        FROM
                            ". $this->db_table ."
                        WHERE 
                            id = ?
                        LIMIT 0,1";

            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->bindParam(1, $this->id);

            $stmt->execute();

            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->id = $dataRow['id'];
            $this->name = $dataRow['name'];
            $this->marketing_banner = $dataRow['marketing_banner'];
            $this->timestamp = $dataRow['timestamp'];
        }        


        //check record
        public function getCheckSingleMarketing(){
            $sqlQuery = "SELECT
                            *
                        FROM
                            ". $this->db_table ."
                        WHERE 
                            name = ? 
                        AND
                            marketing_banner = ?
                        LIMIT 0,1";

            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->bindParam(1, $this->name);

            $stmt->bindParam(2, $this->marketing_banner);

            $stmt->execute();

            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->id = $dataRow['id'];
            $this->name = $dataRow['name'];
            $this->marketing_banner = $dataRow['marketing_banner'];
            $this->timestamp = $dataRow['timestamp'];
        }        

        // UPDATE
        public function updateMarketing(){
            $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                        name = :name,
                        marketing_banner = :marketing_banner, 
                        timestamp = :timestamp
                    WHERE 
                        id = :id";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->marketing_banner=htmlspecialchars(strip_tags($this->marketing_banner));
            $this->timestamp=htmlspecialchars(strip_tags($this->timestamp));  
            $this->id=htmlspecialchars(strip_tags($this->id));
            
        
            // bind data
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":marketing_banner", $this->marketing_banner);
            $stmt->bindParam(":timestamp", $this->timestamp);
            $stmt->bindParam(":id", $this->id);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // DELETE
        function deleteMarketing(){
            $sqlQuery = "DELETE FROM 
                            " . $this->db_table . " 
                        WHERE 
                            id = ?";
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            $stmt->bindParam(1, $this->id);
        
            if($stmt->execute()){
                return true;
            }
            return false;
        }

    }
?>

