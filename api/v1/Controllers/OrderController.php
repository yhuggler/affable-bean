<?php
    class OrderController {
        private $orderDAO;
        private $middleware;

        public function __construct() {
            $this->orderDAO = new OrderDAO();
            $this->middleware = new Middleware();
        }

        // If admin => show all, if regular user => show only the ones from the user
        public function getOrders() {
            $request = $this->middleware->checkAuth();
            $this->middleware->checkPrivilegies($request['user'], 2);

            $response = $this->orderDAO->getOrders();
            ResponseHandler::sendResponseWithData("", $response);
        }

        public function createOrder() {
            $request = $this->middleware->checkAuth();        
            $userId = $request['user']->id;
        
            $response = $this->orderDAO->createOrder($userId);
            ResponseHandler::sendResponseWithMessage("", $response);
        }

        public function deleteOrder() {

        }

    }
?>  
