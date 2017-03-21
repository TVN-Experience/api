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

	public function getFriends($system_id)
	{
		$events = null;
		
		$query = "SELECT id, systems_id, burguard_users_id FROM burguard_trustees WHERE systems_id = '$system_id'";

        $result = $this->conn->query($query);

        if ($result->num_rows > 0) 
		{
			$count = 0;
			
			// output data of each row
			while($row = $result->fetch_assoc()) 
			{
				$events[$count]["id"] = $row['id'];
				$events[$count]["systems_id"] = $row['systems_id'];
				$events[$count]["burguard_users_id"] = $row['burguard_users_id'];
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

	public function addFriend($alarm_id, $username)
	{
		$sql = "INSERT INTO `burguard_trustees` (`systems_id`, `burguard_users_id`) VALUES ('$alarm_id', '$username')";

		if ($this->conn->query($sql) === TRUE) {
			echo "New record created successfully";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}
	
	public function triggerEvent($alarm_id)
	{
		$sql = "INSERT INTO `burguard_events` (`alarm_id`, `timestamp`) VALUES ('$alarm_id', now());";

		if ($this->conn->query($sql) === TRUE) {
			echo "New record created successfully";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}
	
    /**
     * Storing new user
     * returns user details
     */
    public function storeUser($name, $email, $password) {
        $uuid = uniqid('', true);
        $hash = $this->hashSSHA($password);
        $encrypted_password = $hash["encrypted"]; // encrypted password
        $salt = $hash["salt"]; // salt

        $stmt = $this->conn->prepare("INSERT INTO burguard_users(unique_id, name, email, encrypted_password, salt, created_at) VALUES(?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("sssss", $uuid, $name, $email, $encrypted_password, $salt);
        $result = $stmt->execute();
        $stmt->close();

        // check for successful store
        if ($result) 
		{
			$user = "";
					
            $stmt = $this->conn->prepare("SELECT unique_id, name, email, encrypted_password, salt, created_at, updated_at FROM burguard_users WHERE email = ?");
			$stmt->bind_param("s", $email);
			$stmt->execute();
			$stmt->bind_result($uuid, $name, $email, $password, $salt, $createdate, $updatedate);

			while($stmt->fetch())
			{
				$user["name"] = $name;
				$user["email"] = $email;
				$user["unique_id"] = $uuid;
				$user["created_at"] = $createdate;
				$user["updated_at"] = $updatedate;
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
