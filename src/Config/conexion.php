<?php
  	//session_start();
 	class Conectar {
		protected $dbh;
		private $con;
		public $host;
		public function __construct(){
			$this->username = $_ENV['DB_USERNAME_TEST'];
			$this->host = $_ENV['DB_HOST_TEST'];
			$this->password = $_ENV["DB_PASSWORD_TEST"];			
		}
		

		public function conexion(){
					
			try {
				$this->con = $this->dbh = new PDO("mysql:host=".$this->host.":3306;dbname=dbsuplos;charset=utf8",$this->username,$this->password);
		    return $this->con;
			} catch (Exception $e) {
				print "¡Error!: " . $e->getMessage() . "<br/>";
	        die();
			}
		}		

		//cierre de llave de la function conexion()
		public function set_names(){
			return $this->dbh->query("SET NAMES 'utf8'");
		}

		public function ruta(){
			return "http://localhost/app_suplos/";
		}

	}//cierre de llave conectar
	$m = new Conectar();
?>