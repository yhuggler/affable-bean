<?php
    include "DatabaseConfig.php";

    class DBConnection {

		public $conn;

        /**
         * Initialises the database object.
         */
        public function __construct() {
            $this->conn = $this->establishConnection();
        }

        /**
         * Establishes a database connection.
         */
        private function establishConnection() {
            try {
                $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE, DB_USERNAME, DB_PASSWORD);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $conn;
            } catch(PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
        }
    }
?>
