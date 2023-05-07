<?php

require './vendor/autoload.php';

use App\Config\ErrorLog;

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

ErrorLog::activateErrorLog();

session_start();

include_once('globals.php');

function base_url()
{
    $BASE_URL =  $_ENV['HOST']."/";
    return $BASE_URL;
}

$url = isset($_GET['url']) ? $_GET['url'] : "login";
$arrUrl = explode("/", $url);
$controller = $arrUrl[0];
$methop = $arrUrl[0];
$params = "";
if (isset($arrUrl[1])) {
    if ($arrUrl[1] != "") {
        $methop = $arrUrl[1];
    }
}

if (isset($arrUrl[2])) {
    if ($arrUrl[2] != "") {
        for ($i=2; $i < count($arrUrl); $i++) {
            $params .= $arrUrl[$i]. ',';
        }
        $params = trim($params, ',');
    }
}
// controller = "Controller/home.php"
$file_name = 'login';
$vista = "login.php";

switch (sizeof($arrUrl)) {
    case 0:
        $vista = "login.php";
        $file_name = 'login';
        break;
    case 1:
        $vista = "./src/Views/" . $controller . ".php";
        $file_name = $controller;
        break;
    case 2:
        $vista = "./src/Views/" . $controller."/".$methop.".php";
        $file_name = $controller."/".$methop;
        break;
    /*case 3:
        $vista = "vistas/" . $controller."/".$methop.".php";
        break;*/
   default:
        $vista = "./src/Views/Error.php";        
        break;
}



function getView($vista, $file_name='')
{   
    if (file_exists($vista)) {
        getFile($file_name);
        require_once($vista);
    } else{
        require_once("./src/Views/Error.php");
    }
}

function getFile($file_name)
{
    return $file_name;
}

function verificar_sesion($vista){
    if(isset($_SESSION['correo']) and $_SESSION['estado'] == 'Autenticado') {
        
        require_once($vista);

    }else{
        header("Refresh:0; url=login");die();
    }
}

getView($vista, $file_name);