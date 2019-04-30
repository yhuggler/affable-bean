<?php
    class ProductDAO {
        private $conn;
        private $middleware;

        public function __construct() {
            $dbConn = new DBConnection();
            $this->conn = $dbConn->conn;
        }

        public function getProducts() {

        }
        
        public function getProductsByCategoryId($categoryId) {

        }

        public function createProduct($product) {

        }

        public function updateProduct($product) {

        }

        public function deleteProduct($product) {

        }
    }
?>

