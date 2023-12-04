<?php

class SaleController{
    private $_method; //get, post, put.
    private $_complement; //get sale 1 o 2.
    private $_data; // datos a insertar o actualizar

    function __construct($method,$complement,$data){
        $this->_method = $method;
        $this->_complement = $complement;
        $this->_data = $data !=0 ? $data : "";
    }

    public function index(){
        switch($this->_method){
            case "GET":
                switch($this->_complement){
                    case 0:
                        $sale = SaleModel::all(0);
                        $json = $sale;
                        echo json_encode($json);
                        return;
                    default:
                        $sale = SaleModel::find($this->_complement);
                        if ($sale==null)
                            $json = array("response: "=>"Sale not found");
                        else
                            $json = $sale;
                        echo json_encode($json);
                        return;
                }
            case "POST":
                $createsale = SaleModel::create($this->_data);
                $json = array(
                    "response: "=>$createsale
                );
                echo json_encode($json,true);
                return;
            case "PUT":
                $createsale = SaleModel::update($this->_data);
                $json = array(
                    "response: "=>$createsale
                );
                echo json_encode($json,true);
                return;
            default:
                $json = array(
                    "ruta: "=>"not found"
                );
                echo json_encode($json,true);
                return;
        }
    }
}
?>