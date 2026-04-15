<?php declare(strict_types=1);

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'root');
define('DB_NAME', 'ca_firm');

class Database {
    private static $instance = null;
    private $mysqli;

    private function __construct() {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        try {
            $this->mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            $this->mysqli->set_charset('utf8mb4');
        } catch (mysqli_sql_exception $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance(): mysqli {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance->mysqli;
    }
}

$mysqli = Database::getInstance();
