<?php
    require_once("../../Config/Config.php");
    require_once("../Model/Area.php");

    $area = new Area();

    function generarCodigoUnico($area) {
        do {
            // Genera número aleatorio entre 1 y 9999, con ceros a la izquierda
            $numero = str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
            $codigo = 'A' . $numero;
        } while ($area->VerificarExistenciaCodigo($codigo)); // Repite si ya existe
        return $codigo;
    }

    switch($_GET["op"]){
        case "crearCodigo":
            $codigoNuevo = generarCodigoUnico($area);
            echo $codigoNuevo;
            break;
        case "guardaryeditar":

            if($_POST["idArea"] == "-1"){
                if(
                    trim($_POST ["nombreArea"]) != "" &&
                    trim($_POST ["codigoArea"]) != ""
                ){
                    if($area->get_area_x_nom($_POST["nombreArea"]) != false){
                        echo "El Area ya Existe, no se puede registrar.";
                    } else{
                        $resultado = $area->insert_area(
                            $_POST["codigoArea"],
                            $_POST["nombreArea"]
                        ); 

                        if($resultado === false){
                            echo "Error al insertar el Area.";
                        }else {
                            echo "Area registrado correctamente: ".$resultado;
                        }
                    }
                } else{
                    echo "Faltan Datos";
                }  
            }else{
                
                $id_area = $_POST["idArea"];
                $nombre_area = $_POST["nombreArea"];
                $codigo_area = $_POST["codigoArea"];

                if($area->get_area_x_nom($nombre_area, $id_area)){
                    echo "El Area ya Existe, no se puede actualizar.";
                }else{
                    $resultado = $area->update_area(
                        $id_area,
                        $nombre_area);
                    echo "Area actualizado correctamente";
                }

            }
            break;
        case "listar":
                $estado = isset($_POST["estadoSistema"]) ? $_POST["estadoSistema"] : "";
                
                if($estado !== ""){
                    $datos = $area->get_area_x_estado($estado);
                }else{
                    $datos = $area->get_area();
                }
                
                $data= Array();
                foreach($datos as $row){
                    
                    $sub_array = array();
                    $sub_array[] = $row["codigo"];
                    $sub_array[] = $row["nombre"];

                    if($row["estado"]=="1"){
                        $sub_array[] = '<span class="badge bg-success text-black">Habilitado</span>';
                    }else{
                        $sub_array[] = '<span class="badge bg-danger text-black">Deshabilitado</span>';
                    }
                    if($row["codigo"] == "A0001"){
                        $sub_array[] = '
                        <div class="btn-group">
                            <span class="btn-group">
                                <button href="#" data-id="'.$row["codigo"].'" onclick="ver(\''.$row["codigo"].'\', \''.$row["nombre"].'\');" class="btn btn-primary btn-sm"><i class="fa-solid fa-eye"></i></button>                    
                            </span>
                        </div>';
                    }else{
                        if($row["estado"]=="1"){
                            $sub_array[] = '
                            <div class="btn-group">
                                <span class="btn-group">
                                    <button href="#" data-id="'.$row["id_area"].'" onclick="editar('.$row["id_area"].');" class="btn btn-warning btn-sm btnEditar"><i class="fa-solid fa-pen-to-square"></i></button>                    
                                </span>
                                <span class="btn-group">
                                    <button href="#" data-id="'.$row["id_area"].'" onclick="eliminar('.$row["id_area"].');" class="btn btn-danger btn-sm btnEliminar"><i class="fa-solid fa-trash"></i></button>
                                </span>
                            </div>';
                        }else{
                            $sub_array[] = '
                            <div class="btn-group">
                                <span class="btn-group">
                                    <button href="#" data-id="'.$row["id_area"].'" onclick="habilitar('.$row["id_area"].');" class="btn btn-success btn-sm btnHabilitar"><i class="fa-solid fa-clipboard-list"></i></button>                    
                                </span>
                            </div>';
                        }
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
        case "mostrar":
            $datos=$area->get_area_x_id($_POST["id"]);
            echo json_encode($datos);
            break;
        case "comboArea":
            $datos=$area->obtenerTodo();
            if(is_array($datos)==true and count($datos)>0){
                $html = "";
                foreach($datos as $row){
                    $html .= '<option value="'.$row["id_area"].'">'.$row["nombre"] .'</option>';
                }
                echo $html;
            }
            break;
        case "eliminar":
            $area->delete_area($_POST["area_id"]);
            break;
        case "habilitar":
            $area->habilitar_area($_POST["area_id"]);
            break;
    }
?>