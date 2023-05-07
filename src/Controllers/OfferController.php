<?php

require '../../vendor/autoload.php';
require_once '../../globals.php';

use App\Models\OfferModel;

header("Content-Type: application/json");

switch ($_GET["op"]) {
    case 'create_update':
        if ($_POST['off_obeject'] == '') {
            $errors['off_obeject'] = "Ingrese Objeto";
        }
        if ($_POST['protuct_pro_id'] == '') {
            $errors['protuct_pro_id'] = "Seleccione Actividad";
        }
        if ($_POST['off_start_date'] == '') {
            $errors['off_start_date'] = "Ingrese Fecha Inicio";
        }
        if ($_POST['off_start_date'] == '') {
            $errors['off_start_date'] = "Ingrese Hora Inicio";
        }
        if ($_POST['off_end_date'] == '') {
            $errors['off_end_date'] = "Ingrese Fecha Cierre";
        }
        if ($_POST['off_end_time'] == '') {
            $errors['off_end_time'] = "Ingrese Hora Cierre";
        }
        
        if (isset($errors)) {
            echo json_encode(['status' => STATUS_FAIL, 'msg'=>'Complete los campos Obligatorios']);
            exit();
        }

        if (empty($_POST["off_id"])) { // agregamos nuevo regsitro
            $verify = OfferModel::exist($_POST['off_obeject']);
            if (is_array($verify) == true and count($verify) == 0) {

                $amount = (empty($_POST['off_amount']))? 0.00: $_POST['off_amount'];

                $datos = array(
                    $_POST['off_obeject'],
                    $_POST['off_description'],
                    $_POST['off_currency'],
                    $amount,
                    $_POST['off_start_date'],
                    $_POST['off_start_time'],
                    $_POST['off_end_date'],
                    $_POST['off_end_time'],
                    ST_ACTIVO,// status
                    1,//$_POST['user_usu_id']
                    $_POST['protuct_pro_id'],
                    null// offerer id                    
                );

                $id = OfferModel::create($datos);
                if ($id > 0) {
                    echo json_encode(['status' => STATUS_OK, 'msg'=>'Registrado correctamente']);
                    exit();
                } else {                    
                    echo json_encode(['status' => STATUS_FAIL, 'msg'=>'Ocurrió un error']);
                    exit();
                }
            } else {
                echo json_encode(['status' => STATUS_FAIL, 'msg'=>'El objeto ya existe']);
                exit();
            }
        } else { // editamos el registro

            $amount = (empty($_POST['off_amount']))? 0.00: $_POST['off_amount'];

            $datos = array(
                $_POST['off_obeject'],
                $_POST['off_description'],
                $_POST['off_currency'],
                $amount,
                $_POST['off_start_date'],
                $_POST['off_start_time'],
                $_POST['off_end_date'],
                $_POST['off_end_time'],
                $_POST['protuct_pro_id'],
                null,// offerer id   
                $_POST['off_id']              
            );

            $id = OfferModel::update($datos);
            if ($id >= 0) {
                echo json_encode(['status' => STATUS_OK, 'msg'=>'Editado correctamente']);
                exit();
            } else {
                echo json_encode(['status' => STATUS_FAIL, 'msg' => 'Ocurrió un error']);
                exit();
            }
            
        }
        break;

    case 'read':
        $datos = OfferModel::read($_POST["off_id"]);
        //off_id, off_obeject, off_description, off_currency, off_amount, off_start_date, off_start_time, off_end_date, off_end_time, off_status, user_usu_id, protuct_pro_id, offerer_ofr_id, created_at, updated_at
        foreach($datos as $row) {
            $output["off_id"] = $row["off_id"];
            $output["off_obeject"] = $row["off_obeject"];

            $output["off_description"] = $row["off_description"];
            $output["off_currency"] = $row["off_currency"];
            $output["off_amount"] = $row["off_amount"];
            $output["off_start_date"] = $row["off_start_date"];
            $output["off_start_time"] = $row["off_start_time"];
            $output["off_end_date"] = $row["off_end_date"];
            $output["off_end_time"] = $row["off_end_time"];

            $output["protuct_pro_id"] = $row["protuct_pro_id"];
        }
        echo json_encode($output);
        break;

    case 'read_all':

        $datos = OfferModel::readAll();

        $data= Array();
        //off_id, off_obeject, off_description, off_currency, off_amount, off_start_date, off_start_time, off_end_date, off_end_time, off_status, user_usu_id, protuct_pro_id, offerer_ofr_id, created_at, updated_at
        foreach ($datos as $row) {
            $sub_array = array();
            if ($row["off_status"] == ST_ACTIVO) {
                $estado = '<span class="badge bg-primary" onClick="cambiarEstado('.$row["off_id"].','.$row["off_status"].');">Activo</span>';
            }
            else if ($row["off_status"] == ST_PUBLICADO) {
                $estado = '<span class="badge bg-info" onClick="cambiarEstado('.$row["off_id"].','.$row["off_status"].');">Publicado</span>';
            }else{
                $estado = '<span class="badge bg-warning" onClick="cambiarEstado('.$row["off_id"].','.$row["off_status"].');">Evaluación</span>';
            }
            
            $currency = 'COP';
            if ($row["off_currency"]=='2') {
                $currency = 'USD';
            }
            if ($row["off_currency"]=='3') {
                $currency = 'EUR';
            }

            $sub_array[] = $row["off_obeject"];
            $sub_array[] = $currency;
            $sub_array[] = $row["off_amount"];
            $sub_array[] = $row["off_start_date"]. ' ' .$row["off_start_time"];
            $sub_array[] = $row["off_end_date"]. ' ' .$row["off_end_time"];
            $sub_array[] = $estado;

            $sub_array[] = '<div class="form-button-action">
            <button type="button" data-toggle="tooltip" title="" class="btn btn-warning" data-original-title="Editar" onClick="mostrar('.$row["off_id"].');">
                <i class="fa fa-edit"></i>
            </button>
            <button type="button" data-toggle="tooltip" title="" class="btn btn-danger btn_del" data-original-title="Eliminar" onClick="eliminar('.$row["off_id"].')">
                <i class="fa fa-trash"></i>
            </button>
            </div>';

            $data[] = $sub_array;
        }
        $results = array(
        "sEcho"=>1, //Información para el datatables
        "iTotalRecords"=>count($data), //enviamos el total registros al datatable
        "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
        "aaData"=>$data);
        echo json_encode($results);

        break;

    case 'search_offer':

        $datos = OfferModel::searchOffer($_POST["off_obeject"], $_POST["off_description"], $_POST["user_usu_id"], $_POST["off_status"]);

        $data= Array();
        //off_id, off_obeject, off_description, off_currency, off_amount, off_start_date, off_start_time, off_end_date, off_end_time, off_status, user_usu_id, protuct_pro_id, offerer_ofr_id, created_at, updated_at
        foreach ($datos as $row) {
            $sub_array = array();
            $btn = '';
            if ($row["off_status"] == ST_ACTIVO) {
                $estado = '<span class="badge bg-primary" onClick="cambiarEstado('.$row["off_id"].','.$row["off_status"].');">Activo</span>';
                $btn = '<button type="button" title="Publicar" class="btn btn-info btn-sm" onClick="publicar('.$row["off_id"].');">
                            <i class="fa-solid fa-globe"></i>
                        </button>';
            }
            else if ($row["off_status"] == ST_PUBLICADO) {
                $estado = '<span class="badge bg-info" onClick="cambiarEstado('.$row["off_id"].','.$row["off_status"].');">Publicado</span>';
                $btn = '<button type="button" title="Cerrar" class="btn btn-warning btn-sm" onClick="publicar('.$row["off_id"].');">
                            <i class="fa-regular fa-circle-xmark"></i>
                        </button>';
            }else{
                $estado = '<span class="badge bg-warning" onClick="cambiarEstado('.$row["off_id"].','.$row["off_status"].');">Evaluación</span>';
                $btn = '<button type="button" title="Cerrado" class="btn btn-secondary btn-sm" onClick="publicar('.$row["off_id"].');">
                            <i class="fa-solid fa-folder-closed"></i>
                        </button>';
            }
            
            

            $sub_array[] = $row["off_obeject"];
            $sub_array[] = $row["off_description"];
            $sub_array[] = $row["off_start_date"]. ' ' .$row["off_start_time"];
            $sub_array[] = $row["off_end_date"]. ' ' .$row["off_end_time"];
            $sub_array[] = $estado;
            $sub_array[] = $row["usu_name"];
            

            $sub_array[] = '<div class="form-button-action text-center">
                                '.$btn.'
                            </div>';

            $data[] = $sub_array;
        }
        $results = array(
        "sEcho"=>1, //Información para el datatables
        "iTotalRecords"=>count($data), //enviamos el total registros al datatable
        "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
        "aaData"=>$data);
        echo json_encode($results);

        break;

    case 'read_all_actividad':

        ## Read value
        $draw = $_POST['draw'];
        $row = $_POST['start'];
        $rowperpage = $_POST['length']; // Rows display per page length
        $columnIndex = $_POST['order'][0]['column']; // Column index
        $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
        $searchValue = $_POST['search']['value']; // Search value

        ## Search 
        $searchQuery = " ";
        if($searchValue != ''){
            $searchQuery = " and (pro_id like '%".$searchValue."%' or 
                pro_name like '%".$searchValue."%' or
                cat_name like '%".$searchValue."%' or
                fam_name like '%".$searchValue."%' or
                seg_name like'%".$searchValue."%' ) ";
        }

        $datos = OfferModel::readAllProducts($searchQuery, $columnName, $columnSortOrder, $row, $rowperpage);

        $total = OfferModel::getTotal();

        $data= Array();
        //pro_id, pro_name, cat_name, fam_name, seg_name
        foreach ($datos as $row) {
            $sub_array = array();

            $sub_array["pro_id"] = $row["pro_id"];
            $sub_array["pro_name"] = $row["pro_name"];
            $sub_array["cat_name"] = $row["cat_name"];
            $sub_array["fam_name"] = $row["fam_name"];
            $sub_array["seg_name"] = $row["seg_name"];

            $sub_array["action"] = '<div class="form-button-action">
            <button type="button" data-toggle="tooltip" title="" class="btn btn-primary btn-sm" data-original-title="Editar" onClick="seleccionar('.$row["pro_id"].');">
                <i class="fa-solid fa-check"></i>
            </button>
            </div>';

            $data[] = $sub_array;
        }

        $totalfilter = count($data);

        if($searchValue == ''){
            $totalfilter = $total["total"];
        }

        $results = array(
            "draw" => intval($draw),
            "iTotalRecords"=>$total["total"], //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>$totalfilter, //enviamos el total registros a visualizar
            "aaData"=>$data
        );

        echo json_encode($results);

        break;
    
    case 'get_offer':
        $datos = OfferModel::getProduct($_POST["pro_id"]);
        // pro_id, pro_name, clase_cat_id, familia_fam_id, segmento_seg_id
        foreach($datos as $row) {
            $output["pro_id"] = $row["pro_id"];
            $output["pro_name"] = $row["pro_name"];
        }
        echo json_encode($output);
        break;

    case 'add_content':
        if ($_POST['doc_title'] == '') {
            $errors['doc_title'] = "Ingrese Título";
        }
        if ($_POST['doc_content'] == '') {
            $errors['doc_content'] = "Ingrese Descripción";
        }
        
        if (isset($errors)) {
            echo json_encode(['status' => STATUS_FAIL, 'msg'=>'Complete los campos Obligatorios']);
            exit();
        }

        if (!empty($_POST["off_id"])) { // agregamos nuevo regsitro

            $datos = array(
                $_POST['doc_title'],
                $_POST['doc_content'],
                $_POST["off_id"]              
            );

            $id = OfferModel::addContent($datos);
            if ($id > 0) {
                echo json_encode(['status' => STATUS_OK, 'msg'=>'Registrado correctamente']);
                exit();
            } else {                    
                echo json_encode(['status' => STATUS_FAIL, 'msg'=>'Ocurrió un error']);
                exit();
            }
            
        }

        break;

    case 'get_content':
        $datos = OfferModel::getContent($_POST["off_id"]);

        $html = '';

        foreach ($datos as $val) {
            $html .= '<tr>';
            $html .= '<td> '.$val["doc_title"].' </td>';
            $html .= '<td> '.$val["doc_content"].' </td>';
            $html .= '<td class="text-center"> <button class="btn btn-sm btn-danger" onClick="eliminar('.$val["doc_id"].')"> <i class="fa-solid fa-trash"></i> </button> </td>';
            $html .= '</tr>';
        }

        echo json_encode(['html'=>$html]);
        exit();
        break;

    default:
        # code...
        break;
}
