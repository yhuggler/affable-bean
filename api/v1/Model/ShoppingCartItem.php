<?php
    class ShoppingCartItem {
        public $id;
        public $userId;
        public $product;
        public $quantity;
        
        public function __construct($id, $userId, $product, $quantity) {
            $this->id = $id;
            $this->userId = $userId; 
            $this->product= $product; 
            $this->quantity = $quantity;
        }
    }
?>
