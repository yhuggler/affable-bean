<?php
	class LoggingController {
		private $middleware;
		private $request;
		private $user;
		private $loggingDAO;

		public function __construct() {
			$this->middleware = new Middleware();
			$this->request = $this->middleware->runWithAdminPrivileges();
			$this->user = $this->request['user']['user'];
			$this->loggingDAO = new LoggingDAO();
		}

		public function getLogs() {
			$result = $this->loggingDAO->getLogs();
			ResponseHandler::sendResponseWithData($this->user, $result);
		}

		public function clearLogs() {
			$result = $this->loggingDAO->clearLogs();
			ResponseHandler::sendResponseWithMessage($this->user, $result);
		}
	}
?>