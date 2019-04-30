<?php
    class CartDAO {
        private $conn;
        
        public function __construct() {
            $dbConn = new DBConnection();
            $this->conn = $dbConn->conn;
        }

        public function getCart($userId) {
            try {
                $response = array();
                
                $sql = "SELECT cart.id, product_id, quantity, price FROM cart INNER JOIN products ON cart.product_id = products.id WHERE user_id = :user_id";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
                $stmt->execute();

                $cartResults = $stmt->fetchAll();

                $shoppingCartItems = array();
                $totalPrice = 0;

                foreach ($cartResults as $row) {
                    $id = $row['id'];
                    $productId = $row['product_id'];
                    $quantity = $row['quantity'];
                    $price = $row['price'];

                    $totalPrice += $price;

                    $shoppingCartItem = new ShoppingCartItem($id, $userId, $productId, $quantity);
                    array_push($shoppingCartItems, $shoppingCartItem); 
                }
                
                setlocale(LC_MONETARY,"en_US");

                $response['data']['shoppingCart'] = new ShoppingCart($shoppingCartItems, money_format("%n", $totalPrice));
                return $response;
            } catch (Exception $e) {
                LoggerHelper::addLogToDB(LoggingSeverity::Warning, $e->getMessage());
                $response['error'] = $e->getMessage();
                $response['error_message'] = "Internal Server Error";
                return $response;
            }
        }

        public function addToCart($userId, $productId) {
            try {
                $response = array();

                if ($productId == 0 || $productId == null) {
                    $response['error_message'] = "Please provide a valid product id.";
                    $response['error'] = "bad_request";
                    return $response;
                }
                
                // First check, if item is already in cart. If yes, simply increment quantity.

                $sql = "INSERT INTO cart(user_id, product_id) VALUES(:user_id, :product_id)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
                $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
                $stmt->execute();

                $response['message'] = "Added to cart";
                return $response;
            } catch (Exception $e) {
                LoggerHelper::addLogToDB(LoggingSeverity::Warning, $e->getMessage());
                $response['error'] = $e->getMessage();
                $response['error_message'] = "Internal Server Error";
                return $response;
            }
        }

        public function updateQuantity($userId, $productId, $quantity) {
            try {
                $response = array();

                if ($productId == 0 || $productId == null) {
                    $response['error_message'] = "Please provide a valid product id.";
                    $response['error'] = "bad_request";
                    return $response;
                }

                $sql = "INSERT INTO cart(user_id, product_id) VALUES(:user_id, :product_id)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
                $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
                $stmt->execute();

                $response['message'] = "Added to cart";
                return $response;
                
            } catch (Exception $e) {
                LoggerHelper::addLogToDB(LoggingSeverity::Warning, $e->getMessage());
                $response['error'] = $e->getMessage();
                $response['error_message'] = "Internal Server Error";
                return $response;
            }
        } 

        public function deleteItem($userId, $itemId) {
            try {

            } catch (Exception $e) {
                LoggerHelper::addLogToDB(LoggingSeverity::Warning, $e->getMessage());
                $response['error'] = $e->getMessage();
                $response['error_message'] = "Internal Server Error";
                return $response;
            }
        }
    }
?>
