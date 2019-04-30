<?php
    class ShoppingCart {
        public $shoppingCartItems;
        public $totalCost;

        public function __construct($shoppingCartItems, $totalCost) {
            $this->shoppingCartItems = $shoppingCartItems;
            $this->totalCost = $totalCost;
        }
    }
?>
