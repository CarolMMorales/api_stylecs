<?php

class CategoryController{
    private $_method; //get, post, put.
    private $_complement; //get category 1 o 2.
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
                        $category = CategoryModel::all(0);
                        $json = $category;
                        echo json_encode($json);
                        return;
                    default:
                        $category = CategoryModel::find($this->_complement);
                        if ($category==null)
                            $json = array(
                                "response: "=>"Category not found"
                            );
                        else
                            $json = $category;
                        echo json_encode($json);
                        return;
                }
            case "POST":
                $createcategory = CategoryModel::create($this->_data);
                $json = array(
                    "response: "=>$createcategory
                );
                echo json_encode($json,true);
                return;
            case "PUT":
                $createcategory = CategoryModel::update($this->_complement,$this->_data);
                $json = array(
                    "response: "=>$createcategory
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