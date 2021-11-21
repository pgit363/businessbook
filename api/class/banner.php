<?php
    class Banner{

        // Connection
        private $conn;

        // Table
        private $db_table = "banner";

        // Columns
        public $id;
        public $name;
        public $banner_url;
        public $sp_id;
        public $timestamp;

        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL
        public function getBanner(){
            $sqlQuery = "SELECT 
                            * 
                        FROM 
                            " . $this->db_table . "";

            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->execute();

            return $stmt;
        }

        // CREATE
        public function createBanner(){
            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET
                        id = :id, 
                        name = :name, 
                        banner_url = :banner_url, 
                        sp_id = :sp_id, 
                        timestamp = :timestamp";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->id=htmlspecialchars(strip_tags($this->id));
            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->banner_url=htmlspecialchars(strip_tags($this->banner_url));
            $this->sp_id=htmlspecialchars(strip_tags($this->sp_id));
            $this->timestamp=htmlspecialchars(strip_tags($this->timestamp));              
        
            // bind data
            $stmt->bindParam(":id", $this->id);
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":banner_url", $this->banner_url);
            $stmt->bindParam(":sp_id", $this->sp_id);
            $stmt->bindParam(":timestamp", $this->timestamp);
           
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // UPDATE
        public function getSingleBanner(){
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
            $this->banner_url = $dataRow['banner_url'];
            $this->sp_id = $dataRow['sp_id'];
            $this->timestamp = $dataRow['timestamp'];
        }        


        //check record
        public function getCheckSingleBanner(){
            $sqlQuery = "SELECT
                            *
                        FROM
                            ". $this->db_table ."
                        WHERE 
                            name = ? 
                        AND
                            banner_url = ?
                        AND
                            sp_id = ?
                        LIMIT 0,1";

            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->bindParam(1, $this->name);

            $stmt->bindParam(2, $this->banner_url);

            $stmt->bindParam(3, $this->sp_id);

            $stmt->execute();

            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->id = $dataRow['id'];
            $this->name = $dataRow['name'];
            $this->banner_url = $dataRow['banner_url'];
            $this->sp_id = $dataRow['sp_id'];
            $this->timestamp = $dataRow['timestamp'];
        }        

        // UPDATE
        public function updateBanner(){
            $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                        id = :id, 
                        name = :name, 
                        banner_url = :banner_url, 
                        sp_id = :sp_id
                    WHERE 
                        id = :id";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->id=htmlspecialchars(strip_tags($this->id));
            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->banner_url=htmlspecialchars(strip_tags($this->banner_url));
            $this->sp_id=htmlspecialchars(strip_tags($this->sp_id));
            $this->id=htmlspecialchars(strip_tags($this->id));   
            
            // bind data
            $stmt->bindParam(":id", $this->id);
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":banner_url", $this->banner_url);
            $stmt->bindParam(":sp_id", $this->sp_id);
            $stmt->bindParam(":timestamp", $this->timestamp);
            $stmt->bindParam(":id", $this->id);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // DELETE
        function deleteBanner(){
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

