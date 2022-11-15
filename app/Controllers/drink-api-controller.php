<?php
require_once './app/Models/drink-model.php';
require_once './app/Views/apiView.php';
require_once './app/Helpers/auth-api-helper.php';

class DrinkApiController {
    private $model;
    private $view;
    private $authHelper;
    private $data;

    function __construct() {
        $this->model = new DrinkModel();
        $this->view = new ApiView();
        $this->authHelper = new AuthApiHelper();
        $this->data = file_get_contents("php://input");
    }

    private function getData() {
        return json_decode($this->data);
    }

    function getDrinks($params = null) {
        $arrayDrink = ["id_drink", "name", "brand", "amount"];
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
            $drinks = $this->model->getAll($column, $value, $orderBy, $cond, $limit, $offset);
            $this->view->response($drinks);
        }
    }

    function getDrink($params = null) {
        $id = $params[':ID'];
        $drink = $this->model->get($id);

        if ($drink)
            $this->view->response($drink);
        else 
            $this->view->response("The Class with id=$id does not exist", 404);
    }

    function deleteDrink($params = null) {
        $id = $params[':ID'];

        if(!$this->authHelper->loggedIn()){
            $this->view->response("No estas logeado", 401);
            return;
        }

        $drink = $this->model->get($id);
        if ($drink) {
            $this->model->delete($id);
            $this->view->response($drink);
        } else 
            $this->view->response("The Class with id=$id does not exist", 404);
    }

    function insertDrink($params = null) {
        $drink = $this->getData();

        if(!$this->authHelper->loggedIn()){
            $this->view->response("Not logged", 401);
            return;
        }

        if (empty($drink->name) || empty($drink->brand) || empty($drink->amount)) {
            $this->view->response("Complete the fields and try again", 400);
        } else {
            $id = $this->model->insert($drink->name, $drink->brand, $drink->amount);
            $drink = $this->model->get($id);
            $this->view->response($drink, 201);
        }
    }

    function editDrink($params = null) {
        $id = $params[':ID'];

        if(!$this->authHelper->loggedIn()){
            $this->view->response("Not logged in", 401);
            return;
        }

        $drink = $this->model->get($id);
        if ($drink) {
            $newDrink = $this->getData();
            if (empty($drink->name) || empty($drink->brand) || empty($drink->amount)) {
                $this->view->response("Complete the fields and try again", 400);
            } else {
                //ver si existe forma de devolver el id de un update, sin tener q volver a llamar denuevo a get(id)
                $this->model->edit($newDrink->name, $newDrink->brand, $newDrink->amoutn, $id);
                $drink = $this->model->get($id);
                $this->view->response($drink, 201);
            }
        }
    }

}