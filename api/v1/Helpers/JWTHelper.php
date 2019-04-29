<?php

    require 'vendor/autoload.php';
    use \Firebase\JWT\JWT;

    class JWTHelper {
        // Dont worry, in production, there's another secret key :)
        private $secret = "PEo9zwRUd1H75WhiJI2HurrjthtesWW85t";
        private $expiration_time = 36000;
        private $alg = 'HS256';

        public function __construct() {

        }

        public function generateJWT($user) {
            $issuedAt = time();
            $exp = $issuedAt + $this->expiration_time;
            $payload = array(
                'user' => $user,
                'iat' => $issuedAt,
                'exp' => $exp
            );

            return JWT::encode($payload, $this->secret, $this->alg);
        }

        public function verifyJWT($jwt) {
            try {
                $decoded = JWT::decode($jwt, $this->secret, array('HS256'));
                return true;
            } catch(Exception $e) {
                return false;
            }
        }

        public function decodeJWT($jwt) {
            try {
                return JWT::decode($jwt, $this->secret, array('HS256'));
            } catch(Exception $e) {
                return false;
            }
        }
    }
?>
