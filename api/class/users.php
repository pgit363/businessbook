<?php
    class Users{

        // Connection
        private $conn;

        // Table
        private $db_table = "users";

        // Columns
        public $id;
        public $name;
        public $email;
        public $password;
        public $dob;
        public $address1;
        public $address2;
        public $address3;
        public $state;
        public $city;
        public $zip;
        public $longitude;
        public $latitude;
        public $department;
        public $type;
        public $gov_regi;
        public $working_hour;
        public $starttime;
        public $endtime;
        public $timestamp;

        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL
        public function getUsers(){
            $sqlQuery = "SELECT * FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }

        // CREATE
        public function createUser(){
            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET
                        name = :name, 
                        email = :email,
                        password = :password,
                        dob = :dob, 
                        address1 = :address1, 
                        address2 = :address2, 
                        address3 = :address3, 
                        state = :state,
                        city = :city,
                        zip = :zip,
                        longitude = :longitude,
                        latitude = :latitude,
                        department = :department,
                        type = :type,
                        gov_regi = :gov_regi,
                        working_hour = :working_hour,
                        starttime = :starttime,
                        endtime = :endtime,
                        timestamp = :timestamp";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->email=htmlspecialchars(strip_tags($this->email));
            $this->password=htmlspecialchars(strip_tags($this->password));
            $this->dob=htmlspecialchars(strip_tags($this->dob));
            $this->address1=htmlspecialchars(strip_tags($this->address1));
            $this->address2=htmlspecialchars(strip_tags($this->address2));
            $this->address3=htmlspecialchars(strip_tags($this->address3));
            $this->state=htmlspecialchars(strip_tags($this->state));
            $this->city=htmlspecialchars(strip_tags($this->city));
            $this->zip=htmlspecialchars(strip_tags($this->zip));
            $this->longitude=htmlspecialchars(strip_tags($this->longitude));
            $this->latitude=htmlspecialchars(strip_tags($this->latitude));
            $this->department=htmlspecialchars(strip_tags($this->department));
            $this->type=htmlspecialchars(strip_tags($this->type));
            $this->gov_regi=htmlspecialchars(strip_tags($this->gov_regi));
            $this->working_hour=htmlspecialchars(strip_tags($this->working_hour));
            $this->starttime=htmlspecialchars(strip_tags($this->starttime));
            $this->endtime=htmlspecialchars(strip_tags($this->endtime));
            $this->timestamp=htmlspecialchars(strip_tags($this->timestamp));  
            $this->id=htmlspecialchars(strip_tags($this->id));
            
        
            // bind data
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":password", $this->password);
            $stmt->bindParam(":dob", $this->dob);
            $stmt->bindParam(":address1", $this->address1);
            $stmt->bindParam(":address2", $this->address2);
            $stmt->bindParam(":address3", $this->address3);
            $stmt->bindParam(":state", $this->state);
            $stmt->bindParam(":city", $this->city);
            $stmt->bindParam(":zip", $this->zip);
            $stmt->bindParam(":longitude", $this->longitude);
            $stmt->bindParam(":latitude", $this->latitude);
            $stmt->bindParam(":department", $this->department);
            $stmt->bindParam(":type", $this->type);
            $stmt->bindParam(":gov_regi", $this->gov_regi);
            $stmt->bindParam(":working_hour", $this->working_hour);
            $stmt->bindParam(":starttime", $this->starttime);
            $stmt->bindParam(":endtime", $this->endtime);
            $stmt->bindParam(":timestamp", $this->timestamp);
           
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // UPDATE
        public function getSingleUser(){
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
            $this->password = $dataRow['password'];
            $this->dob = $dataRow['dob'];
            $this->address1 = $dataRow['address1'];
            $this->address2 = $dataRow['address2'];
            $this->address3 = $dataRow['address3'];
            $this->state = $dataRow['state'];
            $this->city = $dataRow['city'];
            $this->zip = $dataRow['zip'];
            $this->longitude = $dataRow['longitude'];
            $this->latitude = $dataRow['latitude'];
            $this->department = $dataRow['department'];
            $this->type = $dataRow['type'];
            $this->gov_regi = $dataRow['gov_regi'];
            $this->working_hour = $dataRow['working_hour'];
            $this->starttime = $dataRow['starttime'];
            $this->endtime = $dataRow['endtime'];
            $this->timestamp = $dataRow['timestamp'];
        }        


        // LOGIN
        public function loginUser(){
            $sqlQuery = "SELECT
                            *
                        FROM
                            ". $this->db_table ."
                        WHERE 
                            password = ?
                        AND
                            email = ?
                        LIMIT 0,1";

            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->bindParam(1, $this->password);

            $stmt->bindParam(2, $this->email);

            $stmt->execute();

            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
           
            $this->id = $dataRow['id'];
            $this->name = $dataRow['name'];
            $this->email = $dataRow['email'];
            $this->password = $dataRow['password'];
            $this->dob = $dataRow['dob'];
            $this->address1 = $dataRow['address1'];
            $this->address2 = $dataRow['address2'];
            $this->address3 = $dataRow['address3'];
            $this->state = $dataRow['state'];
            $this->city = $dataRow['city'];
            $this->zip = $dataRow['zip'];
            $this->longitude = $dataRow['longitude'];
            $this->latitude = $dataRow['latitude'];
            $this->department = $dataRow['department'];
            $this->type = $dataRow['type'];
            $this->gov_regi = $dataRow['gov_regi'];
            $this->working_hour = $dataRow['working_hour'];
            $this->starttime = $dataRow['starttime'];
            $this->endtime = $dataRow['endtime'];
            $this->timestamp = $dataRow['timestamp'];
        }        


        //check record
        public function getCheckSingleUser(){
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
            $this->password = $dataRow['password'];
            $this->dob = $dataRow['dob'];
            $this->address1 = $dataRow['address1'];
            $this->address2 = $dataRow['address2'];
            $this->address3 = $dataRow['address3'];
            $this->state = $dataRow['state'];
            $this->city = $dataRow['city'];
            $this->zip = $dataRow['zip'];
            $this->longitude = $dataRow['longitude'];
            $this->latitude = $dataRow['latitude'];
            $this->department = $dataRow['department'];
            $this->type = $dataRow['type'];
            $this->gov_regi = $dataRow['gov_regi'];
            $this->working_hour = $dataRow['working_hour'];
            $this->starttime = $dataRow['starttime'];
            $this->endtime = $dataRow['endtime'];
            $this->timestamp = $dataRow['timestamp'];
        }        

        // UPDATE
        public function updateUser(){
            $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                        name = :name, 
                        email = :email, 
                        password = :password, 
                        dob = :dob, 
                        address1 = :address1, 
                        address2 = :address2, 
                        address3 = :address3, 
                        state = :state,
                        city = :city,
                        zip = :zip,
                        department = :department,
                        type = :type,
                        gov_regi = :gov_regi,
                        working_hour = :working_hour,
                        starttime = :starttime,
                        endtime = :endtime,
                        timestamp = :timestamp
                    WHERE 
                        id = :id";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->email=htmlspecialchars(strip_tags($this->email));
            $this->password=htmlspecialchars(strip_tags($this->password));
            $this->dob=htmlspecialchars(strip_tags($this->dob));
            $this->address1=htmlspecialchars(strip_tags($this->address1));
            $this->address2=htmlspecialchars(strip_tags($this->address2));
            $this->address3=htmlspecialchars(strip_tags($this->address3));
            $this->state=htmlspecialchars(strip_tags($this->state));
            $this->city=htmlspecialchars(strip_tags($this->city));
            $this->zip=htmlspecialchars(strip_tags($this->zip));
            // $this->longitude=htmlspecialchars(strip_tags($this->longitude));
            // $this->latitude=htmlspecialchars(strip_tags($this->latitude));
            $this->department=htmlspecialchars(strip_tags($this->department));
            $this->type=htmlspecialchars(strip_tags($this->type));
            $this->gov_regi=htmlspecialchars(strip_tags($this->gov_regi));
            $this->working_hour=htmlspecialchars(strip_tags($this->working_hour));
            $this->starttime=htmlspecialchars(strip_tags($this->starttime));
            $this->endtime=htmlspecialchars(strip_tags($this->endtime));
            $this->timestamp=htmlspecialchars(strip_tags($this->timestamp));  
            $this->id=htmlspecialchars(strip_tags($this->id));
            
        
            // bind data
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":password", $this->password);
            $stmt->bindParam(":dob", $this->dob);
            $stmt->bindParam(":address1", $this->address1);
            $stmt->bindParam(":address2", $this->address2);
            $stmt->bindParam(":address3", $this->address3);
            $stmt->bindParam(":state", $this->state);
            $stmt->bindParam(":city", $this->city);
            $stmt->bindParam(":zip", $this->zip);
            // $stmt->bindParam(":longitude", $this->longitude);
            // $stmt->bindParam(":latitude", $this->latitude);
            $stmt->bindParam(":department", $this->department);
            $stmt->bindParam(":type", $this->type);
            $stmt->bindParam(":gov_regi", $this->gov_regi);
            $stmt->bindParam(":working_hour", $this->working_hour);
            $stmt->bindParam(":starttime", $this->starttime);
            $stmt->bindParam(":endtime", $this->endtime);
            $stmt->bindParam(":timestamp", $this->timestamp);
            $stmt->bindParam(":id", $this->id);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // DELETE
        function deleteUser(){
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

