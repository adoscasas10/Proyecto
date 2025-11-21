<?php
    require_once("../../Config/Config.php");
    require_once("../Model/categoria.php");

    $categoria = new categoria();

    function generarCodigoUnico($categoria) {
        do {
            // Genera número aleatorio entre 1 y 9999, con ceros a la izquierda
            $numero = str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
            $codigo = 'CAT' . $numero;
        } while ($categoria->VerificarExistenciaCodigo($codigo)); // Repite si ya existe
        return $codigo;
    }

    switch($_GET["op"]){
        case "crearCodigo":
            $codigoNuevo = generarCodigoUnico($categoria);
            echo $codigoNuevo;
            break;
        case "guardaryeditar":

            if($_POST["idCategoria"] == "-1"){
                if(
                    trim($_POST ["nombre"]) != "" &&
                    trim($_POST ["codigo"]) != ""
                ){
                    if($categoria->get_categoria_x_nom($_POST["nombre"]) != false){
                        echo "La Categoria ya Existe, no se puede registrar.";
                    } else{
                        $resultado = $categoria->insert_categoria(
                            $_POST["codigo"],
                            strtoupper($_POST["nombre"]),
                            $_POST["descripcion"]
                        ); 

                        if($resultado === false){
                            echo "Error al insertar la Categoria.";
                        }else {
                            echo "Categoria registrado correctamente: ".$resultado;
                        }
                    }
                } else{
                    echo "Faltan Datos";
                }  
            }else{
                
                $id_categoria = $_POST["idCategoria"];
                $nombre_categoria = $_POST["nombre"];
                $codigo_categoria = $_POST["codigo"];
                $descripcion_categoria = $_POST["descripcion"];

                if($categoria->get_categoria_x_nom($nombre_categoria, $id_categoria)){
                    echo "La Categoria ya Existe, no se puede actualizar.";
                }else{
                    $resultado = $categoria->update_categoria(
                        $id_categoria,
                        $nombre_categoria,
                        $descripcion_categoria);
                    echo "Categoria actualizado correctamente";
                }

            }
            break;
        case "listar":
                $estado = isset($_POST["estadoSistema"]) ? $_POST["estadoSistema"] : "";
                
                if($estado !== ""){
                    $datos = $categoria->get_categoria_x_estado($estado);
                }else{
                    $datos = $categoria->get_categoria();
                }
                
                $data= Array();
                foreach($datos as $row){
                    
                    $sub_array = array();
                    $sub_array[] = $row["cod_categoria"];
                    $sub_array[] = $row["nombre"];
                    $sub_array[] = $row["descripcion"];

                    if($row["estado"]=="1"){
                        $sub_array[] = '<span class="badge bg-success text-black">Habilitado</span>';
                    }else{
                        $sub_array[] = '<span class="badge bg-danger text-black">Deshabilitado</span>';
                    }
                    if($row["cod_categoria"] == "CAT0001"){
                        $sub_array[] = '
                        <div class="btn-group">
                            <span class="btn-group">
                                <button href="#" data-id="'.$row["cod_categoria"].'" onclick="ver(\''.$row["cod_categoria"].'\', \''.$row["nombre"].'\');" class="btn btn-primary btn-sm"><i class="fa-solid fa-eye"></i></button>                    
                            </span>
                        </div>';
                    }else{
                        if($row["estado"]=="1"){
                            $sub_array[] = '
                            <div class="btn-group">
                                <span class="btn-group">
                                    <button href="#" data-id="'.$row["id_categoria"].'" onclick="editar('.$row["id_categoria"].');" class="btn btn-warning btn-sm btnEditar"><i class="fa-solid fa-pen-to-square"></i></button>                    
                                </span>
                                <span class="btn-group">
                                    <button href="#" data-id="'.$row["id_categoria"].'" onclick="eliminar('.$row["id_categoria"].');" class="btn btn-danger btn-sm btnEliminar"><i class="fa-solid fa-trash"></i></button>
                                </span>
                                <span class="btn-group">
                                    <button href="#" data-id="'.$row["cod_categoria"].'" onclick="ver(\''.$row["cod_categoria"].'\', \''.$row["nombre"].'\');" class="btn btn-primary btn-sm"><i class="fa-solid fa-eye"></i></button>   
                                </span>
                            </div>';
                        }else{
                            $sub_array[] = '
                            <div class="btn-group">
                                <span class="btn-group">
                                    <button href="#" data-id="'.$row["id_categoria"].'" onclick="habilitar('.$row["id_categoria"].');" class="btn btn-success btn-sm btnHabilitar"><i class="fa-solid fa-clipboard-list"></i></button>                    
                                </span>
                                <span class="btn-group">
                                    <button href="#" data-id="'.$row["cod_categoria"].'" onclick="ver(\''.$row["cod_categoria"].'\', \''.$row["nombre"].'\');" class="btn btn-primary btn-sm"><i class="fa-solid fa-eye"></i></button>   
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
            $datos=$categoria->get_categoria_x_id($_POST["id"]);
            echo json_encode($datos);
            break;
        case "comboCategoria":
            $datos=$categoria->obtenerTodo();
            if(is_array($datos)==true and count($datos)>0){
                $html = "";
                foreach($datos as $row){
                    $html .= '<option value="'.$row["id_categoria"].'">'.$row["nombre"] .'</option>';
                }
                echo $html;
            }
            break;
        case "eliminar":
            $categoria->delete_categoria($_POST["categoria_id"]);
            break;
        case "habilitar":
            $categoria->habilitar_categoria($_POST["categoria_id"]);
            break;
        case "comboCategoria":
            $datos=$categoria->obtenerTodo();
            if(is_array($datos)==true and count($datos)>0){
                $html = "";
                foreach($datos as $row){
                    $html .= '<option value="'.$row["id_categoria"].'">'.$row["nombre"] .'</option>';
                }
                echo $html;
            }
            break;
    }
?>