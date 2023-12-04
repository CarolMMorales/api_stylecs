<?php

require_once "ConDB.php";

class CategoryModel {

    public static function all(){
        $query = "SELECT * FROM categories";
        $statement = Connection::connection()->prepare($query);
        $statement->execute();
        $categories = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $categories;
    }

    public static function find($id){
        $query = "SELECT * FROM categories WHERE cat_id = $id";
        $statement = Connection::connection()->prepare($query);
        $statement->execute();
        $category = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $category;
    }

    public static function create($data){
        $query = "INSERT INTO `categories`( `cat_category`) VALUES ('".$data['cat_name']."')";
        $statement = Connection::connection()->prepare($query);
        $statement->execute();
        $message = array("Category created successfully");
        return $message;
    }

    public static function update($id,$data){
        $query = "UPDATE `categories` SET `cat_category`='".$data['cat_name']."' WHERE cat_id = $id";
        $statement = Connection::connection()->prepare($query);
        $statement->execute();
        $message = array("Category updated successfully");
        return $message;
    }
}
?>