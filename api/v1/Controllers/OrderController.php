<?php
    class OrderController {
        private $orderDAO;
        private $middleware;

        public function __construct() {
            $this->orderDAO = new OrderDAO();
            $this->middleware = new Middleware();
        }

        public function getOrders() {
            $request = $this->middleware->checkAuth();
                
            if ($request['user']->role == 2)
                $response = $this->orderDAO->getOrders(-1);
            else
                $response = $this->orderDAO->getOrders($request['user']->id);
            
            ResponseHandler::sendResponseWithData("", $response);
        }

        public function createOrder() {
            $request = $this->middleware->checkAuth();        
            $userId = $request['user']->id;
            $promoCode = $request['inputs']['promoCode'];

            $response = $this->orderDAO->createOrder($userId, $promoCode);
            ResponseHandler::sendResponseWithMessage("", $response);
        }
    }
?>  
