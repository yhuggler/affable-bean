<?php
    class ProductDAO {
        private $conn;
        private $middleware;

        public function __construct() {
            $dbConn = new DBConnection();
            $this->conn = $dbConn->conn;
        }

        public function getProducts() {
            try {
                $response = array();

                $sql = "SELECT * FROM products";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();

                $productResults = $stmt->fetchAll();

                foreach ($productResults as $row) {
                    if (!isset($response['data']['categories'][$row['category_id']])) {
                        $response['data']['categories'][$row['category_id']] = array();
                    }

                    $product = new Product($row['id'], $row['name'], $row['price'], $row['description'], $row['last_update'], $row['category_id']);
                    array_push($response['data']['categories'][$row['category_id']], $product);
                }

                return $response;
            } catch (Exception $e) {
                LoggerHelper::addLogToDB(LoggingSeverity::Warning, $e->getMessage());
                $response['error'] = $e->getMessage();
                $response['error_message'] = "Internal Server Error";
                return $response;
            }
        }
        
        public function createProduct($product) {
            try {
                $response = array();

                $product = (array) $product;

                if (Validator::checkArrayForEmptyInput($product)) {
                    $response['error_message'] = Validator::checkArrayForEmptyInputs($product);
                    $response['error'] = "bad_request";
                }

                $sql = "INSERT INTO products(name, price, description, category_id) VALUES(:name, :price, :description, :category_id)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':name', $product['name'], PDO::PARAM_STR);
                $stmt->bindParam(':price', $product['price'], PDO::PARAM_STR);
                $stmt->bindParam(':description', $product['description'], PDO::PARAM_STR);
                $stmt->bindParam(':category_id', $product['categoryId'], PDO::PARAM_INT);
                $stmt->execute();

                $response['message'] = "The product was created successfully.";
                return $response;
            } catch (Exception $e) {
                LoggerHelper::addLogToDB(LoggingSeverity::Warning, $e->getMessage());
                $response['error'] = $e->getMessage();
                $response['error_message'] = "Internal Server Error";
                return $response;
            }
        }

        public function updateProduct($product) {
            try {
                $response = array();

                $product = (array) $product;

                if (Validator::checkArrayForEmptyInput($product)) {
                    $response['error_message'] = Validator::checkArrayForEmptyInputs($product);
                    $response['error'] = "bad_request";
                }

                $sql = "UPDATE products SET name = :name, price = :price, description = :description, category_id = :category_id WHERE id = :id";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':id', $product['id'], PDO::PARAM_INT);
                $stmt->bindParam(':name', $product['name'], PDO::PARAM_STR);
                $stmt->bindParam(':price', $product['price'], PDO::PARAM_STR);
                $stmt->bindParam(':description', $product['description'], PDO::PARAM_STR);
                $stmt->bindParam(':category_id', $product['categoryId'], PDO::PARAM_INT);
                $stmt->execute();

                $response['message'] = "The product was updated successfully.";
                return $response;
            } catch (Exception $e) {
                LoggerHelper::addLogToDB(LoggingSeverity::Warning, $e->getMessage());
                $response['error'] = $e->getMessage();
                $response['error_message'] = "Internal Server Error";
                return $response;
            }

        }

        public function deleteProduct($productId) {
            try {
                $response = array();

                $product = (array) $product;

                if (Validator::checkArrayForEmptyInput($product)) {
                    $response['error_message'] = Validator::checkArrayForEmptyInputs($product);
                    $response['error'] = "bad_request";
                }

                $sql = "DELETE FROM products WHERE id = :id";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':id', $productId, PDO::PARAM_INT);
                $stmt->execute();

                $response['message'] = "The product was deleted successfully.";
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

