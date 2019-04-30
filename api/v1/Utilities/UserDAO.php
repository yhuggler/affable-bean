<?php

class UserDAO {

	private $conn;

	public function __construct() {
		$dbConn = new DBConnection();
		$this->conn = $dbConn->conn;
	}

	public function authenticateUser($email, $password) {
		try {
			$response = array();

			if (Validator::checkSignInInput($email, $password)) {
				$response['error_message'] = Validator::checkSignInInput($email, $password);
				$response['error'] = 'bad_request';
				return $response;
			}

			$sql = "SELECT * FROM users WHERE email = :email";
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(':email', $email, PDO::PARAM_STR);
			$stmt->execute();

			$result = $stmt->fetchAll();
        
            if (!empty($result)) {
                $user = $result[0];
                
                if (password_verify($password, $user["password"])) {
                    $response['message'] = "You successfully signed in!";
                    $response['user'] = new User($user['id'], $user['email'], $user['name'], $user['phone'], $user['street'], $user['city'], $user['credit_card_number'], $user['role']);
                    return $response;
                } else {
                    $response['error_message'] = "You username or password is wrong. Please try again.";
                    $response['error'] = 'bad_request';
                    return $response;
                }
            } else {
                $response['error_message'] = "You username or password is wrong. Please try again.";
				$response['error'] = 'bad_request';
				return $response;
            }
		} catch (Exception $e) {
			LoggerHelper::addLogToDB(LoggingSeverity::Warning, $e->getMessage());
			$response['error'] = $e->getMessage();
			$response['error_message'] = "Internal Server Error";
			return $response;
		}
    }

    public function signupUser($user) {
        try {
            $response = array();

            if (Validator::checkArrayForEmptyInput($user)) {
				$response['error_message'] = Validator::checkArrayForEmptyInput($user) ;
				$response['error'] = 'bad_request';
				return $response;
            }

            if ($user['password'] === $user['repeatPassword']) {
                $passwordHash = password_hash($user['password'], PASSWORD_BCRYPT);

                $sql = "INSERT INTO users(email, password, name, phone, street, city, credit_card_number) VALUES(:email, :password, :name, :phone, :street, :city, :credit_card_number)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':email', $user['email'], PDO::PARAM_STR);
                $stmt->bindParam(':password', $passwordHash, PDO::PARAM_STR);
                $stmt->bindParam(':name', $user['name'], PDO::PARAM_STR);
                $stmt->bindParam(':phone', $user['phone'], PDO::PARAM_STR);
                $stmt->bindParam(':street', $user['street'], PDO::PARAM_STR);
                $stmt->bindParam(':city', $user['city'], PDO::PARAM_STR);
                $stmt->bindParam(':credit_card_number', $user['creditCardNumber'], PDO::PARAM_STR);

                $stmt->execute();
                $response["message"] = "You successfully signed up";
                return $response;
            } else {
				$response['error_message'] = "The passwords don't match!";
				$response['error'] = 'bad_request';
				return $response;
            }

		} catch (Exception $e) {
			LoggerHelper::addLogToDB(LoggingSeverity::Warning, $e->getMessage());
			$response['error'] = $e->getMessage();
			$response['error_message'] = "Internal Server Error";
			return $response;
		}
    }

}
