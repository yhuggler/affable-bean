<?php
	class User {
		public $id;
		public $username;
        public $role;
        public $customerId;

		public function __construct($id, $username, $role, $customerId) {
			$this->id = $id;
            $this->username = $username;
            $this->role = $role;
            $this->customerId = $customerId;
		}
	}
?>
