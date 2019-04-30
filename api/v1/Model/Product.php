<?php
    class Product {
        public $id;
        public $name;
        public $price;
        public $description;
        public $lastUpdate;
        public $categoryId;

        public function __construct($id, $name, $price, $description, $lastUpdate, $categoryId) {
            $this->id = $id;
            $this->name = $name;
            $this->price = $price;
            $this->description = $description;
            $this->lastUpdate = $lastUpdate;
            $this->categoryId = $categoryId;
        }
    }
?>
