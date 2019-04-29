<?php

class UserDAO {

	private $conn;

	public function __construct() {
		$dbConn = new DBConnection();
		$this->conn = $dbConn->conn;
	}

	public function authenticateUser($username, $password) {
		try {
			$data = array();
            $customerDAO = new CustomerDAO();

			if (Validator::checkSignInInput($username, $password)) {
				$data['error_message'] = Validator::checkSignInInput($username, $password);
				return $data;
			}

			$sql = "SELECT * FROM users WHERE username = :username";
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(':username', $username, PDO::PARAM_STR);
			$stmt->execute();

			$result = $stmt->fetchAll();
			$user = $result[0];

			if (password_verify($password, $user["password"])) {
                $customerId = $customerDAO->getCustomerIdByUserId($user['id']);
                
                $data['message'] = "Du hast dich erfolgreich angemeldet.";
				$data['user'] = new User($user['id'], $user['username'], $user['role'], $customerId);
				return $data;
            } else {
				$data['message'] = "Dein Benutzername oder dein Passwort ist falsch. Versuche es erneut.";
                return $data;
            }
		} catch (Exception $e) {
			LoggerHelper::addLogToDB(LoggingSeverity::Warning, $e->getMessage());
			$data['error'] = $e->getMessage();
			$data['error_message'] = "Internal Server Error";
			return $data;
		}
    }

}
