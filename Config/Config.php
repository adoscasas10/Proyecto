<?php
    session_start();
    
    // class Conectar{
    //     protected $dbh;

    //     protected function Conexion(){
    //         try {
    //             //Local
	// 			$conectar = $this->dbh = new PDO("mysql:local=localhost;dbname=bdtickets","root","");
    //             //Produccion
    //             //$conectar = $this->dbh = new PDO("mysql:host=localhost;dbname=andercode_helpdesk1","andercode","contraseña");
	// 			return $conectar;
	// 		} catch (Exception $e) {
	// 			print "¡Error BD!: " . $e->getMessage() . "<br/>";
	// 			die();
	// 		}
    //     }

    //     public function set_names(){
	// 		//return $this->dbh->query("SET NAMES 'utf8'");
    //     }
    //     public static function ruta(){
    //         //Local
	// 		return "http://localhost/Proyecto_PPP/";
    //         //Produccion
    //         //return "http://helpdesk.anderson-bastidas.com/";
	// 	}

    // }

    class Conectar{
        protected $dbh;

        protected function Conexion(){
            try {
                // --- CAMBIO 1: Credenciales de Docker ---
                // Host: 'db' (el nombre del servicio en docker-compose)
                // Dbname: 'bdtickets' (Asegúrate de que en docker-compose.yml pusiste este mismo nombre)
                // Pass: 'root' (La contraseña que definimos en el yaml)
                $conectar = $this->dbh = new PDO("mysql:host=db;dbname=bdtickets","root","root");
                
                return $conectar;

            } catch (Exception $e) {
                print "¡Error BD!: " . $e->getMessage() . "<br/>";
                die();
            }
        }

        public function set_names(){
            // --- RECOMENDACIÓN: Descomenta esto para evitar problemas con tildes y ñ ---
            return $this->dbh->query("SET NAMES 'utf8'");
        }

        public static function ruta(){
            // --- CAMBIO 2: La ruta raíz ---
            // En Docker, tu proyecto es la raíz del servidor.
            // Ya no necesitas poner "Proyecto_PPP" en la URL.
            return "http://localhost/"; 
        }
    }
?>