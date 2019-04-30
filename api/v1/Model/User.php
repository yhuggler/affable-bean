<?php
	class User {
		public $id;
        public $email;
        public $name;
        public $phone;
        public $street;
        public $city;
        public $creditCardNumber;
        public $role;

		public function __construct($id, $email, $name, $phone, $street, $city, $creditCardNumber, $role) {
			$this->id = $id;
            $this->email = $email;
            $this->name = $name;
            $this->phone = $phone;
            $this->street = $street;
            $this->city = $city;
            $this->creditCardNumber = $creditCardNumber;
            $this->role = $role;
		}
	}
?>
