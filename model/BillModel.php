<?php

require_once "ConDB.php";

class BillModel {
    public static function all(){
        $query = "SELECT bills.*, users.use_name, payment_method.pame_method FROM `bills` INNER JOIN users ON bills.use_id = users.use_id INNER JOIN payment_method ON bills.pame_id = payment_method.pame_id;";
        $statement = Connection::connection()->prepare($query);
        $statement->execute();
        $bills = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $bills;
    }

    public static function find($id){
        $query = "SELECT bills.*, users.use_name, payment_method.pame_method FROM `bills` INNER JOIN users ON bills.use_id = users.use_id INNER JOIN payment_method ON bills.pame_id = payment_method.pame_id WHERE bills.bil_id = $id";
        $statement = Connection::connection()->prepare($query);
        $statement->execute();
        $bill = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $bill;
    }

    public static function create($data){
        $date = date("Y-m-d");
        $query = "INSERT INTO `bills`(`bil_date`, `bil_total`, `use_id`, `pame_id`) VALUES ('".$date."','".$data['bil_total']."','".$data['use_id']."','".$data['pame_id']."')";
    
        $statement = Connection::connection()->prepare($query);
        $statement->execute();
    
        // Obtener el ID del último registro insertado
        $lastInsertedId = Connection::lastInsertId();
    
        $message = array("Bill created successfully", "bil_id" => $lastInsertedId);
        return $message;
    }

    public static function update($id,$data){
        $query = "UPDATE `bills` SET `bil_total`='".$data['bil_total']."',`use_id`='".$data['use_id']."',`pame_id`='".$data['pame_id']."' WHERE bil_id = $id";
        $statement = Connection::connection()->prepare($query);
        $statement->execute();
        $message = array("Bill updated successfully");
        return $message;
    }
}
?>