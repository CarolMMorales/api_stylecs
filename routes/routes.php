<?php

//Detecta nuestra url
$rutasArray = explode("/",$_SERVER['REQUEST_URI']);
$inputs = array(); 
//Raw input for requets
$inputs['raw_input'] = @file_get_contents('php://input');
$_POST = json_decode($inputs['raw_input'], true);
if(count(array_filter($rutasArray))<2){
    $json = array(
        "ruta"=>"not found"
    );
    echo json_encode($json,true);
    return;
}else{
    /**
     * EndPoint Correctos
     */
    $endPoint = (array_filter($rutasArray)[2]);
    $complement= (array_key_exists(3,$rutasArray))? ($rutasArray)[3]:0;
    $add = (array_key_exists(4,$rutasArray))? ($rutasArray)[4]:"";
    if($add !="") $complement .= "/".$add;
    $method = $_SERVER['REQUEST_METHOD'];
    //print_r($endPoint);
    switch ($endPoint){
        case 'users':
            if (isset($_POST)){
                $user = new UserController($method, $complement, $_POST);
            }elseif ($method == 'PUT') {
                $user = new UserController($method, $complement, $_POST);
            }else{
                $user = new UserController($method, $complement, 0);
            }
            $user->index();
            break;
        case 'login':
            if(isset($_POST) && $method == 'POST'){
                $user = new LoginController($method, $_POST);
                $user -> index();
            }else{
                $json = array(
                    "ruta"=>"not found"
                );
                echo json_encode($json, true);
                return;
            }
            break;
        case 'categories':
            switch ($method) {
                case 'GET':
                    $category = new CategoryController($method, $complement, 0);
                break;
                case 'POST':
                    $category = new CategoryController($method, $complement, $_POST);
                break;
                case 'PUT':
                    $category = new CategoryController($method, $complement, $_POST);
                break;
                default:
                    $json = array(
                        "ruta"=>"not found"
                    );
                    echo json_encode($json, true);
                    return;
                break;
            }
            $category->index();
        break;
        case 'clothes':
            switch ($method) {
                case 'GET':
                    $clothe = new ClotheController($method, $complement, 0);
                break;
                case 'POST':
                    $clothe = new ClotheController($method, $complement, $_POST);
                break;
                case 'PUT':
                    $clothe = new ClotheController($method, $complement, $_POST);
                break;
                default:
                    $json = array(
                        "ruta"=>"not found"
                    );
                    echo json_encode($json, true);
                    return;
                break;
            }
            $clothe->index();
        break;
        case 'payment_method':
            switch ($method) {
                case 'GET':
                    $paymentMethod = new PaymentMethodController($method, $complement, 0);
                break;
                case 'POST':
                    $paymentMethod = new PaymentMethodController($method, $complement, $_POST);
                break;
                case 'PUT':
                    $paymentMethod = new PaymentMethodController($method, $complement, $_POST);
                break;
                default:
                    $json = array(
                        "ruta"=>"not found"
                    );
                    echo json_encode($json, true);
                    return;
                break;
            }
            $paymentMethod->index();
        break;
        case 'bills':
            switch ($method) {
                case 'GET':
                    $bill = new BillController($method, $complement, 0);
                break;
                case 'POST':
                    $bill = new BillController($method, $complement, $_POST);
                break;
                case 'PUT':
                    $bill = new BillController($method, $complement, $_POST);
                break;
                default:
                    $json = array(
                        "ruta"=>"not found"
                    );
                    echo json_encode($json, true);
                    return;
                break;
            }
            $bill->index();
        break;
        case 'sales':
            switch ($method) {
                case 'GET':
                    $sale = new SaleController($method, $complement, 0);
                break;
                case 'POST':
                    $sale = new SaleController($method, $complement, $_POST);
                break;
                case 'PUT':
                    $sale = new SaleController($method, $complement, $_POST);
                break;
                default:
                    $json = array(
                        "ruta"=>"not found"
                    );
                    echo json_encode($json, true);
                    return;
                break;
            }
            $sale->index();
        break;
        default:
            $json = array(
                "ruta"=>"ruta no encontrada"
            );
            echo json_encode($json,true);
            return;
    }
}


?>