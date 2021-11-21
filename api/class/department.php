<?php
    class Department{

        // Connection
        private $conn;

        // Table
        private $db_table = "department";

        // Columns
        public $id;
        public $department;
        public $timestamp;

        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL
        public function getDepartment(){
            $sqlQuery = "SELECT 
                            * 
                        FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }

        // CREATE
        public function createDepartment(){
            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET
                        department = :department, 
                        timestamp = :timestamp";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->department=htmlspecialchars(strip_tags($this->department));
            $this->timestamp=htmlspecialchars(strip_tags($this->timestamp));              
        
            // bind data
            $stmt->bindParam(":department", $this->department);
            $stmt->bindParam(":timestamp", $this->timestamp);
           
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // UPDATE
        public function getSingleDepartment(){
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
            
            $this->department = $dataRow['department'];
            $this->timestamp = $dataRow['timestamp'];
        }        


        //check record
        public function getCheckSingleDepartment(){
            $sqlQuery = "SELECT
                            *
                        FROM
                            ". $this->db_table ."
                        WHERE 
                            department = ?
                        LIMIT 0,1";

            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->bindParam(1, $this->department);

            $stmt->execute();

            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->department = $dataRow['department'];
            $this->timestamp = $dataRow['timestamp'];
        }        

        // UPDATE
        public function updateDepartment(){
            $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                        department = :department, 
                        timestamp = :timestamp
                    WHERE 
                        id = :id";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->department=htmlspecialchars(strip_tags($this->department));
            $this->timestamp=htmlspecialchars(strip_tags($this->timestamp));  
            $this->id=htmlspecialchars(strip_tags($this->id));
            
        
            // bind data
            $stmt->bindParam(":department", $this->department);
            $stmt->bindParam(":timestamp", $this->timestamp);
            $stmt->bindParam(":id", $this->id);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }
        
        // UPDATE ICON
         public function updateDepartmentIcon(){
            $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                        image_url = :image_url   
                    WHERE 
                        id = :id";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->image_url=htmlspecialchars(strip_tags($this->image_url));
            $this->id=htmlspecialchars(strip_tags($this->id));
                    
            // bind data
            $stmt->bindParam(":image_url", $this->image_url);
            $stmt->bindParam(":id", $this->id);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }        

        // DELETE
        function deleteDepartment(){
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

