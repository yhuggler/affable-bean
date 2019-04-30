<?php
    class OrderDAO {
        private $conn;
        private $middleware;

        public function __construct() {
            $dbConn = new DBConnection();
            $this->conn = $dbConn->conn;
        }

        public function getOrders() {

        }

        public function getOrdersByUserId($userId) {

        }

        public function createOrder($order) {
        
        }

        public function deleteOrder($orderId) {

        }
    }

?>

