<?php

    class UserController {
        private $userDAO;

        public function __construct() {
            $this->userDAO = new UserDAO();
        }

        public function login() {
            $inputs = (array) json_decode(file_get_contents("php://input")); 
            $username = isset($inputs['username']) ? $inputs['username'] : null;
            $password = isset($inputs['password']) ? $inputs['password'] : null;

            $result = $this->userDAO->authenticateUser($username, $password);

            ResponseHandler::sendResponseWithMessage(isset($result['user']) ? $result['user'] : "",  $result);
        }
    }
