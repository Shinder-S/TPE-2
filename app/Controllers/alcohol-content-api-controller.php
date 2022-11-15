<?php
require_once './app/Models/alcohol-content-model.php';
require_once './app/Views/apiView.php';
require_once './app/Helpers/auth-api-helper.php';

class AlcoholContentApiController {
    private $model;
    private $view;
    private $authHelper;
    private $data;

    public function __construct() {
        $this->model = new AlcoholContentModel();
        $this->view = new ApiView();
        $this->authHelper = new AuthApiHelper();
        $this->data = file_get_contents("php://input");
    }

    private function getData() {
        return json_decode($this->data);
    }

    function getAlcoholContents($params = null) {
        $arrayDrink = ["id_alcohol_content", "name", "brand", "id_drink"];
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
            $alcohol_content = $this->model->getAll($column, $value, $orderBy, $cond, $limit, $offset);
            $this->view->response($alcohol_content);
        }
 
    }

    function getAlcoholContent($params = null) {
        // Obtains id array of params
        $id = $params[':ID'];
        $alcohol_content = $this->model->get($id);

        // si no existe devuelvo 404
        if ($alcohol_content)
            $this->view->response($alcohol_content);
        else 
            $this->view->response("Alcohol content doesn't match with id = $id no existe", 404);
    }

    public function deleteSubclass($params = null) {
        $id = $params[':ID'];

        if(!$this->authHelper->loggedIn()){
            $this->view->response("Not logged in", 401);
            return;
        }

        $alcohol_content = $this->model->get($id);
        if ($alcohol_content) {
            $this->model->delete($id);
            $this->view->response($alcohol_content);
        } else 
            $this->view->response("Alcohol content with id = $id doesn't exist", 404);
    }

    public function insertAlcoholContent($params = null) {
        $alcohol_content = $this->getData();

        if(!$this->authHelper->loggedIn()){
            $this->view->response("No estas logeado", 401);
            return;
        }

        if (empty($alcohol_content->name) || empty($alcohol_content->brand) || empty($alcohol_content->id_drink)) {
            $this->view->response("Complete data", 400);
        } else {
            $id = $this->model->insert($alcohol_content->name, $alcohol_content->brand, $alcohol_content->id_drink);
            $alcohol_content = $this->model->get($id);
            $this->view->response($alcohol_content, 201);
        }
    }

    public function editAlcoholContent($params = null) {
        $id = $params[':ID'];

        if(!$this->authHelper->loggedIn()){
            $this->view->response("No estas logeado", 401);
            return;
        }

        $alcohol_content = $this->model->get($id);
        if ($alcohol_content) {
            $newAC = $this->getData();
            if (empty($alcohol_content->name) || empty($alcohol_content->brand) || empty($alcohol_content->id_drink)) {
                $this->view->response("Complete data", 400);
            } else {
                //ver si existe forma de devolver el id de un update, sin tener q volver a llamar denuevo a get(id)
                $this->model->edit($newAC->name, $newAC->brand, $newAC->id_drink, $id);
                $alcohol_content = $this->model->get($id);
                $this->view->response($alcohol_content, 201);
            }
        }
    }

}