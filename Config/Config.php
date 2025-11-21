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
        // 1. Obtener los valores de las variables de entorno de Railway
        // Usamos valores por defecto (localhost/root) por si lo ejecutas localmente sin Railway configurado.
        // En Railway, se usarán los valores públicos que has configurado.

        // NOTA: Para el host, también necesitas el puerto. PDO usa el formato host=dominio;port=puerto
        $host = getenv('DB_HOST') ?: 'db'; 
        $port = getenv('DB_PORT') ?: '3306'; 
        $user = getenv('DB_USER') ?: 'root';
        $password = getenv('DB_PASSWORD') ?: 'root';
        $dbname = getenv('DB_NAME') ?: 'bdtickets';

        try {
            // Utilizamos el formato PDO con el puerto:
            $conectar = $this->dbh = new PDO(
                "mysql:host=$host;port=$port;dbname=$dbname",
                $user,
                $password
            );
            
            // Opcional: Configurar el modo de errores para debugging
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $conectar;

        } catch (Exception $e) {
            // En producción, es mejor registrar esto y mostrar un mensaje genérico.
            print "¡Error de conexión a la Base de Datos!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function set_names(){
        // Configura el conjunto de caracteres a UTF8 para evitar problemas con tildes y ñ
        return $this->dbh->query("SET NAMES 'utf8'");
    }

    public static function ruta(){
        // Usamos una variable de entorno (APP_URL) para saber la ruta raíz.
        // Si está en Railway, esta variable tendrá el dominio público de Railway.
        // Si no está definida (o en local), usa 'http://localhost/'
        return getenv('APP_URL') ?: "http://localhost/"; 
    }
}
?>
