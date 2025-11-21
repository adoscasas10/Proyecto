<?php
    class Ticket extends Conectar{
        //Se esta utilizando en el controlador en ticketController  
        
        public function listar_tecnico(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM usuarios WHERE id_rol != 3 AND id_usuario != -1;";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll(pdo::FETCH_ASSOC);
        }

        public function insert_ticket($usu_id, $area_id,$cat_id, $tick_prioridad, $tick_titulo,$tick_descrip){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="INSERT INTO tickets (id_ticket, id_usuario, id_area, id_categoria, id_prioridad, titulo, descripcion, tick_estado, fecha_creacion, fecha_asignacion, estado) VALUES (NULL, ?, ?, ?, ?, ?, ?, 'Abierto', now(), NULL, '1');";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->bindValue(2, $area_id);
            $sql->bindValue(3, $cat_id);
            $sql->bindValue(4, $tick_prioridad);
            $sql->bindValue(5, $tick_titulo);
            $sql->bindValue(6, $tick_descrip);
            
            $sql->execute();

            $sql1="select last_insert_id() as 'tick_id';";
            $sql1=$conectar->prepare($sql1);
            $sql1->execute();
            return $resultado=$sql1->fetchAll(pdo::FETCH_ASSOC);
        }

        public function listarMenuPrincipal($id_ticket){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                t.id_ticket, 
                t.titulo, 
                t.fecha_creacion, 
                t.tick_estado
            FROM tickets t
            WHERE t.id_usuario = ?
            ORDER BY t.fecha_creacion DESC
            LIMIT 5;"; 
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id_ticket);
            $sql->execute();
            return $resultado=$sql->fetchAll(pdo::FETCH_ASSOC);
        }

        
        //Aun no se utiliza
        public function listar_ticket_x_usu($usu_id, $EstadoTicketAC, $Prioridad){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT  t.id_ticket,
                            pt.nombre as 'Prioridad',
                            c.nombre as 'Categoria',
                            t.titulo,
                            t.tick_estado, 
                            are.nombre as 'area',
                            u.nombre as 'usuarioAsignacion',
                            u.apellido as 'apellidoAsignacion',
                            t.fecha_creacion,
                            tu.fecha_asignacion,
                            t.id_usuario as 'creadorIdUsuario',
                            usu.nombre as 'creadorNom',
                            usu.apellido as 'creadorApe'
                    FROM tickets t
                    LEFT JOIN (
                        SELECT tu1.id_ticket, tu1.id_usuario, tu1.fecha_asignacion
                        FROM asignacion_ticket tu1
                        INNER JOIN (
                            SELECT ata.id_ticket, MAX(ata.fecha_asignacion) AS ultima_fecha
                            FROM asignacion_ticket ata
                            GROUP BY ata.id_ticket
                        ) ult
                        ON tu1.id_ticket = ult.id_ticket AND tu1.fecha_asignacion = ult.ultima_fecha
                    ) tu ON t.id_ticket = tu.id_ticket
                    LEFT JOIN usuarios u ON u.id_usuario = tu.id_usuario
                    INNER JOIN usuarios usu ON t.id_usuario = usu.id_usuario
                    INNER JOIN prioridad_ticket pt ON t.id_prioridad = pt.id_prioridad
                    INNER JOIN categorias c ON t.id_categoria = c.id_categoria
                    INNER JOIN areas are ON t.id_area = are.id_area
                    WHERE t.estado = 1 AND t.id_usuario = ?";

                    if($EstadoTicketAC != null){
                        $sql .= " AND t.tick_estado = '$EstadoTicketAC'";
                    }

                    if($Prioridad != null){
                        $sql .= " AND pt.nombre = '$Prioridad'";
                    }

                    $sql .= " ORDER BY t.id_ticket ASC;";

            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        //Ya se uso en Email  MODEL model
        public function listar_ticket_x_id($tick_id, $usu_id = null){
            $conectar= parent::conexion();
            parent::set_names();
            if($usu_id == null){
            $sql="SELECT 
                t.id_ticket as 'tick_id',
                t.id_usuario as 'usu_id',
                t.id_categoria as 'cat_id',
                t.titulo as 'tick_titulo',
                t.descripcion as 'tick_descrip',
                t.tick_estado as 'tick_estado',
                t.fecha_creacion as 'fech_crea',
                u.nombre as 'usu_nom',
                u.apellido as 'usu_ape',
                u.correo as 'usu_correo',
                c.nombre as 'cat_nom',
                p.nombre as 'tick_prioridad'
                FROM 
                tickets t
                INNER join categorias c on t.id_categoria = c.id_categoria
                INNER join usuarios u on t.id_usuario = u.id_usuario
                INNER join prioridad_ticket p on t.id_prioridad = p.id_prioridad
                WHERE
                t.estado = 1
                AND t.id_ticket = ?";
            }else{
                $sql = "SELECT 
                t.id_ticket AS 'tick_id',
                t.id_usuario AS 'usu_id',
                t.id_categoria AS 'cat_id',
                t.titulo AS 'tick_titulo',
                t.descripcion AS 'tick_descrip',
                t.tick_estado AS 'tick_estado',
                t.fecha_creacion AS 'fech_crea',
                u.nombre AS 'usu_nom',
                u.apellido AS 'usu_ape',
                u.correo AS 'usu_correo',
                c.nombre AS 'cat_nom',
                p.nombre AS 'tick_prioridad',
                are.nombre AS 'area_nom',
                tu.fecha_asignacion AS 'fech_asig',
                ua.id_usuario AS 'asig_id_usuario',
                ua.nombre AS 'asig_nom',
                ua.apellido AS 'asig_ape',
                ua.correo AS 'asig_correo'
                FROM tickets t
                INNER JOIN categorias c ON t.id_categoria = c.id_categoria
                INNER JOIN usuarios u ON t.id_usuario = u.id_usuario -- creador
                INNER JOIN prioridad_ticket p ON t.id_prioridad = p.id_prioridad
                INNER JOIN areas are ON t.id_area = are.id_area
                LEFT JOIN (
                    SELECT tu1.id_ticket, tu1.id_usuario, tu1.fecha_asignacion
                    FROM asignacion_ticket tu1
                    INNER JOIN (
                        SELECT ata.id_ticket, MAX(ata.fecha_asignacion) AS ultima_fecha
                        FROM asignacion_ticket ata
                        GROUP BY ata.id_ticket
                    ) ult
                    ON tu1.id_ticket = ult.id_ticket AND tu1.fecha_asignacion = ult.ultima_fecha
                ) tu ON t.id_ticket = tu.id_ticket
                LEFT JOIN usuarios ua ON tu.id_usuario = ua.id_usuario -- usuario asignado
                WHERE 
                t.estado = 1
                AND t.id_ticket = ?";
            }
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tick_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        //Se usara para mostrar los tickets en el dashboard para los de soporte
        public function listar_ticket($EstadoAsignacion = null, $EstadoTicketAC = null, $prioridad = null){
            $conectar= parent::conexion();
            parent::set_names();
            $sql = "SELECT  t.id_ticket,
                            pt.nombre as 'Prioridad',
                            c.nombre as 'Categoria',
                            t.titulo,
                            t.tick_estado, 
                            are.nombre as 'area',
                            u.nombre as 'usuarioAsignacion',
                            u.apellido as 'apellidoAsignacion',
                            t.fecha_creacion,
                            tu.fecha_asignacion,
                            t.id_usuario as 'creadorIdUsuario',
                            usu.nombre as 'creadorNom',
                            usu.apellido as 'creadorApe'
                    FROM tickets t
                    LEFT JOIN (
                        SELECT tu1.id_ticket, tu1.id_usuario, tu1.fecha_asignacion
                        FROM asignacion_ticket tu1
                        INNER JOIN (
                            SELECT ata.id_ticket, MAX(ata.fecha_asignacion) AS ultima_fecha
                            FROM asignacion_ticket ata
                            GROUP BY ata.id_ticket
                        ) ult
                        ON tu1.id_ticket = ult.id_ticket AND tu1.fecha_asignacion = ult.ultima_fecha
                    ) tu ON t.id_ticket = tu.id_ticket
                    LEFT JOIN usuarios u ON u.id_usuario = tu.id_usuario
                    INNER JOIN usuarios usu ON t.id_usuario = usu.id_usuario
                    INNER JOIN prioridad_ticket pt ON t.id_prioridad = pt.id_prioridad
                    INNER JOIN categorias c ON t.id_categoria = c.id_categoria
                    INNER JOIN areas are ON t.id_area = are.id_area
                    WHERE t.estado = 1";

            if ($EstadoAsignacion != null) {
                if($EstadoAsignacion == "Sin Asignar"){
                    $sql .= " AND tu.id_usuario IS NULL";
                }else{
                    $sql .= " AND tu.id_usuario = $EstadoAsignacion";
                }
            }

            if ($EstadoTicketAC != null) {
                $sql .= " AND t.tick_estado = '$EstadoTicketAC'";
            }

            if ($prioridad != null) {
                $sql .= " AND pt.nombre = '$prioridad'";
            }


            $sql .= " ORDER BY t.id_ticket ASC;";
            
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function listar_ticket_filtro($aten_garantia = null, $EstadoTicketAC = null, $FechaDesde = null, $FechaHasta = null){
            $conectar= parent::conexion();
            parent::set_names();
            $sql = "SELECT  t.id_ticket,
                            pt.nombre as 'Prioridad',
                            c.nombre as 'Categoria',
                            t.titulo,
                            t.tick_estado, 
                            are.nombre as 'area',
                            u.nombre as 'usuarioAsignacion',
                            u.apellido as 'apellidoAsignacion',
                            t.fecha_creacion,
                            tu.fecha_asignacion,
                            t.id_usuario as 'creadorIdUsuario',
                            usu.nombre as 'creadorNom',
                            usu.apellido as 'creadorApe'
                    FROM tickets t
                    LEFT JOIN (
                        SELECT tu1.id_ticket, tu1.id_usuario, tu1.fecha_asignacion
                        FROM asignacion_ticket tu1
                        INNER JOIN (
                            SELECT ata.id_ticket, MAX(ata.fecha_asignacion) AS ultima_fecha
                            FROM asignacion_ticket ata
                            GROUP BY ata.id_ticket
                        ) ult
                        ON tu1.id_ticket = ult.id_ticket AND tu1.fecha_asignacion = ult.ultima_fecha
                    ) tu ON t.id_ticket = tu.id_ticket
                    LEFT JOIN usuarios u ON u.id_usuario = tu.id_usuario
                    INNER JOIN usuarios usu ON t.id_usuario = usu.id_usuario
                    INNER JOIN prioridad_ticket pt ON t.id_prioridad = pt.id_prioridad
                    INNER JOIN categorias c ON t.id_categoria = c.id_categoria
                    INNER JOIN areas are ON t.id_area = are.id_area
                    WHERE t.estado = 1";

            if ($aten_garantia != null) {
                $sql .= " AND u.id_usuario = '$aten_garantia'";
            }

            if ($EstadoTicketAC != null) {
                $sql .= " AND t.tick_estado = '$EstadoTicketAC'";
            }

            if ($FechaDesde != null) {
                $sql .= " AND t.fecha_creacion >= '$FechaDesde'";
            }

            if ($FechaHasta != null) {
                $sql .= " AND t.fecha_creacion <= '$FechaHasta'";
            }


            $sql .= " ORDER BY t.id_ticket ASC;";
            
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        //Se esta utilizando
        public function listar_ticketdetalle_x_ticket($tick_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT
                td.id_detalle,
                td.id_ticket as 'tickd_id',
                td.descripcion as 'tickd_descrip',
                td.fecha as 'fech_crea',
                usu.nombre as 'usu_nom',
                usu.apellido as 'usu_ape',
                usu.id_rol as 'rol_id'
                FROM 
                ticketdetalle td 
                INNER join usuarios usu on td.id_usuario = usu.id_usuario
                WHERE 
                id_ticket = ?
                ORDER BY td.fecha ASC";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tick_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        //Aun no se utiliza pero se planea utilizar en el controlador
        public function listar_ultimo_ticketdetalle($tick_id, $id_detalle){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT
                    td.id_detalle,
                    td.id_ticket as 'tickd_id',
                    td.descripcion as 'tickd_descrip',
                    td.fecha as 'fech_crea',
                    usu.nombre as 'usu_nom',
                    usu.apellido as 'usu_ape',
                    usu.id_rol as 'rol_id'
                  FROM 
                    ticketdetalle td 
                  INNER JOIN usuarios usu ON td.id_usuario = usu.id_usuario
                  WHERE 
                    td.id_ticket = ?
                    AND td.id_detalle > ?  
                  ORDER BY td.id_detalle ASC";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tick_id);
            $sql->bindValue(2, $id_detalle);
            $sql->execute();
            return $resultado=$sql->fetch();
        }



        //Se esta utilizando
        public function insert_ticketdetalle($tick_id,$usu_id,$tickd_descrip){
            $conectar= parent::conexion();
            parent::set_names();
                $sql="INSERT INTO ticketdetalle (id_detalle,id_ticket,id_usuario,descripcion,fecha,estado) VALUES (NULL,?,?,?,now(),'1');";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tick_id);
            $sql->bindValue(2, $usu_id);
            $sql->bindValue(3, $tickd_descrip);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        //Se esta utilizando
        public function insert_ticketdetalle_cerrar($tick_id,$usu_id){
            $conectar= parent::conexion();
            parent::set_names();
                // $sql="call sp_i_ticketdetalle_01(?,?)";
                $sql="INSERT INTO ticketdetalle (id_detalle,id_ticket,id_usuario,descripcion,fecha,estado) VALUES (NULL,?,?,'Ticket cerrado',now(),'1');";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tick_id);
            $sql->bindValue(2, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        //No se utiliza
        public function insert_ticketdetalle_reabrir($tick_id,$usu_id){
            $conectar= parent::conexion();
            parent::set_names();
                $sql="	INSERT INTO td_ticketdetalle 
                    (tickd_id,tick_id,usu_id,tickd_descrip,fech_crea,est) 
                    VALUES 
                    (NULL,?,?,'Ticket Re-Abierto...',now(),'1');";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tick_id);
            $sql->bindValue(2, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        //Se esta utilizando
        public function update_ticket($tick_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="update tickets 
                set	
                    tick_estado = 'Cerrado'
                where
                    id_ticket = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tick_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        //No se utiliza
        public function reabrir_ticket($tick_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="update tm_ticket 
                set	
                    tick_estado = 'Abierto'
                where
                    tick_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tick_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        //Se esta utilizando
        public function Insert_ticket_asignacion($tick_id,$usu_asig){
            $conectar= parent::conexion();
            parent::set_names();
            // $sql="update tickets 
            //     set	
            //         id_usuario_asig = ?,
            //         fecha_asig = now()
            //     where
            //         id_ticket = ?";

            $sql = "INSERT INTO asignacion_ticket (asignacion_id, id_ticket, id_usuario, fecha_asignacion) VALUES (NULL, ?, ?, now());";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tick_id);
            $sql->bindValue(2, $usu_asig);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        //Aun no se utiliza
        public function get_ticket_total(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT COUNT(*) as TOTAL FROM tm_ticket";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        //Aun no se utiliza
        public function get_ticket_totalabierto(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT COUNT(*) as TOTAL FROM tm_ticket where tick_estado='Abierto'";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        //Aun no se utiliza
        public function get_ticket_totalcerrado(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT COUNT(*) as TOTAL FROM tm_ticket where tick_estado='Cerrado'";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        } 

        //Aun no se utiliza
        public function get_ticket_grafico(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT tm_categoria.cat_nom as nom,COUNT(*) AS total
                FROM   tm_ticket  JOIN  
                    tm_categoria ON tm_ticket.cat_id = tm_categoria.cat_id  
                WHERE    
                tm_ticket.est = 1
                GROUP BY 
                tm_categoria.cat_nom 
                ORDER BY total DESC";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        } 

    }
?>