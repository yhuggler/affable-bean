<?php
    class Category {
        public $id;
        public $categoryName;

        public function __construct($id, $categoryName) {
            $this->id = $id;
            $this->categoryName = $categoryName;
        }
    }
?>
