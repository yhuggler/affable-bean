<?php
    class CategoryDAO {
        private $conn;
        private $middleware;

        public function __construct() {
            $dbConn = new DBConnection();
            $this->conn = $dbConn->conn;
        }

        public function getCategories() {
            try {
                $response = array();
                $response['data']['categories'] = array();

                $sql = "SELECT * FROM categories";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();

                $categoryResults = $stmt->fetchAll();

                foreach ($categoryResults as $row) {
                    $category = new Category($row['id'], $row['category_name']);
                    array_push($response['data']['categories'], $category);
                }

                return $response;
            } catch (Exception $e) {
                LoggerHelper::addLogToDB(LoggingSeverity::Warning, $e->getMessage());
                $response['error'] = $e->getMessage();
                $response['error_message'] = "Internal Server Error";
                return $response;
            }
        }

        public function createCategory($category) {
            try {
                $response = array();

                $category = (array) $category;

                if (Validator::checkArrayForEmptyInput($category)) {
                    $response['error_message'] = Validator::checkArrayForEmptyInputs($category);
                    $response['error'] = "bad_request";
                }

                $sql = "INSERT INTO categories(category_name) VALUES(:category_name)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':category_name', $category['categoryName'], PDO::PARAM_STR);
                $stmt->execute();

                $response['message'] = "The category was created successfully.";
                return $response;
            } catch (Exception $e) {
                LoggerHelper::addLogToDB(LoggingSeverity::Warning, $e->getMessage());
                $response['error'] = $e->getMessage();
                $response['error_message'] = "Internal Server Error";
                return $response;
            }
        }

        public function updateCategory($category) {
            try {
                $response = array();
                
                $category = (array) $category;

                if (Validator::checkArrayForEmptyInput((array) $category)) {
                    $response['error_message'] = Validator::checkArrayForEmptyInputs((array) $category);
                    $response['error'] = "bad_request";
                }

                $sql = "UPDATE categories SET category_name = :category_name WHERE id = :id";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':id', $category['id'], PDO::PARAM_INT);
                $stmt->bindParam(':category_name', $category['categoryName'], PDO::PARAM_STR);
                $stmt->execute();

                $response['message'] = "The category was updated successfully.";
                return $response;
            } catch (Exception $e) {
                LoggerHelper::addLogToDB(LoggingSeverity::Warning, $e->getMessage());
                $response['error'] = $e->getMessage();
                $response['error_message'] = "Internal Server Error";
                return $response;
            }
        }

        public function deleteCategory($categoryId) {
            try {
                $response = array();

                $sql = "DELETE FROM categories WHERE id = :id";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':id', $categoryId, PDO::PARAM_INT);
                $stmt->execute();

                $response['message'] = "The category was deleted successfully.";
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
