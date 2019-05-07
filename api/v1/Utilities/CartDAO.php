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
                
                $sql = "SELECT cart_items.id, product_id, quantity, price, description, name, last_update, category_id FROM cart_items INNER JOIN products ON cart_items.product_id = products.id WHERE user_id = :user_id";
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
                    $description = $row['description'];
                    $lastUpdate = $row['last_update'];
                    $name = $row['name'];
                    $categoryId = $row['category_id'];

                    $totalPrice += $price * $quantity;
                    $product = new Product($productId, $name, $price, $description, $lastUpdate, $categoryId);

                    $shoppingCartItem = new ShoppingCartItem($id, $userId, $product, $quantity);
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

                if ($this->isAlreadyInCart($userId, $productId)) {
                    $cartItem = $this->getCartItemByProductId($userId, $productId);  
                    $quantity = $cartItem['quantity'] + 1;
                    $itemId = $cartItem['id'];

                    $this->updateQuantity($itemId, $quantity); 
                    
                    $response['message'] = "Added to cart";
                    return $response;
                }        

                $sql = "INSERT INTO cart_items(user_id, product_id) VALUES(:user_id, :product_id)";
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

        private function isAlreadyInCart($userId, $productId) {
            try {
                $sql = "SELECT * FROM cart_items WHERE product_id = :product_id AND user_id = :user_id";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
                $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
                $stmt->execute();

                $cartResults = $stmt->fetchAll();
                
                return !empty($cartResults);
            } catch (Exception $e) {
                LoggerHelper::addLogToDB(LoggingSeverity::Warning, $e->getMessage());
                $response['error'] = $e->getMessage();
                $response['error_message'] = "Internal Server Error";
                return $response;
            }
        }

        private function getCartItemByProductId($userId, $productId) {
            try {
                $sql = "SELECT * FROM cart_items WHERE product_id = :product_id AND user_id = :user_id";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
                $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
                $stmt->execute();

                $cartResults = $stmt->fetchAll();

                return $cartResults[0];
            } catch (Exception $e) {
                LoggerHelper::addLogToDB(LoggingSeverity::Warning, $e->getMessage());
                $response['error'] = $e->getMessage();
                $response['error_message'] = "Internal Server Error";
                return $response;
            }
        }

        public function updateQuantity($itemId, $quantity) {
            try {
                $response = array();

                if ($itemId == 0 || $itemId == null) {
                    $response['error_message'] = "Please provide a valid item id.";
                    $response['error'] = "bad_request";
                    return $response;
                }

                if ($quantity <= 0) {
                    return $this->deleteItem($itemId);
                }

                $sql = "UPDATE cart_items SET quantity = :quantity WHERE id = :item_id";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
                $stmt->bindParam(':item_id', $itemId, PDO::PARAM_INT);
                $stmt->execute();

                $response['message'] = "Updadet quantity";
                return $response;
            } catch (Exception $e) {
                LoggerHelper::addLogToDB(LoggingSeverity::Warning, $e->getMessage());
                $response['error'] = $e->getMessage();
                $response['error_message'] = "Internal Server Error";
                return $response;
            }
        } 

        public function deleteItem($itemId) {
            try {
                $response = array();
                
                if ($itemId == 0 || $itemId == null) {
                    $response['error_message'] = "Please provide a valid item id.";
                    $response['error'] = "bad_request";
                    return $response;
                }

                $sql = "DELETE FROM cart_items WHERE id = :item_id";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':item_id', $itemId, PDO::PARAM_INT);
                $stmt->execute();

                $response['message'] = "Removed item from the cart";
                return $response;
            } catch (Exception $e) {
                LoggerHelper::addLogToDB(LoggingSeverity::Warning, $e->getMessage());
                $response['error'] = $e->getMessage();
                $response['error_message'] = "Internal Server Error";
                return $response;
            }
        }

        public function clearCart($userId) {
            try {
                $response = array();
                
                if ($userId == 0 || $userId == null) {
                    $response['error_message'] = "Please provide a valid user id.";
                    $response['error'] = "bad_request";
                    return $response;
                }

                $sql = "DELETE FROM cart_items WHERE user_id = :user_id";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
                $stmt->execute();

                $response['message'] = "Cleared the cart";
                return $response;
            } catch (Exception $e) {
                LoggerHelper::addLogToDB(LoggingSeverity::Warning, $e->getMessage());
                $response['error'] = $e->getMessage();
                $response['error_message'] = "Internal Server Error";
                return $response;
            }
        }
    }
?>
