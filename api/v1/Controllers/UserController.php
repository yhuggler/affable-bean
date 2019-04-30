<?php

    class UserController {
        private $userDAO;

        public function __construct() {
            $this->userDAO = new UserDAO();
        }

        public function signin() {
            $inputs = (array) json_decode(file_get_contents("php://input")); 
            $email = isset($inputs['email']) ? $inputs['email'] : null;
            $password = isset($inputs['password']) ? $inputs['password'] : null;

            $result = $this->userDAO->authenticateUser($email, $password);

            ResponseHandler::sendResponseWithMessage(isset($result['user']) ? $result['user'] : "",  $result);
        }

        public function signup() {
            $inputs = (array) json_decode(file_get_contents("php://input")); 

            $user = array();

            $user['email'] = isset($inputs['email']) ? $inputs['email'] : null;
            
            $user['password'] = isset($inputs['password']) ? $inputs['password'] : null;
            $user['repeatPassword'] = isset($inputs['repeatPassword']) ? $inputs['repeatPassword'] : null;
            
            $user['name'] = isset($inputs['name']) ? $inputs['name'] : null;
            $user['phone'] = isset($inputs['phone']) ? $inputs['phone'] : null;
            $user['street'] = isset($inputs['street']) ? $inputs['street'] : null;
            $user['city'] = isset($inputs['city']) ? $inputs['city'] : null;
            $user['creditCardNumber'] = isset($inputs['creditCardNumber']) ? $inputs['creditCardNumber'] : null;

            $result = $this->userDAO->signupUser($user);

            ResponseHandler::sendResponseWithMessage(isset($result['user']) ? $result['user'] : "",  $result);

        }
    }
