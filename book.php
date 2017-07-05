<?php
session_start();

// Initialization Of Database Control Object
$dsn = "mysql://hostname=localhost;dbname=book"; // Data Source Name
$user = "root";
$pass = "mysql";
$options = array(            // PDO Options
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'
);
// Connect to Database
try {
    $db = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    echo $e->getMessage();
}

// Database Controller Class
class DBController {
    // Prepare Data Values
    protected function prepareValues(PDOStatement &$stmt) {
        foreach (static::$tableSchema as $col => $type) {
            $stmt->bindParam(":{$col}", $this->$col, $type);
        }
    }

    // Bind SQL Parameters
    private function bindSQLParameters() {
        $sqlParams = '';
        foreach (static::$tableSchema as $col => $type) {
            $sqlParams .= $col . ' = :' . $col . ', ';
        }
        return trim($sqlParams, ', ');
    }

    // Create Reservation
    public function create() {
        global $db;

        // Create Reservation SQL Statement
        $sql = 'INSERT INTO ' . static::$tableName . ' SET ' . self::bindSQLParameters();

        // Prepare & Execute SQL Query
        $stmt = $db->prepare($sql);
        $this->prepareValues($stmt);
        return $stmt->execute();
    }

    // Update Reservation
    public function update() {
        global $db;

        // Update Reservation SQL Statement
        $sql = 'UPDATE ' . static::$tableName . ' SET ' . self::bindSQLParameters() . ' WHERE ' . static::$primaryKey . ' = ' . $this->{static::$primaryKey};

        // Prepare & Execute SQL Query
        $stmt = $db->prepare($sql);
        $this->prepareValues($stmt);
        return $stmt->execute();
    }

    // Delete Reservation
    public function delete() {
        global $db;

        // Delete Reservation SQL Statement
        $sql = 'DELETE FROM ' . static::$tableName . ' WHERE ' . static::$primaryKey . ' = ' . $this->{static::$primaryKey};

        // Prepare & Execute SQL Query
        $stmt = $db->prepare($sql);
        return $stmt->execute();
    }

    // Get All Reservations Data
    public function getAll() {
        global $db;

        // Get SQL Statement
        $sql = 'SELECT * FROM ' . static::$tableName;

        // Prepare & Execute SQL Query
        $stmt = $db->prepare($sql);
        if ($stmt->execute() === true) {
            return $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, static::$className, array_keys(static::$tableSchema));
        } else {
            return false;
        }
    }

    // Get Reservation Data By Primary Key
    public function getByID($pk) {
        global $db;

        // Get User Data By PK SQL Statement
        $sql = 'SELECT * FROM ' . static::$tableName . ' WHERE ' . static::$primaryKey . ' = ' . $pk;

        // Prepare & Execute SQL Query
        $stmt = $db->prepare($sql);
        if ($stmt->execute() === true) {
            $obj = $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, static::$className, array_keys(static::$tableSchema));
            return array_shift($obj);
        }
        return false;
    }

    // Get Table Name
    public static function getTableName() {
        return static::$tableName;
    }
}

// Users Data Controller Class
class Book extends DBController {
    protected $id;
    protected $name;
    protected $email;
    protected $telephone;
    protected $departureDateTime;
    protected $returnDateTime;
    protected $pickAddr;
    protected $distAddr;
    protected $journeyType;
    protected $passengers;
    protected $notes;
    protected $complete;

    protected static $primaryKey = 'id';    // Primary Key Name
    protected static $tableName = "reservations";  // Table Name
    public static $tableSchema = array(     // Table Schema & Data Type
        'id' => PDO::PARAM_INT,
        'name' => PDO::PARAM_STR,
        'email' => PDO::PARAM_STR,
        'telephone' => PDO::PARAM_STR,
        'departureDateTime' => PDO::PARAM_STR,
        'returnDateTime' => PDO::PARAM_STR,
        'pickAddr' => PDO::PARAM_STR,
        'distAddr' => PDO::PARAM_STR,
        'journeyType' => PDO::PARAM_STR,
        'passengers' => PDO::PARAM_INT,
        'notes' => PDO::PARAM_STR,
        'complete' => PDO::PARAM_INT
    );
    protected static $className = __CLASS__;

    public function __construct($name, $email, $telephone, $departureDateTime, $returnDateTime, $pickAddr, $distAddr, $journeyType, $passengers, $notes, $complete) {
        $this->name = $name;
        $this->email = $email;
        $this->telephone = $telephone;
        $this->departureDateTime = $departureDateTime;
        $this->returnDateTime = $returnDateTime;
        $this->pickAddr = $pickAddr;
        $this->distAddr = $distAddr;
        $this->journeyType = $journeyType;
        $this->passengers = $passengers;
        $this->notes = $notes;
        $this->complete = $complete;
    }

    // Get
    public function __get($prop) {
        return $this->$prop;
    }

    // Set
    public function __set($prop, $value) {
        $this->$prop = $value;
    }
}