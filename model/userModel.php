<?php

require_once "ConDB.php";
class UserModel{

    static private function getMail($mail){
        $query = "SELECT use_email FROM users WHERE use_email = '$mail'";
        $statement = Connection::connection()->prepare($query);
        $statement->execute();
        $result = $statement->rowCount();
        return $result;
    }

    static public function createUser($data){
        $cantMail = self::getMail($data["use_email"]);
        if($cantMail==0){
            $date = date("Y-m-d");
            $status = "1";
            $query = "INSERT INTO `users`(`use_name`, `use_email`, `use_password`, `use_datecreate`, `use_key`, `use_identifier`, `use_status`, `use_celular`, `use_direccion`) VALUES ('".$data['use_name']."','".$data['use_email']."','".$data['use_password']."','".$date."','".$data['use_key']."', '".$data['use_identifier']."','".$status."', '".$data['use_celular']."','".$data['use_direccion']."')";
            $statement = Connection::connection()->prepare($query);
            $message = $statement-> execute() ? array("ok") : Connection::connection()->errorInfo();
            $statement->closeCursor();
            $statement = null;
            $query="";
        }else{$message = array("el usuario ya existe");}
        return $message;
    }

    static private function getStatus($id){
        $query = "SELECT use_status FROM users WHERE use_id = '$id'";
        $statement = Connection::connection()->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result[0]['use_status'];
    }


    static public function getUsers($parametro){
        $param = is_numeric($parametro) ? $parametro : 0;
        $query = "SELECT * FROM users";
        $query .= ($param > 0) ? " WHERE users.use_id = '$param' AND " : "";
        $query .= ($param > 0) ? " use_status = '1';" : " WHERE use_status = '1';";
        // return $query;
        $statement = Connection::connection()->prepare($query);
        $statement -> execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    static public function login($data){
        $user = $data['use_email'];
        $pass = md5($data['use_password']);

        if (!empty($user) && !empty($pass)){
            $query="SELECT  use_id, use_key, use_identifier FROM users WHERE use_email = '$user' and use_password='$pass' and use_status='1'";
            $statement = Connection::connection()->prepare($query);
            $statement-> execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }else{
            return "NO TIENE CREDENCIALES";
        }
    }


    static public function update($id,$data){
        $pass = md5($data['use_password']);
        $query = "UPDATE users SET use_email='".$data['use_email']."',use_password='".$pass."' WHERE use_id = ".$id.";";
        $statement = Connection::connection()->prepare($query);
        $statement->execute();
        $msg = array(
            "msg"=>"Usuario actualizado"
        );
        return $msg;
    }

    static public function delete($id){
        $status = self::getStatus($id);
        $newStatus = ($status == 0) ? 1 : 0;
        $query = "UPDATE users SET use_status='".$newStatus."' WHERE use_id = ".$id.";";
        $statement = Connection::connection()->prepare($query);
        $statement->execute();
        $msg = array(
            "msg"=>"Usuario Eliminado"
        );
        return $msg;
    }
}
?>
