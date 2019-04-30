<?php
    class ProductController {
        private $productDAO;
        private $middleware;

        public function __construct() {
            $this->productDAO = new ProductDAO();
            $this->middleware = new Middleware();
        }

        public function getProducts() {
            $result = $this->productDAO->getProducts();
            ResponseHandler::sendResponseWithData("", $result);
        }
        
        public function createProduct() {
            $request = $this->middleware->checkAuth();
            $this->middleware->checkPrivilegies($request['user'], 2);

            $product = new Product(-1, $request['inputs']['name'], $request['inputs']['price'], $request['inputs']['description'], -1, $request['inputs']['categoryId']);

            $result = $this->productDAO->createProduct($product); 
            ResponseHandler::sendResponseWithMessage("",  $result);
        }

        public function updateProduct() {
            $request = $this->middleware->checkAuth();
            $this->middleware->checkPrivilegies($request['user'], 2);

            $product = new Product($request['inputs']['id'], $request['inputs']['name'], $request['inputs']['price'], $request['inputs']['description'], -1, $request['inputs']['categoryId']);

            $result = $this->productDAO->updateProduct($product); 
            ResponseHandler::sendResponseWithMessage("",  $result);
        }

        public function deleteProduct() {
            $request = $this->middleware->checkAuth();
            $this->middleware->checkPrivilegies($request['user'], 2);

            $result = $this->productDAO->deleteProduct($request['inputs']['id']); 
            ResponseHandler::sendResponseWithMessage("",  $result);
        }
    }
?>

