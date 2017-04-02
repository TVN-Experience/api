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
