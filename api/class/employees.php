<?php
    class Employee{

        // Connection
        private $conn;

        // Table
        private $db_table = "employee";

        // Columns
        public $id;
        public $name;
        public $email;
        public $age;
        public $designation;
        public $password;

        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL
        public function getEmployees(){
            $sqlQuery = "SELECT 
                            * 
                        FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }

        // CREATE
        public function createEmployee(){
            $sqlQuery = "INSERT INTO
                            ". $this->db_table ."
                        SET
                            name = :name, 
                            email = :email, 
                            age = :age, 
                            designation = :designation, 
                            password = :password,
                            timestamp = :timestamp";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            // sanitize
            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->email=htmlspecialchars(strip_tags($this->email));
            $this->age=htmlspecialchars(strip_tags($this->age));
            $this->designation=htmlspecialchars(strip_tags($this->designation));
            $this->password=htmlspecialchars(strip_tags($this->password));
            $this->timestamp=htmlspecialchars(strip_tags($this->timestamp));
        
            // bind data
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":age", $this->age);
            $stmt->bindParam(":designation", $this->designation);
            $stmt->bindParam(":password", $this->password);
            $stmt->bindParam(":timestamp", $this->timestamp);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // single
        public function getSingleEmployee(){
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
            $this->age = $dataRow['age'];
            $this->designation = $dataRow['designation'];
            $this->password = $dataRow['password'];
        }        

        //login
        public function loginEmployee(){
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
            $this->age = $dataRow['age'];
            $this->designation = $dataRow['designation'];
            $this->password = $dataRow['password'];
        }        

        //check record
        public function getCheckSingleEmployee(){
            $sqlQuery = "SELECT
                        id, 
                        name, 
                        email, 
                        age, 
                        designation, 
                        password
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
            $this->age = $dataRow['age'];
            $this->designation = $dataRow['designation'];
            $this->password = $dataRow['password'];
        }        

        // UPDATE
        public function updateEmployee(){
            $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                        name = :name, 
                        email = :email, 
                        age = :age, 
                        designation = :designation,
                        password = :password
                    WHERE 
                        id = :id";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->email=htmlspecialchars(strip_tags($this->email));
            $this->age=htmlspecialchars(strip_tags($this->age));
            $this->designation=htmlspecialchars(strip_tags($this->designation));
            $this->password=htmlspecialchars(strip_tags($this->password));
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            // bind data
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":age", $this->age);
            $stmt->bindParam(":designation", $this->designation);
            $stmt->bindParam(":password", $this->password);
            $stmt->bindParam(":id", $this->id);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // DELETE
        function deleteEmployee(){
            $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
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

