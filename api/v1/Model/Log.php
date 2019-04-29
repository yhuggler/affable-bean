<?php
	class Log {
		public $id;
		public $severityLevel;
		public $ipAddress;
		public $client;
		public $message;
		public $timestamp;

		public function __construct($id, $severityLevel, $ipAddress, $client, $message, $timestamp) {
			$this->id = $id;
			$this->severityLevel = $severityLevel;
			$this->ipAddress = $ipAddress;
			$this->client = $client;
			$this->message = $message;
			$this->timestamp = $timestamp;
		}
	}
?>
