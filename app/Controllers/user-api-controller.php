<?php

require_once './app/Models/user-model.php';
require_once './app/Views/apiView.php';
require_once './app/Helpers/auth-api-helper.php';

function base64url_encode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

class AuthApiController {
    private $model;
    private $view;
    private $authHelper;
    private $key;
    private $data;

    function __construct() {
        $this->model = new UserModel();
        $this->view = new ApiView();
        $this->authHelper = new AuthApiHelper();
        $this->key = "on-the-rocks";
        // read body request
        $this->data = file_get_contents("php://input");
    }

    private function getData() {
        return json_decode($this->data);
    }

    function getToken($params = null) {
        // Obtains "Basic base64(user:pass)
        $basic = $this->authHelper->getAuthHeader();
        
        if(empty($basic)){
            $this->view->response('Not authorized', 401);
            return;
        }
        $basic = explode(" ",$basic); // ["Basic" "base64(user:pass)"]
        if($basic[0]!="Basic"){
            $this->view->response('Authentication must be Basic', 401);
            return;
        }

        //validate user: password
        $userPassword = base64_decode($basic[1]); // user:password
        $userPassword = explode(":", $userPassword);
        $userName = $userPassword[0];
        $pass = $userPassword[1];
        $user = $this->model->getUser($userName);
        //Check if it exists
        if($user && password_verify($pass, $user->password)){
            //  create a token
            $header = array(
                'alg' => 'HS256',
                'typ' => 'JWT'
            );
            $payload = array(
                'id' => 1,
                'name' => $user,
                'exp' => time()+3600
            );
            $header = base64url_encode(json_encode($header));
            $payload = base64url_encode(json_encode($payload));
            $signature = hash_hmac('SHA256', "$header.$payload", $this->key, true);
            $signature = base64url_encode($signature);
            $token = "$header.$payload.$signature";
             $this->view->response($token);
        }else{
            $this->view->response("Doesn't match user and password", 401);
        }
    }
}