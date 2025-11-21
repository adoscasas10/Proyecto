<?php


class Rol extends Conectar{

    public function get_rol(){
        $conectar= parent::conexion();
        parent::set_names();
        $sql="SELECT * FROM rol";
        $sql=$conectar->prepare($sql);
        $sql->execute();
        return $resultado=$sql->fetchAll();
    }

    public function get_rol_x_id($rol_id){
        $conectar= parent::conexion();
        parent::set_names();
        $sql="SELECT * FROM rol WHERE id_rol = ?";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1, $rol_id);
        $sql->execute();
        return $resultado=$sql->fetchAll();
    }

    public function get_rol_x_nom($rol_nom){
        $conectar= parent::conexion();
        parent::set_names();
        $sql="SELECT * FROM rol WHERE nombre = ?";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1, $rol_nom);
        $sql->execute();
        return $resultado=$sql->fetchAll();
    }
}

?>