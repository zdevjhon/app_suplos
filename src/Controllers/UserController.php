<?php

require '../../vendor/autoload.php';
require_once '../../globals.php';

use App\Config\ErrorLog;
use App\Models\UserModel;

ErrorLog::activateErrorLog();

switch ($_GET["op"]) {
    case 'create_update':
        # code...
        break;
    
    case 'verificar_email':

        if($_POST['username']=='')
        {
            $errors['username'] = "Ingrese correo";
        }

        if (isset($errors))
        {
            $res = ['status' => STATUS_FAIL, 'msg'=>'Ingrese correo'];
            echo json_encode($res);
            exit();
        }

        $verify = UserModel::readUser($_POST['username']);
        if (is_array($verify)==true and count($verify)==0) {//
            echo json_encode(['status' => STATUS_FAIL, 'msg'=>'Usuario No Existe']);
        }else{
            $emailBD = '';
            $paswordBD = '';
            $nombres = '';
            //usu_id, usu_name, usu_email, usu_password, create_time
            foreach ($verify as $key => $value) {
                $emailBD = $value["usu_email"];
                $paswordBD = $value["usu_password"];
                $user_id = $value["usu_id"];
                $nombres = $value["usu_name"];
            }
            
            if($emailBD == $_POST["username"] and password_verify($_POST["password"], $paswordBD)){
                if(!isset($_SESSION))
                {
                    session_start();
                }
                $_SESSION['correo'] = $emailBD;
                $_SESSION['user_id'] = $user_id;
                $_SESSION['nombres'] = $nombres;
                $_SESSION['estado'] = 'Autenticado';

                echo json_encode(['status' => STATUS_OK, 'msg'=>'Session iniciada']);
            }else{
                echo json_encode(['status' => STATUS_FAIL, 'msg'=>'Los datos son incorrectos']);
            }
        }
        break;

    case 'read_all':

        $datos = UserModel::readAllUser();
        $data= Array();
        //usu_id, usu_name, usu_email, usu_password, create_time
        foreach ($datos as $row) {
            $sub_array = array();            

            $sub_array[] = $row["usu_id"];
            $sub_array[] = $row["usu_name"];
            $sub_array[] = $row["usu_email"];

            $data[] = $sub_array;
        }
        $results = array(
        "sEcho"=>1, //Información para el datatables
        "iTotalRecords"=>count($data), //enviamos el total registros al datatable
        "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
        "aaData"=>$data);
        echo json_encode($results);
        
        break;
    
    default:
        # code...
        break;
}