<?php

class ApiView{

    function response($data, $status){
        header('Content-type: application/json');
        header('HTTP/1.1 ' . $status . ' ' . $this->_requestStatus($status));
        
        //Convert data to Json format
        echo json_decode($data);
    }

    private function _requestStatus($code){
        $status = array(
            200 => 'OK',
            404 => 'Not Found',
            500 => 'Internal Server Error'
        );
        if(isset($status[$code]))
            return $status[$code];
        else
            return $status[500];
    }
}