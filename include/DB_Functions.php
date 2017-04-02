<?php
class DB_Functions {

	private $conn,
			$name = null,
			$email = null,
			$password = null,
			$createdate = null,
			$updatedate = null,
			$salt = null,
			$event_id = null,
			$timestamp = null,
			$crownstone = null,
			$alarm_id = null;

    // constructor
    function __construct() {
        require_once 'DB_Connect.php';
        // connecting to database
        $db = new Db_Connect();
        $this->conn = $db->connect();
    }

    // destructor
    function __destruct() {
        
    }

    public function getType($type_id)
    {
    	$type = null;

        $query = "SELECT id, type, description FROM tvn_types WHERE id = '$type_id'";

        $result = $this->conn->query($query);

        //var_dump($this->conn);

        if ($result->num_rows > 0)
        {
            // output data of each row
            while($row = $result->fetch_assoc())
            {
                $type["id"] = $row['id'];
                $type["type"] = $row['type'];
                $type["description"] = $row['description'];
            }

            $this->conn->close();

            return $type;
        }
        else
        {
            return NULL;
        }
    }

    public function getTypes()
    {
        $types = null;

        $query = "SELECT id, type, description FROM tvn_types";

        $result = $this->conn->query($query);

        //var_dump($this->conn);

        if ($result->num_rows > 0)
        {
            $count = 0;

            // output data of each row
            while($row = $result->fetch_assoc())
            {
                $types[$count]["id"] = $row['id'];
                $types[$count]["type"] = $row['type'];
                $types[$count]["description"] = $row['description'];
                $count++;
            }

            $this->conn->close();

            return $types;
        }
        else
        {
            return NULL;
        }
    }


    public function getAppartment($type_id)
	{
		$appartment = null;
		
		$query = "SELECT id, type_id, measurements, description, floors FROM tvn_apartments WHERE type_id = '$type_id'";

        $result = $this->conn->query($query);

     //   var_dump($this->conn);

        if ($result->num_rows > 0) 
		{
			// output data of each row
			while($row = $result->fetch_assoc()) 
			{
                $appartment["id"] = $row['id'];
                $appartment["type_id"] = $row['type_id'];
                $appartment["measurements"] = $row['measurements'];
                $appartment["description"] = $row['description'];
                $appartment["floors"] = $row['floors'];
			}
			
			$this->conn->close();
			
			return $appartment;
		}
		else
		{
			return NULL;
		}
	}
	
	public function getEvents($system_id)
	{
		$events = null;
		
		$query = "SELECT id, alarm_id, timestamp FROM burguard_events WHERE alarm_id = '$system_id'";

        $result = $this->conn->query($query);

        if ($result->num_rows > 0) 
		{
			$count = 0;
			
			// output data of each row
			while($row = $result->fetch_assoc()) 
			{
				$events[$count]["id"] = $row['id'];
				$events[$count]["alarm_id"] = $row['alarm_id'];
				$events[$count]["timestamp"] = $row['timestamp'];
				$count++;
			}
			
			$this->conn->close();
			
			return $events;
		}
		else
		{
			return NULL;
		}
	}
	
    /**
     * Storing new user
     * returns user details
     */
    public function storeUser($name, $email, $password) {
        $hash = $this->hashSSHA($password);
        $encrypted_password = $hash["encrypted"]; // encrypted password
        $salt = $hash["salt"]; // salt

        $stmt = $this->conn->prepare("INSERT INTO tvn_users(username, password, salt) VALUES(?, ?, ?)");
        $stmt->bind_param("sssss", $email, $encrypted_password, $salt);
        $result = $stmt->execute();
        $stmt->close();

        // check for successful store
        if ($result) 
		{
			$user = "";
            $stmt = $this->conn->prepare("SELECT username, password, salt FROM tvn_users WHERE username = ?");
			$stmt->bind_param("s", $email);
			$stmt->execute();
			$stmt->bind_result($email, $password, $salt);

			while($stmt->fetch())
			{
				$user["name"] = $name;
				$user["email"] = $email;
			}
			
			$stmt->close();
	
			return $user;
        } 
		else {
            return false;
        }
    }

    /**
     * Get user by email and password
     */
    public function getUserByEmailAndPassword($email, $password2) {

        $stmt = $this->conn->prepare("SELECT unique_id, name, email, encrypted_password, salt, created_at, updated_at, crownstone_id FROM burguard_users WHERE email = ?");

        $stmt->bind_param("s", $email);

        if ($stmt->execute()) {
			
			$stmt->bind_result($uuid, $name, $email, $password, $salt, $createdate, $updatedate, $crownstone);
			
			while($stmt->fetch())
			{
				$user["name"] = $name;
				$user["email"] = $email;
				$user["unique_id"] = $uuid;
				$user["created_at"] = $createdate;
				$user["updated_at"] = $updatedate;
				$user["crownstone_id"] = $crownstone;
			}
			
			$stmt->close();

            // verifying user password
            $encrypted_password = $password;
            $hash = $this->checkhashSSHA($salt, $password2);
            // check for password equality
            if ($encrypted_password == $hash) {
                // user authentication details are correct
                return $user;
            }
        } else {
            return NULL;
        }
    }

    /**
     * Check user is existed or not
     */
    public function isUserExisted($email) {
        $stmt = $this->conn->prepare("SELECT email from burguard_users WHERE email = ?");

        $stmt->bind_param("s", $email);

        $stmt->execute();

        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // user existed 
            $stmt->close();
            return true;
        } else {
            // user not existed
            $stmt->close();
            return false;
        }
    }

    /**
     * Encrypting password
     * @param password
     * returns salt and encrypted password
     */
    public function hashSSHA($password) {

        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }

    /**
     * Decrypting password
     * @param salt, password
     * returns hash string
     */
    public function checkhashSSHA($salt, $password) {

        $hash = base64_encode(sha1($password . $salt, true) . $salt);

        return $hash;
    }

}

?>
