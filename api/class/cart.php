<?php
    class Cart{

        // Connection
        private $conn;

        // Table
        private $db_table = "cart";

        // Columns
        public $id;
        public $sp_id;
        public $u_id;
        public $service_product_name;
        public $price;
        public $type;
        public $description;
        public $status;
        public $time_fixed;
        public $time_updated_by;
        public $timestamp;

        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL
        public function getCart(){
            $sqlQuery = "SELECT 
                            * 
                        FROM 
                            " . $this->db_table . "";
            
            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->execute();

            return $stmt;
        }

        // CREATE
        public function createCart(){
            $sqlQuery = "INSERT INTO
                            ". $this->db_table ."
                        SET
                            sp_id = :sp_id, 
                            u_id = :u_id, 
                            service_product_name = :service_product_name, 
                            price = :price, 
                            type = :type, 
                            description = :description, 
                            status = :status, 
                            time_fixed = :time_fixed, 
                            time_updated_by = :time_updated_by, 
                            timestamp = :timestamp";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->sp_id=htmlspecialchars(strip_tags($this->sp_id));
            $this->u_id=htmlspecialchars(strip_tags($this->u_id));
            $this->service_product_name=htmlspecialchars(strip_tags($this->service_product_name));
            $this->price=htmlspecialchars(strip_tags($this->price));
            $this->type=htmlspecialchars(strip_tags($this->type));
            $this->description=htmlspecialchars(strip_tags($this->description));
            $this->status=htmlspecialchars(strip_tags($this->status));
            $this->time_fixed=htmlspecialchars(strip_tags($this->time_fixed));
            $this->time_updated_by=htmlspecialchars(strip_tags($this->time_updated_by));
            $this->timestamp=htmlspecialchars(strip_tags($this->timestamp));              
        
            // bind data
            $stmt->bindParam(":sp_id", $this->sp_id);
            $stmt->bindParam(":u_id", $this->u_id);
            $stmt->bindParam(":service_product_name", $this->service_product_name);
            $stmt->bindParam(":price", $this->price);
            $stmt->bindParam(":type", $this->type);
            $stmt->bindParam(":description", $this->description);
            $stmt->bindParam(":status", $this->status);
            $stmt->bindParam(":time_fixed", $this->time_fixed);
            $stmt->bindParam(":time_updated_by", $this->time_updated_by);
            $stmt->bindParam(":timestamp", $this->timestamp);
           
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        
        public function getCheckSingleInCart(){
            $sqlQuery = "SELECT 
                            * 
                        FROM 
                            " . $this->db_table . "
                        WHERE 
                            id = ?";
            
            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->bindParam(1, $this->id);

            $stmt->execute();

            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->sp_id = $dataRow['sp_id'];
            $this->u_id = $dataRow['u_id'];
            $this->service_product_name = $dataRow['service_product_name'];
            $this->price = $dataRow['price'];
            $this->type = $dataRow['type'];
            $this->description = $dataRow['description'];
            $this->status = $dataRow['status'];
            $this->time_fixed = $dataRow['time_fixed'];
            $this->time_updated_by = $dataRow['time_updated_by'];
            $this->timestamp = $dataRow['timestamp'];
        }

        
        public function getSingleSpCart(){
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

        public function getSingleUserCart(){
            $sqlQuery = "SELECT 
                            * 
                        FROM 
                            " . $this->db_table . "
                        WHERE 
                            u_id = ?";
            
            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->bindParam(1, $this->u_id);

            $stmt->execute();

            return $stmt;
        }

        //check record
        public function getCheckSingleCart(){
            $sqlQuery = "SELECT
                            *
                        FROM
                            ". $this->db_table ."
                        WHERE 
                                sp_id = ?
                            AND
                                u_id = ?
                            AND 
                                service_product_name = ?
                            AND
                                price = ?
                            AND
                                type = ?
                        LIMIT 0,1";

            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->bindParam(1, $this->sp_id);

            $stmt->bindParam(2, $this->u_id);
            
            $stmt->bindParam(3, $this->service_product_name);
            
            $stmt->bindParam(4, $this->price);
            
            $stmt->bindParam(5, $this->type);

            $stmt->execute();

            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->sp_id = $dataRow['sp_id'];
            $this->u_id = $dataRow['u_id'];
            $this->service_product_name = $dataRow['service_product_name'];
            $this->price = $dataRow['price'];
            $this->type = $dataRow['type'];
            $this->description = $dataRow['description'];
            $this->status = $dataRow['status'];
            $this->time_fixed = $dataRow['time_fixed'];
            $this->time_updated_by = $dataRow['time_updated_by'];
            $this->timestamp = $dataRow['timestamp'];
        }        

        // UPDATE
        public function updateCartByClientSp(){
            $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                        description = :description, 
                        status = :status, 
                        time_fixed = :time_fixed, 
                        time_updated_by = :time_updated_by, 
                        timestamp = :timestamp
                    WHERE 
                        id = :id";

            $stmt = $this->conn->prepare($sqlQuery);

            $this->description=htmlspecialchars(strip_tags($this->description));
            $this->status=htmlspecialchars(strip_tags($this->status));
            $this->time_fixed=htmlspecialchars(strip_tags($this->time_fixed));
            $this->time_updated_by=htmlspecialchars(strip_tags($this->time_updated_by));
            $this->timestamp=htmlspecialchars(strip_tags($this->timestamp));
            $this->id=htmlspecialchars(strip_tags($this->id));              

            // bind data
            $stmt->bindParam(":description", $this->description);
            $stmt->bindParam(":status", $this->status);
            $stmt->bindParam(":time_fixed", $this->time_fixed);
            $stmt->bindParam(":time_updated_by", $this->time_updated_by);
            $stmt->bindParam(":timestamp", $this->timestamp);
            $stmt->bindParam(":id", $this->id);

            if($stmt->execute()){
            return true;
            }
            return false;
        }
        

        // UPDATE
        public function updateCart(){
            $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                        sp_id = :sp_id, 
                        u_id = :u_id, 
                        service_product_name = :service_product_name, 
                        price = :price, 
                        type = :type, 
                        description = :description, 
                        status = :status, 
                        time_fixed = :time_fixed, 
                        time_updated_by = :time_updated_by, 
                        timestamp = :timestamp
                    WHERE 
                        id = :id";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->sp_id=htmlspecialchars(strip_tags($this->sp_id));
            $this->u_id=htmlspecialchars(strip_tags($this->u_id));
            $this->service_product_name=htmlspecialchars(strip_tags($this->service_product_name));
            $this->price=htmlspecialchars(strip_tags($this->price));
            $this->type=htmlspecialchars(strip_tags($this->type));
            $this->description=htmlspecialchars(strip_tags($this->description));
            $this->status=htmlspecialchars(strip_tags($this->status));
            $this->time_fixed=htmlspecialchars(strip_tags($this->time_fixed));
            $this->time_updated_by=htmlspecialchars(strip_tags($this->time_updated_by));
            $this->timestamp=htmlspecialchars(strip_tags($this->timestamp));              
        
            // bind data
            $stmt->bindParam(":sp_id", $this->sp_id);
            $stmt->bindParam(":u_id", $this->u_id);
            $stmt->bindParam(":service_product_name", $this->service_product_name);
            $stmt->bindParam(":price", $this->price);
            $stmt->bindParam(":type", $this->type);
            $stmt->bindParam(":description", $this->description);
            $stmt->bindParam(":status", $this->status);
            $stmt->bindParam(":time_fixed", $this->time_fixed);
            $stmt->bindParam(":time_updated_by", $this->time_updated_by);
            $stmt->bindParam(":timestamp", $this->timestamp);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // DELETE
        function deleteCart(){
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

