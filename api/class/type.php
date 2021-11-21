<?php
    class Type{

        // Connection
        private $conn;

        // Table
        private $db_table = "type";

        // Columns
        public $id;
        public $type;
        public $timestamp;

        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL
        public function getType(){
            $sqlQuery = "SELECT 
                            * 
                        FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }

        // CREATE
        public function createType(){
            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET
                        type = :type, 
                        timestamp = :timestamp";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->type=htmlspecialchars(strip_tags($this->type));
            $this->timestamp=htmlspecialchars(strip_tags($this->timestamp));              
        
            // bind data
            $stmt->bindParam(":type", $this->type);
            $stmt->bindParam(":timestamp", $this->timestamp);
           
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // UPDATE
        public function getSingleType(){
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
            
            $this->type = $dataRow['type'];
            $this->timestamp = $dataRow['timestamp'];
        }        


        //check record
        public function getCheckSingleType(){
            $sqlQuery = "SELECT
                            *
                        FROM
                            ". $this->db_table ."
                        WHERE 
                            type = ?
                        LIMIT 0,1";

            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->bindParam(1, $this->type);

            $stmt->execute();

            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->type = $dataRow['type'];
            $this->timestamp = $dataRow['timestamp'];
        }        

        // UPDATE
        public function updateType(){
            $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                    type = :type, 
                        timestamp = :timestamp
                    WHERE 
                        id = :id";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->type=htmlspecialchars(strip_tags($this->type));
            $this->timestamp=htmlspecialchars(strip_tags($this->timestamp));  
            $this->id=htmlspecialchars(strip_tags($this->id));
            
        
            // bind data
            $stmt->bindParam(":type", $this->type);
            $stmt->bindParam(":timestamp", $this->timestamp);
            $stmt->bindParam(":id", $this->id);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // DELETE
        function deleteType(){
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

