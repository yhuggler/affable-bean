<?php
	class LoggerHelper {
		
		public static function addLogToDB($severityLevel, $message) {
			$dbConn = new DBConnection();
			$conn = $dbConn->conn;

			$ipAddress = $_SERVER["REMOTE_ADDR"];
			$client = $_SERVER["HTTP_USER_AGENT"];
			$timestamp = time();

			$sql = "INSERT INTO logs (severity_level, ip_address, client, message, timestamp) VALUES(:severity_level, :ip_address, :client, :message, :timestamp)";
			$stmt = $conn->prepare($sql);
			$stmt->bindParam(':severity_level', $severityLevel, PDO::PARAM_STR);
			$stmt->bindParam(':ip_address', $ipAddress, PDO::PARAM_STR);
			$stmt->bindParam(':client', $client, PDO::PARAM_STR);
			$stmt->bindParam(':message', $message, PDO::PARAM_STR);	
			$stmt->bindParam(':timestamp', $timestamp, PDO::PARAM_INT);

			return $stmt->execute();
		}
	}
?>
