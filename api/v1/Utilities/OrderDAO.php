<?php
    class OrderDAO {
        private $conn;
        private $middleware;

        public function __construct() {
            $dbConn = new DBConnection();
            $this->conn = $dbConn->conn;
        }

        public function getOrders() {
            try {
                $response = array();
                $response['data']['orders'] = array();

                $sql = "SELECT * FROM customer_orders";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();

                $ordersResults = $stmt->fetchAll();

                foreach ($ordersResults as $row) {
                    $order = new Order($row['id'], $row['amount'], $row['date_created'], $row['confirmation_number'], $row['user_id'], $row['promo_code']);
                    array_push($response['data']['orders'], $order);
                }

                return $response;
            } catch (Exception $e) {
                LoggerHelper::addLogToDB(LoggingSeverity::Warning, $e->getMessage());
                $response['error'] = $e->getMessage();
                $response['error_message'] = "Internal Server Error";
                return $response;
            }
        }

        public function getOrdersByUserId($userId) {

        }

        public function createOrder($userId) {
            try {
                $response = array();
                
                $cartDAO = new CartDAO();
                $shoppingCart = $cartDAO->getCart($userId)['data']['shoppingCart'];

                if (sizeof($shoppingCart->shoppingCartItems) == 0) {
                    $response['error_message'] = "There are no items in your cart. Please add at least one item, in order to place an order.";
                    $response['error'] = "bad_request";
                    return $response;
                }

                $confirmationNumber = $this->getOrderConfirmationNumber();
                $totalCost = explode('$', $shoppingCart->totalCost)[1];

                // Store order in database
                $sql = "INSERT INTO customer_orders(amount, confirmation_number, user_id, promo_code) VALUES(:amount, :confirmation_number, :user_id, :promo_code)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':amount', $totalCost, PDO::PARAM_STR);
                $stmt->bindParam(':confirmation_number', $confirmationNumber, PDO::PARAM_INT);
                $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
                $stmt->bindParam(':promo_code', $promoCode, PDO::PARAM_STR);
                $stmt->execute();

                $orderId = $this->conn->lastInsertId();

                // Insert ordered products
                foreach ($shoppingCart->shoppingCartItems as $shoppingCartItem) {
                    $sql = "INSERT INTO ordered_products(product_id, order_id, quantity) VALUES(:product_id, :order_id, :quantity)";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bindParam(':product_id', $shoppingCartItem->product->id, PDO::PARAM_INT);
                    $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
                    $stmt->bindParam(':quantity', $shoppingCartItem->quantity, PDO::PARAM_INT);
                    $stmt->execute();
                }

                $cartDAO->clearCart($userId);

                $response['message'] = "Successfully placed your order.";
                return $response;
            } catch (Exception $e) {
                LoggerHelper::addLogToDB(LoggingSeverity::Warning, $e->getMessage());
                $response['error'] = $e->getMessage();
                $response['error_message'] = "Internal Server Error";
                return $response;
            }
        }

        private function getOrderConfirmationNumber() {
            try {
                $confirmationNumber = 0;
                $hasDuplicate = false;

                $sql = "SELECT * FROM customer_orders WHERE confirmation_number = :confirmation_number";

                do {
                    $confirmationNumber = rand(11111111, 99999999);
            
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bindParam(':confirmation_number', $confirmationNumber, PDO::PARAM_INT);
                    $stmt->execute();

                    $results = $stmt->fetchAll();

                    $hasDuplicate = !empty($results);
                } while ($hasDuplicate);

                return $confirmationNumber;
            } catch (Exception $e) {
                LoggerHelper::addLogToDB(LoggingSeverity::Warning, $e->getMessage());
                $response['error'] = $e->getMessage();
                $response['error_message'] = "Internal Server Error";
                return $response;
            }
        }

        public function deleteOrder($orderId) {

        }
    }

?>

