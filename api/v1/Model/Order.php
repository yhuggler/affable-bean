<?php
    class Order {
        public $id;
        public $amount;
        public $dateCreated;
        public $confirmationNumber;
        public $userId;
        public $promoCode;
        public $products;

        public function __construct($id, $amount, $dateCreated, $confirmationNumber, $userId, $promoCode, $products) {
            $this->id = $id;
            $this->amount = $amount;
            $this->dateCreated = $dateCreated;
            $this->confirmationNumber = $confirmationNumber;
            $this->userId = $userId;
            $this->promoCode = $promoCode;
            $this->products = $products;
        }
    }
?>
