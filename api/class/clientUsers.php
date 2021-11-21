<?php
    class ClientUsers{

        // Connection
        private $conn;

        // Table
        private $db_table = "clientusers";

        // Columns
        public $id;
        public $name;
        public $email;
        public $mobile;
        public $longitude;
        public $latitude;
        public $password;
        public $timestamp;

        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL
        public function getClientUsers(){
           $sqlQuery = "SELECT * FROM 
                            " . $this->db_table."";

            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->execute();
            
            return $stmt;
        }

        // CREATE
        public function createClientUsers(){
            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET
                        name = :name,
                        email = :email,
                        mobile = :mobile, 
                        longitude = :longitude, 
                        latitude = :latitude, 
                        password = :password, 
                        timestamp = :timestamp";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->email=htmlspecialchars(strip_tags($this->email));
            $this->mobile=htmlspecialchars(strip_tags($this->mobile));
            $this->longitude=htmlspecialchars(strip_tags($this->longitude));
            $this->latitude=htmlspecialchars(strip_tags($this->latitude));
            $this->password=htmlspecialchars(strip_tags($this->password));
            $this->timestamp=htmlspecialchars(strip_tags($this->timestamp));  
        
            // bind data
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":mobile", $this->mobile);
            $stmt->bindParam(":longitude", $this->longitude);
            $stmt->bindParam(":latitude", $this->latitude);
            $stmt->bindParam(":password", $this->password);
            $stmt->bindParam(":timestamp", $this->timestamp);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // get single
        public function getSingleClientUsers(){
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
            
            $this->name = $dataRow['name'];
            $this->email = $dataRow['email'];
            $this->mobile = $dataRow['mobile'];
            $this->longitude = $dataRow['longitude'];
            $this->latitude = $dataRow['latitude'];
            $this->password = $dataRow['password'];
            $this->timestamp = $dataRow['timestamp'];
        }        

        //login
        public function loginClientUsers(){
            $sqlQuery = "SELECT
                            *
                        FROM
                            ". $this->db_table ."
                        WHERE 
                            email = ?
                        AND 
                            password = ?
                        LIMIT 0,1";

            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->bindParam(1, $this->email);

            $stmt->bindParam(2, $this->password);

            $stmt->execute();

            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->id = $dataRow['id'];
            $this->name = $dataRow['name'];
            $this->email = $dataRow['email'];
            $this->mobile = $dataRow['mobile'];
            $this->longitude = $dataRow['longitude'];
            $this->latitude = $dataRow['latitude'];
            $this->password = $dataRow['password'];
            $this->timestamp = $dataRow['timestamp'];
        }        


        //check record
        public function getCheckSingleClientUsers(){
            $sqlQuery = "SELECT
                            *
                        FROM
                            ". $this->db_table ."
                        WHERE 
                            email = ?
                        LIMIT 0,1";

            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->bindParam(1, $this->email);

            $stmt->execute();

            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->name = $dataRow['name'];
            $this->email = $dataRow['email'];
            $this->mobile = $dataRow['mobile'];
            $this->longitude = $dataRow['longitude'];
            $this->latitude = $dataRow['latitude'];
            $this->password = $dataRow['password'];
            $this->timestamp = $dataRow['timestamp'];
        }        

        // UPDATE
        public function updateClientUsers(){
            $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                        name = :name, 
                        email = :email,
                        mobile = :mobile, 
                        longitude = :longitude, 
                        latitude = :latitude, 
                        password = :password, 
                        timestamp = :timestamp
                    WHERE 
                        id = :id";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->email=htmlspecialchars(strip_tags($this->email));
            $this->mobile=htmlspecialchars(strip_tags($this->mobile));
            $this->longitude=htmlspecialchars(strip_tags($this->longitude));
            $this->latitude=htmlspecialchars(strip_tags($this->latitude));
            $this->password=htmlspecialchars(strip_tags($this->password));
            $this->timestamp=htmlspecialchars(strip_tags($this->timestamp));
            $this->id=htmlspecialchars(strip_tags($this->id));  
        
            // bind data
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":mobile", $this->mobile);
            $stmt->bindParam(":longitude", $this->longitude);
            $stmt->bindParam(":latitude", $this->latitude);
            $stmt->bindParam(":password", $this->password);
            $stmt->bindParam(":timestamp", $this->timestamp);
            $stmt->bindParam(":id", $this->id);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // DELETE
        function deleteClientUsers(){
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

