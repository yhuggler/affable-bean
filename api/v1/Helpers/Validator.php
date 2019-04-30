<?php

	class Validator {
		public static function isValidEmail($email) {
			return filter_var($email, FILTER_VALIDATE_EMAIL);	
		}

		public static function isValidName($name) {
			return preg_match("/^[a-zA-Z ]*$/", $name);
		}

		public static function isValidPassword($password) {
			return true;	
			return preg_match("^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$", $password);
		}

		public static function checkSignUpInput($username, $password, $passwordRepeat) {
			if ($username == "" || $username == null)
				return "Your username can't be empty.";

			if ($password == "" || $password == null)
				return "Your password can't be empty.";				
            
            if ($repeatPassword == "" || $repeatPassword == null)
				return "Passwords don't match..";				
		}

		public static function checkSignInInput($email, $password) {
			if ($email == "" || $email == null)
				return "Your email can't be empty.";

			if ($password == "" || $password == null)
				return "Your password can't be empty.";				
		}

		public static function checkArrayForEmptyInput($array) {
			foreach ($array as $key => $value) {
					if ($array[$key] == null)
						return $key . " can't be empty."; 
			}
		}
	}

?>
