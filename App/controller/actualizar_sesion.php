<?php
    require_once("../../Config/Config.php");
    require_once("../Model/Usuario.php");


    if(isset($_SESSION["id_usuario"])){
        $usuario = new Usuario();
        $usuario->update_usuario_sesion($_SESSION["id_usuario"]);
        echo "Sesion actualizada correctamente.";
    }

?>