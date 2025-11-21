<?php
    class Nota extends Conectar{
        //Se esta utilizando en el controlador en ticketController  
        public function insert_nota($tick_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="INSERT INTO notas (id_nota, id_ticket, fecha_creacion, estado) VALUES (?, ?, now(), '1');";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tick_id);
            $sql->bindValue(2, $tick_id);
            
            $sql->execute();
            return $resultado=$sql->fetchAll(pdo::FETCH_ASSOC);
        }

        //Se esta utilizando
        public function listar_ticketdetalle_x_ticket($tick_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT
                td.id_detalle,
                td.id_nota as 'tickd_id',
                td.comentario as 'tickd_descrip',
                td.fecha_comentario as 'fech_crea',
                usu.nombre as 'usu_nom',
                usu.apellido as 'usu_ape',
                usu.id_rol as 'rol_id'
                FROM 
                detalle_notas td 
                INNER join usuarios usu on td.id_usuario = usu.id_usuario
                WHERE 
                id_nota = ?
                ORDER BY td.fecha_comentario ASC";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tick_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        //Se esta utilizando
        public function insert_ticketdetalle($tick_id,$usu_id,$tickd_descrip){
            $conectar= parent::conexion();
            parent::set_names();
                $sql="INSERT INTO detalle_notas (id_detalle,id_nota,id_usuario,comentario,fecha_comentario,estado) VALUES (NULL,?,?,?,now(),'1');";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tick_id);
            $sql->bindValue(2, $usu_id);
            $sql->bindValue(3, $tickd_descrip);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

    }
?>