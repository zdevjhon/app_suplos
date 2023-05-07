<?php
namespace App\Models;

use App\Config\ResponseHttp;
use App\DB\ConnectionDB;

class OfferModel extends ConnectionDB {

    public static function create($offer)
    {
        $con = self::conexion();

		$sql="INSERT INTO offers (off_obeject, off_description, off_currency, off_amount, off_start_date, off_start_time, off_end_date, off_end_time, off_status, user_usu_id, protuct_pro_id, offerer_ofr_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";

   	  	$stm = $con->prepare($sql);
   	  	try {
	        $con->beginTransaction();
	        $stm->execute($offer);
	        $id = $con->lastInsertId();
	        $con->commit();
	        return $id;
	    } catch(\PDOException $e) {
            error_log('OfferModel::post -> ' . $e);
            die(json_encode(ResponseHttp::status500()));
	    }
    }

    public static function update($offer)
    {        
        $cnn = self::conexion();
        $sql = "UPDATE offers SET off_obeject = ?, off_description = ?, off_currency = ?, off_amount = ?, off_start_date = ?, off_start_time = ?, off_end_date = ?, off_end_time = ?, protuct_pro_id = ?, offerer_ofr_id = ? WHERE  off_id = ?;";
        $stm = $cnn->prepare($sql);
        try {
            $cnn->beginTransaction();
            $stm->execute($offer);
            $inserted = $stm->rowCount();// return filas afectadas
            $cnn->commit();
            return $inserted;
        } catch(\PDOException $e) {
            $cnn->rollback();
            return "Error!: " . $e->getMessage() . "</br>";
        }
    }

    public static function exist($object)
    {
        $cnn= self::conexion();
        $sql="SELECT * FROM offers WHERE off_obeject = '$object' limit 0,1;";
        $sql=$cnn->prepare($sql);
        $sql->execute();
        return $resultado=$sql->fetchAll();
    }

    public static function read($off_id)
    {
        $cnn= self::conexion();
        $sql="SELECT * FROM offers WHERE off_id = '$off_id' limit 0,1;";
        $sql=$cnn->prepare($sql);
        $sql->execute();
        return $resultado=$sql->fetchAll();
    }

    final public static function readAll()
    {   
        $con = self::conexion();

        $sql="SELECT * FROM offers";

        try{            
            $sql=$con->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll(\PDO::FETCH_ASSOC);
        } catch(\PDOException $e) {
            error_log('UserModel::post -> ' . $e);
            die(json_encode(ResponseHttp::status500()));
        }
    }

    final public static function searchOffer($object, $desc, $usu_id, $status)
    {   
        $con = self::conexion();

        $where = '';
        if (!empty($object)) {
            $where = "AND off_obeject = $object";
        }
        if (!empty($desc)) {
            $where = "AND off_description like '%$desc%' ";
        }
        if (!empty($usu_id)) {            
            if ($status != '0') {
                $where = "AND user_usu_id = $usu_id";
            } 
        }
        if (!empty($status)) {
            if ($status != '0') {
                $where = "AND off_status = $status";
            }            
        }

        $sql="SELECT o.*,u.usu_name,p.pro_name FROM offers o 
                inner join user u on o.user_usu_id=u.usu_id 
                inner join products p on o.protuct_pro_id=p.pro_id
                WHERE 1 $where;";

        try{            
            $sql=$con->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll(\PDO::FETCH_ASSOC);
        } catch(\PDOException $e) {
            error_log('UserModel::post -> ' . $e);
            die(json_encode(ResponseHttp::status500()));
        }
    }

    final public static function readAllProducts($search, $columnName, $columnSortOrder, $row, $rowperpage)
    {   
        $con = self::conexion();

        $limit = $row.','.$rowperpage;

        $sql="SELECT p.pro_id,p.pro_name,c.cat_name,f.fam_name,s.seg_name from products p inner join clase c on p.clase_cat_id=c.cat_id
        inner join familias f on p.familia_fam_id=f.fam_id
        inner join segmento s on p.segmento_seg_id=s.seg_id WHERE 1 $search  order by $columnName $columnSortOrder limit $limit;";

        //\print_r($sql);
        try{            
            $sql=$con->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll(\PDO::FETCH_ASSOC);
        } catch(\PDOException $e) {
            error_log('UserModel::post -> ' . $e);
            die(json_encode(ResponseHttp::status500()));
        }
    }

    final public static function getTotal()
    {   
        $con = self::conexion();

        $sql="SELECT count(*) as total from products;";
        //\print_r($sql);
        try{            
            $sql=$con->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetch(\PDO::FETCH_ASSOC);
        } catch(\PDOException $e) {
            error_log('UserModel::post -> ' . $e);
            die(json_encode(ResponseHttp::status500()));
        }
    }

    final public static function getProduct($pro_id)
    {   
        $con = self::conexion();

        $sql="SELECT * from products WHERE pro_id = $pro_id;";
        try{            
            $sql=$con->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll(\PDO::FETCH_ASSOC);
        } catch(\PDOException $e) {
            error_log('UserModel::post -> ' . $e);
            die(json_encode(ResponseHttp::status500()));
        }
    }

    final public static function addContent($datos)
    {
        $con = self::conexion();

		$sql="INSERT INTO documents (doc_title, doc_content, offer_off_id) VALUES (?, ?, ?);";

   	  	$stm = $con->prepare($sql);
   	  	try {
	        $con->beginTransaction();
	        $stm->execute($datos);
	        $id = $con->lastInsertId();
	        $con->commit();
	        return $id;
	    } catch(\PDOException $e) {
            error_log('OfferModel::post -> ' . $e);
            die(json_encode(ResponseHttp::status500()));
	    }
    }

    final public static function getContent($off_id)
    {   
        $con = self::conexion();

        $sql="SELECT * from documents WHERE offer_off_id = $off_id;";

        //\print_r($sql);
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