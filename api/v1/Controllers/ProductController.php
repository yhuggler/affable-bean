<?php
    class ProductController {
        private $productDAO;
        private $middleware;

        public function __construct() {
            $this->productDAO = new ProductDAO();
            $this->middleware = new Middleware();
        }

        public function getProducts() {

        }

        public function createProduct() {

        }

        public function updateProduct() {

        }

        public function deleteProduct() {

        }
    }
?>

