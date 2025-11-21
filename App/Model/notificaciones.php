<?php

class notificaciones extends Conectar{
    
    public function get_notificaciones_id_usuario($id_usuario, $estado = null, $fecha_desde = null, $fecha_hasta = null){
        $conectar = parent::conexion();
        parent::set_names();
        
        $sql = "SELECT * FROM notificacion WHERE id_usuario = ?";
        $params = [$id_usuario];
    
        if ($estado !== null) {
            $sql .= " AND leido = ?";
            $params[] = $estado;
        }
        if ($fecha_desde !== null) {
            $sql .= " AND DATE(fecha) >= ?";
            $params[] = $fecha_desde;
        }
        if ($fecha_hasta !== null) {
            $sql .= " AND DATE(fecha) <= ?";
            $params[] = $fecha_hasta;
        }
    
        $stmt = $conectar->prepare($sql);
    
        // Vincular parámetros en orden
        foreach ($params as $i => $param) {
            $stmt->bindValue($i + 1, $param);
        }
    
        $stmt->execute();
        return $stmt->fetchAll();
    }
    

    public function insert_notificaciones($tick_id, $usu_id){
        $conectar = parent::conexion();
        parent::set_names();
    
        $mensaje = "Un nuevo mensaje ha sido enviado en el ticket T-" . $tick_id;
    
        $sql = "INSERT INTO notificacion 
                (notificacion_id, id_ticket, id_usuario, mensaje, fecha, leido) 
                VALUES (NULL, ?, ?, ?, NOW(), '0')";
        
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $tick_id);
        $stmt->bindValue(2, $usu_id);
        $stmt->bindValue(3, $mensaje);
        
        return $stmt->execute(); // true o false
    }

    public function update_notificaciones($id_notificacion){
        $conectar = parent::conexion();
        parent::set_names();
    
        $sql = "UPDATE notificacion SET leido = '1' WHERE notificacion_id = ?";
        
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id_notificacion);
        
        return $stmt->execute(); // true o false
    }
    

    public function marcarLeido($id_usuario){
        $conectar = parent::conexion();
        parent::set_names();
    
        $sql = "UPDATE notificacion SET leido = '1' WHERE id_usuario = ?";
        
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $id_usuario);
        
        return $stmt->execute(); // true o false
    }

    
}

?>