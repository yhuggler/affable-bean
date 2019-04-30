<?php
    class CartController {
        private $cartDAO;
        private $middleware;
        
        public function __construct() {
            $this->cartDAO = new CartDAO();
            $this->middleware = new Middleware();
        }

        public function getCart() {
            $request = $this->middleware->checkAuth();    
            $userId = $request['user']->id;
            
            $result = $this->cartDAO->getCart($userId);  
            ResponseHandler::SendresponseWithData("", $result);
        }

        public function addToCart() {
            $request = $this->middleware->checkAuth();    
            $userId = $request['user']->id;
            $productId = $request['inputs']['productId'];

            $result = $this->cartDAO->addToCart($userId, $productId);  
            ResponseHandler::SendresponseWithMessage("", $result);
        }

        public function updateQuantity() {
            $request = $this->middleware->checkAuth();    
            $userId = $request['user']->id;
            
            $result = $this->cartDAO->getCart($userId);  
            ResponseHandler::SendresponseWithData("", $result);
        } 

        public function deleteItem() {
            $request = $this->middleware->checkAuth();    
            $userId = $request['user']->id;
            
            $result = $this->cartDAO->getCart($userId);  
            ResponseHandler::SendresponseWithData("", $result);
        }

        public function clearCart() {
            $request = $this->middleware->checkAuth();    
            $userId = $request['user']->id;
            
            $result = $this->cartDAO->clearCart($userId);  
            ResponseHandler::SendresponseWithMessage("", $result);
        }

    }
?>
