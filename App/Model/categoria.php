<?php

class categoria extends Conectar{
    
    //Esto se utiliza en el combobox
    public function obtenerTodo(){
        $conectar= parent::conexion();
        parent::set_names();
        $sql="SELECT * FROM categorias WHERE estado = '1'";
        $sql=$conectar->prepare($sql);
        $sql->execute();
        return $resultado=$sql->fetchAll();
    }

    //Esto se utiliza en ListarCategoria.php para cambiar estado
    public function get_categoria_x_estado($estado){
        $conectar= parent::conexion();
        parent::set_names();
        $sql="SELECT * FROM categorias WHERE estado = ?";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1, $estado);
        $sql->execute();
        return $resultado=$sql->fetchAll();
    }

    //Esto se utiliza en ListarCategoria.php para verificar existencia de codigo
    public function VerificarExistenciaCodigo($codigo){
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT 1 FROM categorias WHERE cod_categoria = ? LIMIT 1";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $codigo);
        $sql->execute();
        return $sql->fetch() ? true : false;
    }
    
    //Esto se utiliza en ListarCategoria.php para mostrar
    public function get_categoria(){
        $conectar= parent::conexion();
        parent::set_names();
        $sql="SELECT * FROM categorias";
        $sql=$conectar->prepare($sql);
        $sql->execute();
        return $resultado=$sql->fetchAll();
    }

    //Esto se utiliza en ListarCategoria.php para cambiar estado
    public function delete_categoria($categoria_id){
        $conectar= parent::conexion();
        parent::set_names();
        $sql="UPDATE categorias SET estado='0' WHERE id_categoria=?";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1, $categoria_id);
        $sql->execute();
        return $resultado=$sql->fetchAll();
    }

    //Esto se utiliza en ListarCategoria.php para actualizar
    public function update_categoria($categoria_id,$categoria_nom,$categoria_des){
        $conectar= parent::conexion();
        parent::set_names();
        $sql="UPDATE categorias SET nombre = ?, descripcion = ? WHERE id_categoria = ?";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1, $categoria_nom);
        $sql->bindValue(2, $categoria_des);
        $sql->bindValue(3, $categoria_id);
        $sql->execute();
        return $resultado=$sql->fetchAll();
    }

    //Esto se utiliza en ListarCategoria.php para insertar
    public function insert_categoria($codigo,$categoria_nom,$descripcion){
        $conectar= parent::conexion();
        parent::set_names();
        $sql="INSERT INTO categorias (cod_categoria, nombre, descripcion, estado) VALUES (?,?, ?, '1')";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1, $codigo);
        $sql->bindValue(2, $categoria_nom);
        $sql->bindValue(3, $descripcion);

        if ($sql->execute()) {
            return $categoria_nom; // ID insertado
        } else {
            return false; // Inserción fallida
        }
    }

    //Esto se utiliza en ListarCategoria.php para mostrar, a la hora de actualizar
    public function get_categoria_x_id($categoria_id){
        $conectar= parent::conexion();
        parent::set_names();
        $sql="SELECT * FROM categorias WHERE id_categoria = ?";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1, $categoria_id);
        $sql->execute();
        return $resultado=$sql->fetch();
    }

    //Esto se utiliza en ListarCategoria.php para mostrar, a la hora de actualizar, para verificar que no se repita el nombre
    public function get_categoria_x_nom($categoria_nom, $id_actual = null){
        $conectar= parent::conexion();
        parent::set_names();
        if ($id_actual === null) {
            $sql="SELECT * FROM categorias WHERE nombre = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $categoria_nom);
        } else {
            $sql="SELECT * FROM categorias WHERE nombre = ? AND id_categoria != ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $categoria_nom);
            $sql->bindValue(2, $id_actual);
        }
        $sql->execute();
        return $resultado=$sql->fetch();
    }

    //Esto se utiliza en ListarCategoria.php para cambiar estado
    public function habilitar_categoria($categoria_id){
        $conectar= parent::conexion();
        parent::set_names();
        $sql="UPDATE categorias SET estado='1' WHERE id_categoria=?";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1, $categoria_id);
        $sql->execute();
        return $resultado=$sql->fetchAll();
    }
}

?>