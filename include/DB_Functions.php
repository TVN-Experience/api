<?php
class DB_Functions {

	private $conn;

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

    public function addType($type, $description)
    {
        $sql = "INSERT INTO `tvn_types` (`type`, `description`) VALUES ('$type', '$description')";

        if ($this->conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $this->conn->error;
        }
    }

    public function addApartment($type_id, $measurements, $description, $floors)
    {
        $sql = "INSERT INTO `tvn_apartments` (`type_id`, `measurements`, `description`, `floors`) VALUES ($type_id, '$measurements', '$description', '$floors')";

        if ($this->conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $this->conn->error;
        }
    }

    public function addBeacon($apartment_id, $description)
    {
        $sql = "INSERT INTO `tvn_apartments` (`apartment_id`, `description`) VALUES ('$apartment_id', '$description')";

        if ($this->conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $this->conn->error;
        }
    }

    public function addImage($uri)
    {
        $sql = "INSERT INTO `tvn_images` (`uri`) VALUES ('$uri')";

        if ($this->conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $this->conn->error;
        }
    }

    public function addTracking($beacon_id, $start_time, $end_time, $mac_address)
    {
        $sql = "INSERT INTO `tvn_tracking` (`beacon_id`, `start_time`, `end_time`, `mac_address`) VALUES ('$beacon_id', '$start_time', '$end_time', '$mac_address')";

        if ($this->conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $this->conn->error;
        }
    }

    public function getBeacons()
	{
        $beacon = null;

        $query = "SELECT id, apartment_id, description FROM tvn_beacons";

        $result = $this->conn->query($query);

        if ($result->num_rows > 0)
        {
            $count = 0;
            // output data of each row
            while($row = $result->fetch_assoc())
            {
                $beacon[$count]["id"] = $row['id'];
                $beacon[$count]["apartment_id"] = $row['apartment_id'];
                $beacon[$count]["description"] = $row['description'];
                $count++;
            }

            $this->conn->close();
            return $beacon;
        }
        else
        {
            return NULL;
        }
	}



    public function getTrackings()
    {
        $beacon = null;

        $query = "SELECT id, beacon_id, start_time, end_time, mac_address FROM tvn_tracking";

        $result = $this->conn->query($query);

        if ($result->num_rows > 0)
        {
            $count = 0;
            // output data of each row
            while($row = $result->fetch_assoc())
            {
                $beacon[$count]["id"] = $row['id'];
                $beacon[$count]["beacon_id"] = $row['beacon_id'];
                $beacon[$count]["start_time"] = $row['start_time'];
                $beacon[$count]["end_time"] = $row['end_time'];
                $beacon[$count]["mac_address"] = $row['mac_address'];
                $count++;
            }

            $this->conn->close();
            return $beacon;
        }
        else
        {
            return NULL;
        }
    }

	public function getBeaconByID($id)
	{
        $beacon = null;

        $query = "SELECT id, apartment_id, description FROM tvn_beacons WHERE id = '$id'";

        $result = $this->conn->query($query);

        if ($result->num_rows > 0)
        {

            // output data of each row
            while($row = $result->fetch_assoc())
            {
                $beacon[0]["id"] = $row['id'];
                $beacon[0]["apartment_id"] = $row['apartment_id'];
                $beacon[0]["description"] = $row['description'];
            }

            $this->conn->close();
            return $beacon;
        }
        else
        {
            return NULL;
        }
	}

    public function getImagesByApartment($id)
    {
        $images = null;

        $query = "SELECT uri FROM tvn_images JOIN tvn_images_apartments ON tvn_images.id = tvn_images_apartments.images_id WHERE apartments_id  = '$id'";

        $result = $this->conn->query($query);

        if ($result->num_rows > 0)
        {
            // output data of each row
            $count = 0;

            while($row = $result->fetch_assoc())
            {
                $images[$count]["uri"] = $row['uri'];
                $count++;
            }

            $this->conn->close();
            return $images;
        }
        else
        {
            return NULL;
        }
    }

    public function getImages()
    {
        $beacon = null;

        $query = "SELECT id, uri FROM tvn_images";

        $result = $this->conn->query($query);

        if ($result->num_rows > 0)
        {
            $count = 0;
            // output data of each row
            while($row = $result->fetch_assoc())
            {
                $beacon[$count]["id"] = $row['id'];
                $beacon[$count]["uri"] = $row['uri'];
                $count++;
            }

            $this->conn->close();
            return $beacon;
        }
        else
        {
            return NULL;
        }
    }

    public function getApartment($id)
    {
        $apartment = null;

        $query = "SELECT id, type_id, measurements, description, floors, price FROM tvn_apartments WHERE id = '$id'";

        $result = $this->conn->query($query);

        if ($result->num_rows > 0)
        {

            // output data of each row
            while($row = $result->fetch_assoc())
            {
                $apartment[0]["id"] = $row['id'];
                $apartment[0]["type_id"] = $row['type_id'];
                $apartment[0]["measurements"] = $row['measurements'];
                $apartment[0]["description"] = $row['description'];
                $apartment[0]["floors"] = $row['floors'];
                $apartment[0]["price"] = $row['price'];
            }

            $this->conn->close();
            return $apartment;
        }
        else
        {
            return NULL;
        }
    }

    public function getApartments()
    {
        $apartment = null;

        $query = "SELECT id, type_id, measurements, description, floors, price FROM tvn_apartments";

        $result = $this->conn->query($query);

        //var_dump($this->conn);

        if ($result->num_rows > 0)
        {
            $count = 0;
            // output data of each row
            while($row = $result->fetch_assoc())
            {
                $apartment[$count]["id"] = $row['id'];
                $apartment[$count]["type_id"] = $row['type_id'];
                $apartment[$count]["measurements"] = $row['measurements'];
                $apartment[$count]["description"] = $row['description'];
                $apartment[$count]["floors"] = $row['floors'];
                $apartment[$count]["price"] = $row['price'];
                $count++;
            }

            $this->conn->close();

            return $apartment;
        }
        else
        {
            return NULL;
        }
    }

    public function getApartmentsByType($type_id)
	{
		$apartment = null;

		$query = "SELECT id, type_id, measurements, description, floors, price FROM tvn_apartments WHERE type_id = '$type_id'";

        $result = $this->conn->query($query);

        if ($result->num_rows > 0)
		{
            $count = 0;
			// output data of each row
			while($row = $result->fetch_assoc())
			{
                $apartment[$count]["id"] = $row['id'];
                $apartment[$count]["type_id"] = $row['type_id'];
                $apartment[$count]["measurements"] = $row['measurements'];
                $apartment[$count]["description"] = $row['description'];
                $apartment[$count]["floors"] = $row['floors'];
                $apartment[$count]["price"] = $row['price'];
                $count++;
			}

			$this->conn->close();

			return $apartment;
		}
		else
		{
			return NULL;
		}
	}
}

?>
