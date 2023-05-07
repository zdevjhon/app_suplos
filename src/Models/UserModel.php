<?php

namespace App\Models;

use App\Config\ResponseHttp;
use App\DB\ConnectionDB;

class UserModel extends ConnectionDB {
 
    public static function createUser($user)
    {
        $con = self::conexion();

		$sql="INSERT INTO user (usu_name, usu_email, usu_password) VALUES (?, ?, ?);";

   	  	$stm = $con->prepare($sql);
   	  	$datos = array($user);
   	  	try {
	        $con->beginTransaction();
	        $stm->execute($datos);
	        $id = $con->lastInsertId();
	        $con->commit();
	        return $id;
	    } catch(\PDOException $e) {
            error_log('UserModel::post -> ' . $e);
            die(json_encode(ResponseHttp::status500()));
	    }
    }

    public static function readUser($email)
    {
        $cnn= self::conexion();
        $sql="SELECT * FROM user where usu_email = '$email'";
        $sql=$cnn->prepare($sql);
        $sql->execute();
        return $resultado=$sql->fetchAll();
    }

    final public static function readAllUser()
    {   
        $con = self::conexion();

        $sql="SELECT * FROM user";

        try{            
            $sql=$con->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll(\PDO::FETCH_ASSOC);
        } catch(\PDOException $e) {
            error_log('UserModel::post -> ' . $e);
            die(json_encode(ResponseHttp::status500()));
        }
    }
    
}