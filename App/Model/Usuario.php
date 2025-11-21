<?php
    class Usuario extends Conectar{

        public function login(){
            $conectar=parent::conexion();
            parent::set_names();
            if(isset($_POST["enviar"])){
                $correo = $_POST["usu_correo"];
                $pass = $_POST["usu_pass"];
                if(empty($correo) and empty($pass)){
                    header("Location:".conectar::ruta()."index.php?m=2");
					exit();
                }else{
                    $sql = "SELECT * FROM usuarios WHERE correo=? and contrasena=MD5(?) and (estado=1 or estado=2)";
                    $stmt=$conectar->prepare($sql);
                    $stmt->bindValue(1, $correo);
                    $stmt->bindValue(2, $pass);
                    $stmt->execute();
                    $resultado = $stmt->fetch();
                    if (is_array($resultado) and count($resultado)>0){
                        
                        if($resultado["estado"] == 2){
                            header("Location:".Conectar::ruta()."App/view/Login/login.php?m=2");
                            exit();
                        }else{
                            $_SESSION["id_usuario"]=$resultado["id_usuario"];
                            $_SESSION["usuario"]=$resultado["usuario"];
                            $_SESSION["nombre"]=$resultado["nombre"];
                            $_SESSION["apellido"]=$resultado["apellido"];
                            $_SESSION["rol"]=$resultado["id_rol"];
                            $_SESSION["area"]=$resultado["id_area"];
                            $_SESSION["estado"]=$resultado["estado"];
                            $_SESSION["ultima_sesion"]=$resultado["ultima_sesion"];

                            //Actualizamos la sesion actual y la ultima sesión
                            $sql = "UPDATE usuarios SET ultima_sesion = usuarios.sesion_actual, sesion_actual = NOW(), ultima_actividad = NOW(), usuario_activo = 1 WHERE id_usuario = ?";
                            $stmt = $conectar->prepare($sql);
                            $stmt->bindValue(1, $_SESSION["id_usuario"]);
                            $stmt->execute();
                            
                            header("Location:".Conectar::ruta()."App/view/MenuPrincipal/Menu_Principal.php");
                            exit(); 
                        }
                        
                    }else{
                        header("Location:".Conectar::ruta()."App/view/Login/login.php?m=1");
                        exit();
                    }
                }
            }
        }
        
        public function obtenerCorreoDatos($correo){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT * FROM usuarios WHERE correo = ?";
            $stmt = $conectar->prepare($sql);
            $stmt->bindValue(1, $correo);
            $stmt->execute();
            return $stmt->fetch();
        }

        public function update_usuario_sesion($usu_id){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "UPDATE usuarios SET ultima_actividad = NOW() WHERE id_usuario = ?";
            $stmt = $conectar->prepare($sql);
            $stmt->bindValue(1, $usu_id);
            $stmt->execute();
        }

        //si se utiliza en ticketController
        public function buscar_persona($query, $id_rol = null,$usu_id = null){
            //Debemos tomar en cuenta que los soportes normales no podran asignarles tickets a los administradores, en cambio los administradores podran asignarles tickets a los soportes normales
            // Admins: 1
            // Soporte: 2
            // Usuarios de otras areas: 3
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT u.id_usuario as 'usu_id', 
                        CONCAT(u.nombre, ' ', u.apellido) AS 'persona',
                        u.dni
                    FROM usuarios u
                    WHERE (CONCAT(u.nombre, ' ', u.apellido) LIKE ?
                    OR u.nombre LIKE ?
                    OR u.apellido LIKE ?
                    OR u.dni LIKE ?) 
                    AND u.id_usuario != -1 ";
                    
                    if($id_rol == 1){
                        $sql .= "AND u.id_rol != 3";
                    }

                    if($id_rol == 2){
                        $sql .= "AND u.id_rol != 1 
                        AND u.id_rol != 3";
                    }
                    

                    $sql .= " LIMIT 5;";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, "%$query%");
            $sql->bindValue(2, "%$query%");
            $sql->bindValue(3, "%$query%");
            $sql->bindValue(4, "%$query%");
            $sql->execute();
            return $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        public function update_usuario_estado($usu_id, $estado){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "UPDATE usuarios SET estado = ? WHERE id_usuario = ?";
            $stmt = $conectar->prepare($sql);
            $stmt->bindValue(1, $estado);
            $stmt->bindValue(2, $usu_id);
            $stmt->execute();
        }
        
        public function insert_usuario($nombre, $apellido, $usuario, $dni, $correo, $telefono, $area, $rol, $password) {
            try {
                $conectar = parent::conexion();
                parent::set_names();
                $sql = "INSERT INTO usuarios (id_usuario, nombre, apellido, dni, usuario, correo, contrasena, telefono, id_area, id_rol, estado, verificado, fecha_registro)
                        VALUES (NULL, ?, ?, ?, ?, ?, MD5(?), ?, ?, ?, '2', 0, now());";
                $sql = $conectar->prepare($sql);
                $sql->bindValue(1, $nombre);
                $sql->bindValue(2, $apellido);
                $sql->bindValue(3, $dni);
                $sql->bindValue(4, $usuario);
                $sql->bindValue(5, $correo);
                $sql->bindValue(6, $password);
                $sql->bindValue(7, $telefono);
                $sql->bindValue(8, $area);
                $sql->bindValue(9, $rol);
        
                if ($sql->execute()) {
                    return $conectar->lastInsertId()."-".$correo; // ID insertado
                } else {
                    return false; // Inserción fallida
                }
        
            } catch (PDOException $e) {
                // Captura el error de PDO
                return "Error: " . $e->getMessage();
            }
        }

        public function update_usuario($usu_id, $dni, $usu_nom, $usu_ape, $usu_correo, $usuario, $rol_id, $telefono, $area){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "UPDATE usuarios SET
                        dni = ?,
                        nombre = ?,
                        apellido = ?,
                        correo = ?,
                        usuario = ?,
                        id_rol = ?,
                        telefono = ?,
                        id_area = ?
                    WHERE id_usuario = ?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $dni);
            $sql->bindValue(2, $usu_nom);
            $sql->bindValue(3, $usu_ape);
            $sql->bindValue(4, $usu_correo);
            $sql->bindValue(5, $usuario);
            $sql->bindValue(6, $rol_id);
            $sql->bindValue(7, $telefono);
            $sql->bindValue(8, $area);
            $sql->bindValue(9, $usu_id);
            return $sql->execute(); // Devuelve true o false
        }   
        //Si se usa en el perfil
        public function update_usuario_datos($usu_id,$usu_nom, $usu_ape, $usu_correo, $usuario, $telefono){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "UPDATE usuarios SET
                        nombre = ?,
                        apellido = ?,
                        correo = ?,
                        usuario = ?,
                        telefono = ?
                    WHERE id_usuario = ?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $usu_nom);
            $sql->bindValue(2, $usu_ape);
            $sql->bindValue(3, $usu_correo);
            $sql->bindValue(4, $usuario);
            $sql->bindValue(5, $telefono);
            $sql->bindValue(6, $usu_id);
            return $sql->execute(); // Devuelve true o false
        } 

        public function delete_usuario($usu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE usuarios SET estado='0' WHERE id_usuario=?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function habilitar_usuario($usu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE usuarios SET estado='1' WHERE id_usuario=?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_usuario(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT u.*, r.nombre as 'rolNombre', a.nombre as 'areaNombre' FROM usuarios u INNER JOIN rol r ON u.id_rol = r.id_rol INNER JOIN areas a ON u.id_area = a.id_area";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        

        public function get_usuario_por_estado($estado){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT u.*, r.nombre as 'rolNombre', a.nombre as 'areaNombre' FROM usuarios u INNER JOIN rol r ON u.id_rol = r.id_rol INNER JOIN areas a ON u.id_area = a.id_area WHERE u.estado = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $estado);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

//////////////////////////PRUEBA//////////////////////////////
        // public function get_usuario_x_usuario($usuario){
        //     $conectar= parent::conexion();
        //     parent::set_names();
        //     $sql="SELECT * FROM usuarios where usuario=?";
        //     $sql=$conectar->prepare($sql);
        //     $sql->bindValue(1, $usuario);
        //     $sql->execute();
        //     return $resultado=$sql->fetch();
        // }

        // public function get_usuario_x_correo($correo){
        //     $conectar= parent::conexion();
        //     parent::set_names();
        //     $sql="SELECT * FROM usuarios where correo=?";
        //     $sql=$conectar->prepare($sql);
        //     $sql->bindValue(1, $correo);
        //     $sql->execute();
        //     return $resultado=$sql->fetch();
        // }

        // public function get_usuario_x_dni($dni){
        //     $conectar= parent::conexion();
        //     parent::set_names();//estado='1' and verificado='1' and
        //     $sql="SELECT * FROM usuarios where dni=?";
        //     $sql=$conectar->prepare($sql);
        //     $sql->bindValue(1, $dni);
        //     $sql->execute();
        //     return $resultado=$sql->fetch();
        // }

        public function get_usuario_x_usuario($usuario, $id_actual = null){
            $conectar = parent::conexion();
            parent::set_names();
        
            if ($id_actual === null) {
                $sql = "SELECT * FROM usuarios WHERE usuario = ?";
                $sql = $conectar->prepare($sql);
                $sql->bindValue(1, $usuario);
            } else {
                $sql = "SELECT * FROM usuarios WHERE usuario = ? AND id_usuario != ?";
                $sql = $conectar->prepare($sql);
                $sql->bindValue(1, $usuario);
                $sql->bindValue(2, $id_actual);
            }
        
            $sql->execute();
            return $sql->fetch();
        }

        public function get_usuario_x_correo($correo, $id_actual = null){
            $conectar = parent::conexion();
            parent::set_names();
        
            if ($id_actual === null) {
                $sql = "SELECT * FROM usuarios WHERE correo = ?";
                $sql = $conectar->prepare($sql);
                $sql->bindValue(1, $correo);
            } else {
                $sql = "SELECT * FROM usuarios WHERE correo = ? AND id_usuario != ?";
                $sql = $conectar->prepare($sql);
                $sql->bindValue(1, $correo);
                $sql->bindValue(2, $id_actual);
            }
        
            $sql->execute();
            return $sql->fetch();
        }

        public function get_usuario_x_dni($dni, $id_actual = null){
            $conectar = parent::conexion();
            parent::set_names();
        
            if ($id_actual === null) {
                $sql = "SELECT * FROM usuarios WHERE dni = ?";
                $sql = $conectar->prepare($sql);
                $sql->bindValue(1, $dni);
            } else {
                $sql = "SELECT * FROM usuarios WHERE dni = ? AND id_usuario != ?";
                $sql = $conectar->prepare($sql);
                $sql->bindValue(1, $dni);
                $sql->bindValue(2, $id_actual);
            }
        
            $sql->execute();
            return $sql->fetch();
        }
        
        

////////////////////////////////////////////////////////

        public function get_usuario_x_rol(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM usuarios where est=1 and rol_id=2";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_usuario_x_id($usu_id){
            $conectar= parent::conexion();
            parent::set_names();
            // $sql="SELECT * FROM usuarios where id_usuario=?";
            $sql="SELECT u.*, areas.nombre as 'areaNombre', rol.nombre as 'rolNombre' FROM usuarios u
            INNER JOIN rol ON u.id_rol = rol.id_rol
            INNER JOIN areas ON u.id_area = areas.id_area
            where id_usuario=?";    
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetch();
        }

        public function Contar_Tickets_Totales($usu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT COUNT(*) as TOTAL FROM tickets where id_usuario = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetch();
        }


        public function Contar_Tickets_Cerrados($usu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT COUNT(*) as TOTAL_CERRADOS FROM tickets where tick_estado='Cerrado' and id_usuario = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetch();
        }

        public function get_usuario_total_x_id($usu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT COUNT(*) as TOTAL FROM tm_ticket where usu_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_usuario_totalabierto_x_id($usu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT COUNT(*) as TOTAL FROM tm_ticket where usu_id = ? and tick_estado='Abierto'";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_usuario_totalcerrado_x_id($usu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT COUNT(*) as TOTAL FROM tm_ticket where usu_id = ? and tick_estado='Cerrado'";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_usuario_grafico($usu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT tm_categoria.cat_nom as nom,COUNT(*) AS total
                FROM   tm_ticket  JOIN  
                    tm_categoria ON tm_ticket.cat_id = tm_categoria.cat_id  
                WHERE    
                tm_ticket.est = 1
                and tm_ticket.usu_id = ?
                GROUP BY 
                tm_categoria.cat_nom 
                ORDER BY total DESC";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function update_usuario_pass($usu_id,$usu_pass){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE usuarios
                SET
                    contrasena = MD5(?)
                WHERE
                    id_usuario = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_pass);
            $sql->bindValue(2, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }


    }
?>