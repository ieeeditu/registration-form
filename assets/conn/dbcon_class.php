<?php class Db {
    // The database connection
    protected static $connection;

    /**
     * Connect to the database
     * 
     * @return bool false on failure / mysqli MySQLi object instance on success
     */
    public function dbconnect() {    
        // Try and connect to the database
        if(!isset(self::$connection)) {
            // Load configuration as an array. Use the actual location of your configuration file
           // echo DB_HOST." ".DB_USER." ".DB_NAME;
            self::$connection = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
        }

        // If connection was not successful, handle the error
        if(self::$connection === false) {
            // Handle error - notify administrator, log to a file, show an error screen, etc.
            return false;
        }
        return self::$connection;
    }
	
    public function dbclose() {    
			$connection = $this -> dbconnect();
			mysqli_close($connection);
    }

    /**
     * Query the database
     *
     * @param $query The query string
     * @return mixed The result of the mysqli::query() function
     */
    public function query($query) {
        // Connect to the database
        $connection = $this -> dbconnect();
      
        // Query the database
        $result = $connection -> query($query);
 //print_r($result);
        return $result;
    }

    /**
     * Fetch rows from the database (SELECT query)
     *
     * @param $query The query string
     * @return bool False on failure / array Database rows on success
     */
    public function select($query) {
		
        $rows = array();
		
        $result = $this -> query($query);
        if($result === false) {
            return false;
        }
        while ($row = $result -> fetch_assoc()) {
           $rows[] = $row;
        }
	//	print_r($rows);
        return $rows;
    }

    /**
     * Fetch the last error from the database
     * 
     * @return string Database error message
     */
    public function error() {
        $connection = $this -> dbconnect();
        return $connection -> error;
    }
    
    /**
     * Quote and escape value for use in a database query
     *
     * @param string $value The value to be quoted and escaped
     * @return string The quoted and escaped string
     */
    public function quote($value) {
        $connection = $this -> dbconnect();
        return "'" . $connection -> real_escape_string($value) . "'";
    }
	
	public function ping() {
		
        $connection = $this -> dbconnect();
        if($connection ->ping()){
			$pingresult = "Our connection is ok!\n";
		}else{
			 $pingresult = "Error: Disconnected : ".($this -> error());
			//$pingresult = "Error: Disconnected";
		}
		
		return $pingresult;
		
    }
		
	
}?>