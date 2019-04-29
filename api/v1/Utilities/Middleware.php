<?php
    class Middleware {
        private $jwtHelper;

        public function __construct() {
            $this->jwtHelper = new JWTHelper();
        }

        public function checkAuth() {
            $request = array();    
            $jwt = $this->getBearerToken();

            if ($this->jwtHelper->verifyJWT($jwt)) {
                $request['inputs'] = (array) json_decode(file_get_contents("php://input")); 
                $request['user'] = $this->jwtHelper->decodeJWT($jwt)->user;
                
                return $request;
            }

            ResponseHandler::sendResponse(401, null, 'Token ungültig. Bitte melde dich zuerst an!', '');
        }
        
        public function checkPrivilegies($user, $minimumRole) {
            if ($user->role >= $minimumRole) {
                return true;
            }

            ResponseHandler::sendResponse(401, null, 'Sie haben keine Berechtigung diese Resource anzufragen.', '');
        }

        private function getAuthorizationHeader(){
            $headers = null;
       
            if (isset($_SERVER['Authorization'])) {
                $headers = trim($_SERVER["Authorization"]);
            } else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
                $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
            } elseif (function_exists('apache_request_headers')) {
                $requestHeaders = apache_request_headers();
                // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
                $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
                
                if (isset($requestHeaders['Authorization'])) {
                    $headers = trim($requestHeaders['Authorization']);
                }
            }
            return $headers;
        }

        private function getBearerToken() {
            $headers = $this->getAuthorizationHeader();
            
            if (!empty($headers)) {
                if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                    return $matches[1];
                }
            }
            
            return null;
        }
    }
?>
