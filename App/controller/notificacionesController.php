<?php
    require_once("../../Config/Config.php");
    require_once("../Model/notificaciones.php");

    $notificaciones = new notificaciones();


    switch($_GET["op"]){
        case "listar":

            $estado = (!empty($_POST["estado"]) && $_POST["estado"] !== "null") ? $_POST["estado"] : null;
            $fecha_desde = (!empty($_POST["fecha_desde"]) && $_POST["fecha_desde"] !== "null") ? $_POST["fecha_desde"] : null;
            $fecha_hasta = (!empty($_POST["fecha_hasta"]) && $_POST["fecha_hasta"] !== "null") ? $_POST["fecha_hasta"] : null;
                        

            $datos = $notificaciones->get_notificaciones_id_usuario($_POST["id_usuario"], $estado, $fecha_desde, $fecha_hasta);
            
            
            //creamos un array
            $data = Array();

            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["fecha"] ;
                $sub_array[] = "T-".$row["id_ticket"] ;
                $sub_array[] = $row["mensaje"] ;

                if($row["leido"] == 1){
                    $sub_array[] = '<a target="_blank" href="./../Tickets/detalleTickets.php?idTicket='.$row['id_ticket'].'" class="btn btn-primary btn-sm"><i class="fa-solid fa-bell"></i></a> <span class="badge bg-success text-black">Leido</span>';
                }else{
                    $sub_array[] = '<a target="_blank" onclick="updateNotificacion('.$row['notificacion_id'].','.$row['id_ticket'].')" class="btn btn-primary btn-sm"><i class="fa-solid fa-bell"></i></a> <span class="badge bg-danger text-black">No Leido</span>';
                }

                $data[] = $sub_array;
            }
            
            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);

        break;

        case "insert":
            $datos=$notificaciones->insert_notificaciones($_POST["tick_id"],$_POST["usu_id"]);
            echo json_encode($datos);
        break;

        case "update":
            $datos=$notificaciones->update_notificaciones($_POST["id_notificacion"]);
            echo json_encode($datos);
        break;

        case "marcarLeido":
            $datos=$notificaciones->marcarLeido($_POST["id_usuario"]);
            echo json_encode($datos);
        break;
    }
?>