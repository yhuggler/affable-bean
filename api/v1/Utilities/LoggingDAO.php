<?php
	class LoggingDAO {
		private $conn;

		public function __construct() {
			$dbConnection = new DBConnection();
			$this->conn = $dbConnection->conn;
		}

		public function getLogs() {
			try {
				$data = array();
				$data['data']['logs'] = array();

				$sql = "SELECT * FROM logs";
				$stmt = $this->conn->prepare($sql);
				$stmt->execute();

				foreach ($stmt as $row) {
					$log = new Log($row["id"], $row["severity_level"], $row["ip_address"], $row["client"], $row["message"], $row["timestamp"]);
					array_push($data['data']['logs'], $log);
				}

				return $data;
			} catch (Exception $e) {
				LoggerHelper::addLogToDB(LoggingSeverity::Warning, $e->getMessage());
                $data['error'] = $e->getMessage();
                $data['error_message'] = "Internal Server Error";
                return $data;
			}
		}

		public function clearLogs() {
			try {
				$data = array();

				$sql = "TRUNCATE TABLE logs";
				$stmt = $this->conn->prepare($sql);
				$stmt->execute();

				$data['message'] = "The logs have been successfully cleared.";
				return $data;
			} catch (Exception $e) {
				LoggerHelper::addLogToDB(LoggingSeverity::Warning, $e->getMessage());
                $data['error'] = $e->getMessage();
                $data['error_message'] = "Internal Server Error";
                return $data;	
			}
		}
	}
?>