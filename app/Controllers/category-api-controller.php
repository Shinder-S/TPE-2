<?php
require_once './app/Models/category-model.php';
require_once './app/Views/apiView.php';
require_once './app/Helpers/auth-api-helper.php';

class CategoryApiController {
    private $model;
    private $view;
    private $authHelper;
    private $data;

    public function __construct() {
        $this->model = new CategoryModel();
        $this->view = new ApiView();
        $this->authHelper = new AuthApiHelper();
        $this->data = file_get_contents("php://input");
    }

    private function getData() {
        return json_decode($this->data);
    }

    public function getCategories($params = null) {
        $arrayDrink = ["id_category", "name", "amount", "id_subclass", "photo"];
        $quant = $this->model->getQuantRegisters();

        if(isset($_GET['filter'])&&!empty($_GET['filter'])&&
        isset($_GET['value'])){
            if(in_array($_GET['filter'], $arrayDrink)){
                $column = $arrayDrink[array_search($_GET['filter'], $arrayDrink)];
                $value = $_GET['value'];
            }else{
                $this->view->response("Resource not found", 404);
                die();
            }
        }else{
            $column= 1;
            $value = 1;
        }

        if(isset($_GET['orderBy'])&&!empty($_GET['orderBy'])){
            if(in_array($_GET['orderBy'], $arrayDrink)){
                $orderBy = $arrayDrink[array_search($_GET['orderBy'], $arrayDrink)];
            }
            else{
                $this->view->response("Resource not found", 404);
                die();
            }
        }else{
            $orderBy=$arrayDrink[0];
        }

        if((isset($_GET['page']))&&(isset($_GET['limit'])&&!empty($_GET['limit']))){
            if(is_numeric($_GET['page'])&&is_numeric($_GET['limit'])){
                $page = $_GET['page'];
                $limit = $_GET['limit'];
                $offset = $page*$limit;
            }else{
                $this->view->response("Resource not found", 404);
                die();
            }
        }else{
            $offset = 0;
            $limit = $quant;
        }

        if(isset($_GET['cond'])&&!empty($_GET['cond'])){
            if($_GET['cond']==="desc"||$_GET['cond']==="asc"){
                $cond = $arrayDrink[array_search($_GET['cond'], $arrayDrink)];
            }else{
                $this->view->response("Resource not found", 404);
                die();
            }
        }else{
            $cond="asc";
        }

        if($quant<=$offset){
            $this->view->response("You exceed the limit of items", 400);
        }else{
            $categories = $this->model->getAll($column, $value, $orderBy, $cond, $limit, $offset);
            $this->view->response($categories);
        }
    }

    public function getCategory($params = null) {
        $id = $params[':ID'];
        $category = $this->model->get($id);

        if ($category)
            $this->view->response($category);
        else 
            $this->view->response("La subclase con el id=$id no existe", 404);
    }

    public function deleteCategory($params = null) {
        $id = $params[':ID'];

        if(!$this->authHelper->loggedIn()){
            $this->view->response("No estas logeado", 401);
            return;
        }

        $category = $this->model->get($id);
        if ($category) {
            $this->model->delete($id);
            $this->view->response($category);
        } else 
            $this->view->response("Category with id = $id doesn't exist", 404);
    }

    public function insertCategory($params = null) {
        $category = $this->getData();

        if(!$this->authHelper->loggedIn()){
            $this->view->response("Not logged", 401);
            return;
        }

        if (empty($category->name) || empty($category->amount) || empty($category->photo)|| empty($category->id_category)) {
            $this->view->response("Complete los datos", 400);
        } else {
            $id = $this->model->insert($category->name, $category->amount, $category->photo, $category->id_category);
            $category = $this->model->get($id);
            $this->view->response($category, 201);
        }
    }

    public function editCategory($params = null) {
        $id = $params[':ID'];

        if(!$this->authHelper->loggedIn()){
            $this->view->response("Not logged", 401);
            return;
        }

        $category = $this->model->get($id);
        if ($category) {
            $newCategory = $this->getData();
            if (empty($category->name) || empty($category->amount) || empty($category->photo)|| empty($category->id_alcohol_content)) {
                $this->view->response("Complete data", 400);
            } else {
                //ver si existe forma de devolver el id de un update, sin tener q volver a llamar denuevo a get(id)
                $this->model->edit($newCategory->name, $newCategory->amount, $newCategory->photo, $newCategory->id_alcohol_content, $id);
                $category = $this->model->get($id);
                $this->view->response($category, 201);
            }
        }
    }

}