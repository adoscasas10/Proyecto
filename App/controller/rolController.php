<?php
    require_once("../../Config/Config.php");
    require_once("../Model/Rol.php");

    $rol = new Rol();

    switch($_GET["op"]){
        case "comboRol":
            $datos = $rol->get_rol();
            // echo json_encode($datos);
            if(is_array($datos)==true and count($datos)>0){
                $html = "";
                foreach($datos as $row){
                    $html .= '<option value="'.$row["id_rol"].'">'.$row["nombre"] .'</option>';
                }
                echo $html;
            }
            break;
    }
?>