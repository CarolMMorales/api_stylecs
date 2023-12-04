<?php

class BillController{
private $_method; //get, post, put.
    private $_complement; //get bill 1 o 2.
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
                        $bill = BillModel::all(0);
                        $json = $bill;
                        echo json_encode($json);
                        return;
                    default:
                        $bill = BillModel::find($this->_complement);
                        if ($bill==null)
                            $json = array("response: "=>"Bill not found");
                        else
                            $json = $bill;
                        echo json_encode($json);
                        return;
                }
            case "POST":
                $createbill = BillModel::create($this->_data);
                $json = array(
                    "response: "=>$createbill
                );
                echo json_encode($json,true);
                return;
            case "PUT":
                $createbill = BillModel::update($this->_complement,$this->_data);
                $json = array(
                    "response: "=>$createbill
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