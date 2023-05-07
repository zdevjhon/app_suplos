<?php
namespace App\DB;
use App\Config\ResponseHttp;
use Dotenv\Dotenv;
    
$dotenv = Dotenv::createImmutable(\dirname(__DIR__,2));
$dotenv->load();
//session_start();
class ConnectionDB {
    private static $username;
    private static $password;
    public static $host;

    public function __construct(){
        self::$username = $_ENV['DB_USERNAME_TEST'];
        self::$host = $_ENV['DB_HOST_TEST'];
        self::$password = $_ENV["DB_PASSWORD_TEST"];
    }
    

    final public static function conexion() {	
        try {
            $opt = [\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC];
            $dsn = new \PDO("mysql:host=".self::$host.":3306;dbname=dbsuplos;charset=utf8",self::$username,self::$password,$opt);
            $dsn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $dsn->query("SET NAMES 'utf8'");
            //error_log('conexion exitosa');
            return $dsn;
        } catch (\PDOException $p) {
            print "¡Error!: " . $p . "<br/>";
            /*error_log('Error de conexion :' . $p);
            die(json_encode(ResponseHttp::status500()));*/
        }
    }	

}//cierre de llave conectar

$m = new ConnectionDB();