<?php
    class CategoryController {
        private $categoryDAO;
        private $middleware;

        public function __construct() {
            $this->categoryDAO = new CategoryDAO();
            $this->middleware = new Middleware();
        }

        public function getCategories() {
            $result = $this->categoryDAO->getCategories();
            ResponseHandler::sendResponseWithData("",  $result);
        }

        public function createCategory() {
            $request = $this->middleware->checkAuth();
            $this->middleware->checkPrivilegies($request['user'], 2);

            $category = new Category(-1, $request['inputs']['categoryName']);

            $result = $this->categoryDAO->createCategory($category); 
            ResponseHandler::sendResponseWithMessage("",  $result);
        }

        public function updateCategory() {
            $request = $this->middleware->checkAuth();
            $this->middleware->checkPrivilegies($request['user'], 2);

            $category = new Category($request['inputs']['id'], $request['inputs']['categoryName']);

            $result = $this->categoryDAO->updateCategory($category); 
            ResponseHandler::sendResponseWithMessage("",  $result);

        }

        public function deleteCategory() {
            $request = $this->middleware->checkAuth();
            $this->middleware->checkPrivilegies($request['user'], 2);

            $result = $this->categoryDAO->deleteCategory($request['inputs']['id']); 
            ResponseHandler::sendResponseWithMessage("",  $result);

        }
    }
?>
