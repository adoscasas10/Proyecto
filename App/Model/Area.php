<?php

class Area extends Conectar{
    //Esto se utiliza en el combobox
    public function obtenerTodo(){
        $conectar= parent::conexion();
        parent::set_names();
        $sql="SELECT * FROM areas WHERE estado = '1'";
        $sql=$conectar->prepare($sql);
        $sql->execute();
        return $resultado=$sql->fetchAll();
    }

    //Esto se utiliza en ListarArea.php para cambiar estado
    public function get_area_x_estado($estado){
        $conectar= parent::conexion();
        parent::set_names();
        $sql="SELECT * FROM areas WHERE estado = ?";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1, $estado);
        $sql->execute();
        return $resultado=$sql->fetchAll();
    }

    //Esto se utiliza en ListarArea.php para verificar existencia de codigo
    public function VerificarExistenciaCodigo($codigo){
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT 1 FROM areas WHERE codigo = ? LIMIT 1";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $codigo);
        $sql->execute();
        return $sql->fetch() ? true : false;
    }
    
    //Esto se utiliza en ListarArea.php (todas las areas)
    public function get_area(){
        $conectar= parent::conexion();
        parent::set_names();
        $sql="SELECT * FROM areas";
        $sql=$conectar->prepare($sql);
        $sql->execute();
        return $resultado=$sql->fetchAll();
    }

    //Esto se utiliza en ListarArea.php para cambiar estado
    public function delete_area($area_id){
        $conectar= parent::conexion();
        parent::set_names();
        $sql="UPDATE areas SET estado='0' WHERE id_area=?";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1, $area_id);
        $sql->execute();
        return $resultado=$sql->fetchAll();
    }

    //Esto se utiliza en ListarArea.php para cambiar nombre
    public function update_area($area_id,$area_nom){
        $conectar= parent::conexion();
        parent::set_names();
        $sql="UPDATE areas SET nombre = ? WHERE id_area = ?";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1, $area_nom);
        $sql->bindValue(2, $area_id);
        $sql->execute();
        return $resultado=$sql->fetchAll();
    }

    //Esto se utiliza en ListarArea.php para insertar
    public function insert_area($codigo,$area_nom){
        $conectar= parent::conexion();
        parent::set_names();
        $sql="INSERT INTO areas (codigo, nombre, estado) VALUES (?,?, '1')";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1, $codigo);
        $sql->bindValue(2, $area_nom);

        if ($sql->execute()) {
            return $area_nom; // ID insertado
        } else {
            return false; // Inserción fallida
        }
    }

    //Esto se utiliza en ListarArea.php para mostrar, a la hora de actualizar
    public function get_area_x_id($area_id){
        $conectar= parent::conexion();
        parent::set_names();
        $sql="SELECT * FROM areas WHERE id_area = ?";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1, $area_id);
        $sql->execute();
        return $resultado=$sql->fetch();
    }

    //Esto se utiliza en ListarArea.php para mostrar, a la hora de actualizar, para verificar que no se repita el nombre
    public function get_area_x_nom($area_nom, $id_actual = null){
        $conectar= parent::conexion();
        parent::set_names();
        if ($id_actual === null) {
            $sql="SELECT * FROM areas WHERE nombre = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $area_nom);
        } else {
            $sql="SELECT * FROM areas WHERE nombre = ? AND id_area != ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $area_nom);
            $sql->bindValue(2, $id_actual);
        }
        $sql->execute();
        return $resultado=$sql->fetch();
    }

    //Esto se utiliza en ListarArea.php para cambiar estado
    public function habilitar_area($area_id){
        $conectar= parent::conexion();
        parent::set_names();
        $sql="UPDATE areas SET estado='1' WHERE id_area=?";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1, $area_id);
        $sql->execute();
        return $resultado=$sql->fetchAll();
    }
}

?>