<?php
    class Documento extends Conectar{
        public function insert_documento($tick_id,$doc_nom){
            $conectar= parent::conexion();
            /* consulta sql */
            $sql="INSERT INTO documento (id_documento,id_ticket,doc_nombre,fecha_creacion,estado) VALUES (null,?,?,now(),1);";
            $sql = $conectar->prepare($sql);
            $sql->bindParam(1,$tick_id);
            $sql->bindParam(2,$doc_nom);
            $sql->execute();
        }

        public function get_documento_x_ticket($tick_id){
            $conectar= parent::conexion();
            /* consulta sql */
            $sql="SELECT * FROM documento WHERE id_ticket=?";
            $sql = $conectar->prepare($sql);
            $sql->bindParam(1,$tick_id);
            $sql->execute();
            return $resultado = $sql->fetchAll(pdo::FETCH_ASSOC);
        }
    }
?>