<?php
    class Services{

        // Connection
        private $conn;

        // Table
        private $db_table = "services_products";

        // Columns
        public $id;
        public $sp_id;
        public $service_product_name;
        public $price;
        public $type;
        public $timestamp;


        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL
        public function getServices(){
            $sqlQuery = "SELECT 
                            * 
                        FROM 
                            " . $this->db_table . "
                        WHERE 
                            sp_id = ?";

            $stmt = $this->conn->prepare($sqlQuery);
            
            $stmt->bindParam(1, $this->sp_id);

            $stmt->execute();
            
            return $stmt;
        }

        // CREATE
        public function createServices(){
            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET
                        sp_id = :sp_id, 
                        service_product_name = :service_product_name, 
                        price = :price, 
                        type = :type, 
                        timestamp = :timestamp";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->sp_id=htmlspecialchars(strip_tags($this->sp_id));
            $this->service_product_name=htmlspecialchars(strip_tags($this->service_product_name));     
            $this->price=htmlspecialchars(strip_tags($this->price));
            $this->type=htmlspecialchars(strip_tags($this->type));     
            $this->timestamp=htmlspecialchars(strip_tags($this->timestamp));
        
            // bind data
            $stmt->bindParam(":sp_id", $this->sp_id);
            $stmt->bindParam(":service_product_name", $this->service_product_name);
            $stmt->bindParam(":price", $this->price);
            $stmt->bindParam(":type", $this->type);
            $stmt->bindParam(":timestamp", $this->timestamp);           
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // UPDATE
        public function getSingleServices(){
            
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
            
            $this->sp_id = $dataRow['sp_id'];
            $this->service_product_name = $dataRow['service_product_name'];
            $this->price = $dataRow['price'];
            $this->type = $dataRow['type'];
            $this->timestamp = $dataRow['timestamp'];
        }        


        //check record
        public function getCheckSingleServices(){
            $sqlQuery = "SELECT
                            *
                        FROM
                            ". $this->db_table ."
                        WHERE 
                            sp_id = ?
                        AND
                            service_product_name = ?
                        AND
                            type = ?
                        LIMIT 0,1";

            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->bindParam(1, $this->sp_id);

            $stmt->bindParam(2, $this->service_product_name);

            $stmt->bindParam(3, $this->type);

            $stmt->execute();

            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->sp_id = $dataRow['sp_id'];
            $this->service_product_name = $dataRow['service_product_name'];
            $this->price = $dataRow['price'];
            $this->type = $dataRow['type'];
            $this->timestamp = $dataRow['timestamp'];
        }        

        // UPDATE
        public function updateServices(){
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

        // DELETE
        function deleteServices(){
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

