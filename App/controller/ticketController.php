<?php
    require_once("../../Config/Config.php");
    require_once("../Model/ticket.php");
    $ticket = new ticket();

    require_once("../Model/Usuario.php");
    $usuario = new Usuario();

    require_once("../Model/Documento.php");
    $documento = new Documento();
    
    require_once("../Model/Nota.php");
    $nota = new Nota();


    function numero($numero){
        if ($numero<10){
            $numero="0".$numero;
        }
        return $numero;
    }

    switch($_GET["op"]){

        case "listar_tecnico":
            $datos=$ticket->listar_tecnico();
            echo json_encode($datos);
            break;

        case "insert":
            $datos=$ticket->insert_ticket($_POST["usu_id"],$_POST["area_id"],$_POST["id_categoria"],$_POST["tick_prioridad"],$_POST["tick_titulo"],$_POST["tick_descrip"]);
            if (is_array($datos)==true and count($datos)>0){
                //Entonces asi mismo se creqra una nota del ticket
                
                $nota->insert_nota($datos[0]["tick_id"]);

                foreach ($datos as $row){
                    $output["tick_id"] = $row["tick_id"];

                    if (empty($_FILES['files']['name'][0])){

                    }else{
                        $countfiles = count($_FILES['files']['name']);
                        $ruta = "./../../Public/document/".$output["tick_id"]."/";
                        $files_arr = array();

                        if (!file_exists($ruta)) {
                            mkdir($ruta, 0777, true);
                        }

                        for ($index = 0; $index < $countfiles; $index++) {
                            $doc1 = $_FILES['files']['tmp_name'][$index];
                            $destino = $ruta.$_FILES['files']   ['name'][$index];

                            $documento->insert_documento( $output["tick_id"],$_FILES['files']['name'][$index]);

                            move_uploaded_file($doc1,$destino);
                        }
                    }
                }
            }
            echo json_encode($datos);
        break;

        //Esta si se utiliza para buscar persona
        case "buscar_persona":
            $query = $_POST["query"];
            $id_rol = $_POST["id_rol"];
            $datos = $usuario->buscar_persona($query, $id_rol);
            if($datos > 0){
                foreach($datos as $row){
                    echo "<div class='list-group-item list-group-item-action opcion' data-id='".$row['usu_id']."'>".$row['persona']." - ".$row['dni']."</div>";
                }
            }else{
                echo "<div class='list-group-item list-group-item-action opcion' data-id='0'>Sin resultados</div>";
            }
        break;

        case "listarMenuPrincipal":
            $datos=$ticket->listarMenuPrincipal($_POST["usu_id"]);
            
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                
                $sub_array[] = "T".numero($row["id_ticket"]);
                
                $sub_array[] = $row["titulo"];

                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fecha_creacion"]));

                if ($row["tick_estado"]=="Abierto"){
                    $sub_array[] = '<span class="badge bg-success label label-pill label-success text-white">Abierto</span>';
                }else{
                    $sub_array[] = '<span class="badge bg-danger label label-pill label-danger text-white">Cerrado</span>';
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

        //Esta aun no se utiliza
        case "listar_x_usu":

            $EstadoTicketAC = isset($_POST["EstadoTicketAC"]) ? $_POST["EstadoTicketAC"] : null;
            $Prioridad = isset($_POST["Prioridad"]) ? $_POST["Prioridad"] : null;

            
            $datos=$ticket->listar_ticket_x_usu($_POST["usu_id"], $EstadoTicketAC, $Prioridad);

            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                
                $sub_array[] = "T".numero($row["id_ticket"]);

                if($row["Prioridad"]=="Alta"){
                    $sub_array[] = '<span class="badge bg-danger label label-pill label-danger text-white">Alta</span>';
                }else{
                    if($row["Prioridad"]=="Media"){
                        $sub_array[] = '<span class="badge bg-warning label label-pill label-warning text-black">Media</span>';
                    }else{
                        if($row["Prioridad"]=="Baja"){
                            $sub_array[] = '<span class="badge bg-success label label-pill label-success text-white">Baja</span>';
                        }else{
                            $sub_array[] = '<span class="badge bg-default label label-pill label-default text-white">Sin Asignar</span>';
                        }
                    }
                }
                $sub_array[] = $row["Categoria"];
                $sub_array[] = $row["titulo"];

                if ($row["tick_estado"]=="Abierto"){
                    $sub_array[] = '<span class="badge bg-success label label-pill label-success text-white">Abierto</span>';
                }else{
                    $sub_array[] = '<span class="badge bg-danger label label-pill label-danger text-white">Cerrado</span>';
                }

                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fecha_creacion"]));

                if($row["fecha_asignacion"]==null){
                    $sub_array[] = '<span class="badge bg-warning label label-pill label-default text-black">Sin Asignar</span>';
                }else{
                    $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fecha_asignacion"]));
                }

                if($row["usuarioAsignacion"]==null){
                    $sub_array[] = '<span class="badge bg-warning label label-pill label-warning text-black">Sin Asignar</span>';
                }else{
                    $sub_array[] = '<span class="label label-pill label-success">'. $row["usuarioAsignacion"]." ". $row["apellidoAsignacion"].'</span>';
                }


                

                $sub_array[] = $row["creadorNom"]." ". $row["creadorApe"];

                $sub_array[] = '<div class="btn-group">
                                    <span class="btn-group">
                                        <a target="_blank" data-id="'.$row["id_ticket"].'" onclick="verTicketDetalles('.$row["id_ticket"].');" class="btn btn-primary btn-sm"><i class="fa-solid fa-eye"></i></a>     
                                    </span>
                                </div>';

                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
        break;

        //Esta si se utiliza para listar todo
        case "listar":

            $EstadoAsignacion = isset($_POST["EstadoAsignacion"]) ? $_POST["EstadoAsignacion"] : null;
            $EstadoTicketAC = isset($_POST["EstadoTicketAC"]) ? $_POST["EstadoTicketAC"] : null;
            $Prioridad = isset($_POST["Prioridad"]) ? $_POST["Prioridad"] : null;



            $datos=$ticket->listar_ticket($EstadoAsignacion, $EstadoTicketAC, $Prioridad);
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                
                $sub_array[] = "T".numero($row["id_ticket"]);

                if($row["Prioridad"]=="Alta"){
                    $sub_array[] = '<span class="badge bg-danger label label-pill label-danger text-white">Alta</span>';
                }else{
                    if($row["Prioridad"]=="Media"){
                        $sub_array[] = '<span class="badge bg-warning label label-pill label-warning text-black">Media</span>';
                    }else{
                        if($row["Prioridad"]=="Baja"){
                            $sub_array[] = '<span class="badge bg-success label label-pill label-success text-white">Baja</span>';
                        }else{
                            $sub_array[] = '<span class="badge bg-default label label-pill label-default text-white">Sin Asignar</span>';
                        }
                    }
                }
                $sub_array[] = $row["Categoria"];
                $sub_array[] = $row["titulo"];

                if ($row["tick_estado"]=="Abierto"){
                    $sub_array[] = '<span class="badge bg-success label label-pill label-success text-white">Abierto</span>';
                }else{
                    // $sub_array[] = '<a onClick="CambiarEstado('.$row["tick_id"].')"><span class="label label-pill label-danger">Cerrado</span><a>';
                    $sub_array[] = '<span class="badge bg-danger label label-pill label-danger text-white">Cerrado</span>';
                }

                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fecha_creacion"]));

                if($row["fecha_asignacion"]==null){
                    $sub_array[] = '<span class="badge bg-warning label label-pill label-default text-black">Sin Asignar</span>';
                }else{
                    $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fecha_asignacion"]));
                }

                if($row["usuarioAsignacion"]==null){
                    $sub_array[] = '<a onClick="asignar('.$row["id_ticket"].');"><span class="badge bg-warning label label-pill label-warning text-black">Sin Asignar</span></a>';
                }else{
                    // $datos1=$usuario->get_usuario_x_id($row["usu_asig"]);
                    // foreach($datos1 as $row1){
                    //     $sub_array[] = '<span class="label label-pill label-success">'. $row1["usu_nom"].'</span>';
                    // }
                    $sub_array[] = '<span class="label label-pill label-success">'. $row["usuarioAsignacion"]." ". $row["apellidoAsignacion"].'</span>';
                }


                

                $sub_array[] = $row["creadorNom"]." ". $row["creadorApe"];


                // $sub_array[] = '<button type="button" onClick="ver('.$row["id_ticket"].');"  id="'.$row["id_ticket"].'" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';

                $sub_array[] = '<div class="btn-group">
                                    <span class="btn-group">
                                        <a data-id="'.$row["id_ticket"].'" onclick="verTicketDetalles('.$row["id_ticket"].');" class="btn btn-primary btn-sm"><i class="fa-solid fa-eye"></i></a>     
                                    </span>
                                    <span class="btn-group">
                                        <a data-id="'.$row["id_ticket"].'" onclick="verTicketNotas('.$row["id_ticket"].');" class="btn btn-warning btn-sm"><i class="fa-solid fa-note-sticky"></i></a>     
                                    </span>
                                </div>';

                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
        break;

        case "listarReporte":

            $aten_garantia = isset($_POST["aten_garantia"]) && $_POST["aten_garantia"] !== "0" ? $_POST["aten_garantia"] : null;

            
            $EstadoTicketAC = isset($_POST["EstadoTicketAC"]) ? $_POST["EstadoTicketAC"] : null;

            $FechaDesde = (!empty($_POST["FechaDesde"]) && $_POST["FechaDesde"] !== "null") ? $_POST["FechaDesde"] : null;
            $FechaHasta = (!empty($_POST["FechaHasta"]) && $_POST["FechaHasta"] !== "null") ? $_POST["FechaHasta"] : null;



            $datos=$ticket->listar_ticket_filtro($aten_garantia, $EstadoTicketAC, $FechaDesde, $FechaHasta);
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                
                $sub_array[] = "T".numero($row["id_ticket"]);

                $sub_array[] = $row["creadorNom"]." ". $row["creadorApe"];

                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fecha_creacion"]));

                if ($row["tick_estado"]=="Abierto"){
                    $sub_array[] = '<span class="badge bg-success label label-pill label-success text-white">Abierto</span>';
                }else{
                    // $sub_array[] = '<a onClick="CambiarEstado('.$row["tick_id"].')"><span class="label label-pill label-danger">Cerrado</span><a>';
                    $sub_array[] = '<span class="badge bg-danger label label-pill label-danger text-white">Cerrado</span>';
                }

                if($row["Prioridad"]=="Alta"){
                    $sub_array[] = '<span class="badge bg-danger label label-pill label-danger text-white">Alta</span>';
                }else{
                    if($row["Prioridad"]=="Media"){
                        $sub_array[] = '<span class="badge bg-warning label label-pill label-warning text-black">Media</span>';
                    }else{
                        if($row["Prioridad"]=="Baja"){
                            $sub_array[] = '<span class="badge bg-success label label-pill label-success text-white">Baja</span>';
                        }else{
                            $sub_array[] = '<span class="badge bg-default label label-pill label-default text-white">Sin Asignar</span>';
                        }
                    }
                }


                if($row["usuarioAsignacion"]==null){
                    $sub_array[] = '<span class="badge bg-warning label label-pill label-warning text-black">Sin Asignar</span>';
                }else{
                    // $datos1=$usuario->get_usuario_x_id($row["usu_asig"]);
                    // foreach($datos1 as $row1){
                    //     $sub_array[] = '<span class="label label-pill label-success">'. $row1["usu_nom"].'</span>';
                    // }
                    $sub_array[] = '<span class="label label-pill label-success">'. $row["usuarioAsignacion"]." ". $row["apellidoAsignacion"].'</span>';
                }


                $sub_array[] = $row["titulo"];

                // $sub_array[] = $row["Categoria"];


                

                


                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
        break;

        //Si se utiliza para asignar un ticket
        case "asignar":
            if($_POST["usu_id"]>0){
                $ticket->Insert_ticket_asignacion($_POST["tick_id"],$_POST["usu_id"]);
            }else{
                $ticket->Insert_ticket_asignacion($_POST["tick_id"],$_POST["usu_Actual"]);
            }
            echo json_encode($datos);
        break;

            
        //Se esta utilizando en ticketController
        case "mostrar";
            $datos=$ticket->listar_ticket_x_id($_POST["tick_id"], 2);

            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["tick_id"] = $row["tick_id"];
                    $output["usu_id"] = $row["usu_id"];
                    $output["cat_id"] = $row["cat_id"];
                    $output["tick_prioridad"] = $row["tick_prioridad"];

                    $output["tick_titulo"] = $row["tick_titulo"];
                    $output["tick_descrip"] = $row["tick_descrip"];

                    if ($row["tick_estado"]=="Abierto"){
                        $output["tick_estado"] = '<span class="label label-pill label-success">Abierto</span>';
                    }else{
                        $output["tick_estado"] = '<span class="label label-pill label-danger">Cerrado</span>';
                    }

                    $output["tick_estado_texto"] = $row["tick_estado"];

                    $output["fech_crea"] = date("d/m/Y H:i:s", strtotime($row["fech_crea"]));
                    $output["usu_nom"] = $row["usu_nom"];
                    $output["usu_ape"] = $row["usu_ape"];
                    $output["cat_nom"] = $row["cat_nom"];

                    
                    $output["area_nom"] = $row["area_nom"];
                    $output["asig_nom"] = $row["asig_nom"];
                    $output["asig_ape"] = $row["asig_ape"];
                    $output["asig_correo"] = $row["asig_correo"];
                    $output["id_asig"] = $row["asig_id_usuario"];
                }
                echo json_encode($output);
            } else {
                echo json_encode(0);
            }  
        break;

        //Se esta utilizando
        case "insertdetalle":
            $ticket->Insert_ticketdetalle($_POST["tick_id"],$_POST["usu_id"],$_POST["tickd_descrip"]);
        break;

        //Se esta utilizando
        case "listardetalle":
            $datos=$ticket->listar_ticketdetalle_x_ticket($_POST["tick_id"]);
            ?>
                <?php
                if(is_array($datos)==true and count($datos)>0){
                    foreach($datos as $row){
                        ?>
                            <div class="card mb-3">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <img src="../../../Public/<?php echo $row['rol_id'] ?>.jpg" 
                                            alt="" class="rounded-circle me-2" width="40" height="40">
                                        <div>
                                            <div class="fw-bold">
                                                <?php echo $row['usu_nom'].' '.$row['usu_ape'];?>
                                            </div>
                                            <small class="text-muted">
                                                <?php 
                                                    if ($row['rol_id']==1 || $row['rol_id']==2){
                                                        echo 'Soporte';
                                                    }else{
                                                        echo 'Usuario';
                                                    }
                                                ?>
                                            </small>
                                        </div>
                                    </div>
                                    <small class="text-muted">
                                        <?php echo date("d/m/Y H:i:s", strtotime($row["fech_crea"]));?>
                                    </small>
                                </div>
                                <div class="card-body mensaje" data-id="<?php echo $row['id_detalle'];?>">
                                    <p class="mb-0">
                                        <?php echo $row["tickd_descrip"];?>
                                    </p>
                                </div>
                            </div>

                        <?php
                    }
                }else{
                    ?>
                         <span class="badge bg-warning text-black p-2 m-1">SIN CONVERSACIÓN</span> POR EL MOMENTO
                    <?php
                }
        break;

        //se va a utilizar para cerrar el ticket
        case "update":
            $ticket->update_ticket($_POST["tick_id"]);
            $ticket->insert_ticketdetalle_cerrar($_POST["tick_id"],$_POST["usu_id"]);
        break;

        //Se esta utilizando
        case "listardetalleNuevos":
            $datos=$ticket->listar_ultimo_ticketdetalle($_POST["tick_id"], $_POST["id_detalle"]);
            $array = array();
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row){
                    $array["usu_nom"] = $row['usu_nom'];
                    $array["usu_ape"] = $row['usu_ape'];
                    $array["rol_id"] = $row['rol_id'];
                    $array["tickd_descrip"] = $row['tickd_descrip'];
                    $array["fech_crea"] = $row['fech_crea'];
                }
                echo json_encode($array);
            }else{
                    echo 0;
                }
                ?>
            <?php
        break;
        
    }

?>