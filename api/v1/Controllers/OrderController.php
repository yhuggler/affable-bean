<?php
    class OrderController {
        private $orderDAO;
        private $middleware;

        public function __construct() {
            $this->orderDAO = new OrderDAO();
            $this->middleware = new Middleware();
        }

        public function getOrders() {

        }

        public function getOrdersByUserId() {

        }

        public function createOrder() {
        
        }

        public function deleteOrder() {

        }

    }
?>  
