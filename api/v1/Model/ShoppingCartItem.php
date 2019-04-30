<?php
    class ShoppingCartItem {
        public $id;
        public $userId;
        public $productId;
        public $quantity;
        
        public function __construct($id, $userId, $productId, $quantity) {
            $this->id = $id;
            $this->userId = $userId; 
            $this->productId = $productId; 
            $this->quantity = $quantity;
        }
    }
?>
