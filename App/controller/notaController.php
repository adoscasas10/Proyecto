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



    switch($_GET["op"]){

        //Se esta utilizando en ticketController
        case "mostrar";
            $datos=$ticket->listar_ticket_x_id($_POST["tick_id"]);  
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
                }
                echo json_encode($output);
            }   
        break;

        //Se esta utilizando
        case "insertdetalle":
            $nota->Insert_ticketdetalle($_POST["tick_id"],$_POST["usu_id"],$_POST["tickd_descrip"]);
        break;

        //Se esta utilizando
        case "listardetalle":
            $datos=$nota->listar_ticketdetalle_x_ticket($_POST["tick_id"]);
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
        
    }

?>