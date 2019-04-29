<?php

	class ResponseHandler {
	
			public static function sendResponse($status, $data, $message, $error) {
				$response = array();
				
				http_response_code($status);

				$data !== null ? ($response["data"] = $data) : null;
				$message !== "" ? ($response["message"] = $message) : null;
				$error !== "" ? ($response["error"] = $error) : null;
			
				echo json_encode($response);
				die();
			}

			public static function sendInvalidJWTResponse() {
				$response = array();

				http_response_code(200);

				$response['message'] = "Your session expired. Please sign in again.";
				$response['error'] = "JWT is invalid";

				echo json_encode($response);
				die();
			}

			public static function sendResponseWith200($jwt, $data, $message, $error) {
	            $response = array();
	            
	            if ($jwt != "") $response['jwt'] = $jwt;
	            if ($message != "") $response['message'] = $message;
	            if ($error != "") $response['error'] = $error;
	            if ($data !== null) $response['data'] = $data;

	            echo json_encode($response);
	            die();
	        }

	        public static function sendResponseWithMessage($user, $result) {
	            $response = array();
	            $jwtHelper = new JWTHelper();

	            if ($user != null) $response['jwt'] = $jwtHelper->generateJWT($user);

	            if (isset($result['error']) || isset($result['error_message'])) {
	                $response['message'] = $result['error_message'];
	                $response['error'] = $result['error'];
	            } else if (isset($result['message'])) {
	                $response['message'] = $result['message'];
	            }

	            echo json_encode($response);
	            die();
	        }

	        public static function sendResponseWithData($user, $result) {
	            $response = array();
	            $jwtHelper = new JWTHelper();

	            if ($user != null) $response['jwt'] = $jwtHelper->generateJWT($user);

	            if (isset($result['error']) || isset($result['error_message'])) {
	                $response['message'] = $result['error_message'];
	                $response['error'] = $result['error'];
	            } else if (isset($result['data'])) {
	                $response['data'] = $result['data'];
	            }

	            if (isset($result['message'])) {
	            	$response['message'] = $result['message'];
	            }
	            echo json_encode($response);
	            die();
	        }


			public static function sendInsufficientPrivilegesResponse() {
				$response = array();

				http_response_code(200);

				$response['message'] = "You're not allowed to access this method.";
				$response['error'] = "Insufficient privileges.";

				echo json_encode($response);
				die();
			}

			public static function sendGeneralErrorResponse() {
				$response = array();

				http_response_code(200);

				$response['message'] = "An error occurred.";
				$response['error'] = "Internal Server Error";

				echo json_encode($response);
				die();
			}
	}
		
?>
