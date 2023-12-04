<?php

require_once "ConDB.php";

class SaleModel {
    public static function all(){
        $query = "SELECT sales.*, clothes.clo_name FROM sales INNER JOIN clothes ON sales.clo_id = clothes.clo_id;";
        $statement = Connection::connection()->prepare($query);
        $statement->execute();
        $methods = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $methods;
    }

    public static function find($id){
        $query = "SELECT sales.*, clothes.clo_name FROM sales INNER JOIN clothes ON sales.clo_id = clothes.clo_id WHERE sal_id = $id";
        $statement = Connection::connection()->prepare($query);
        $statement->execute();
        $method = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $method;
    }

    public static function create($data){
        $bill_data = array(
            "bil_total" => 0,
            "use_id" => 1,
            "pame_id" => $data[0]['pame_id']
        );
        $bil_total = 0;
        $bill = BillModel::create($bill_data);
        foreach ($data as $item) {
            $query = "INSERT INTO `sales`(`sal_amount`, `clo_id`, `bil_id`) VALUES ('".$item['sal_amount']."','".$item['clo_id']."','".$bill['bil_id']."')";
            $statement = Connection::connection()->prepare($query);
            $statement->execute();
            $clo_price = ClotheModel::getPrice($item['clo_id']);
            $bil_total += $item['sal_amount'] * $clo_price;
            $bill_data['bil_total'] = $bil_total;
            $bill_update = BillModel::update($bill['bil_id'],$bill_data);
        }
        $message = array("Sale created successfully");
        return $message;
    }

    public static function update($data){
        $bil_total = 0;
        $bill_data = BillModel::find($data[0]['bil_id']);
        foreach ($data as $item) {
            $clo_price = ClotheModel::getPrice($item['clo_id']);
            $bil_total += $item['sal_amount'] * $clo_price;
            $query = "UPDATE `sales` SET `sal_amount`='".$item['sal_amount']."',`clo_id`='".$item['clo_id']."',`bil_id`='".$bill_data[0]['bil_id']."' WHERE sal_id = ".$item['sal_id'].";";
            $statement = Connection::connection()->prepare($query);
            $statement->execute();
        }
        $bill_data[0]['bil_total'] = $bil_total;
        $bill_update = BillModel::update($item['bil_id'],$bill_data[0]);
        $message = array("Sales updated successfully");
        return $message;
    }
}
?>