<?php
    require_once("../../Config/Config.php");
    require_once("../Model/Usuario.php");
    $usuario = new Usuario();

    switch($_GET["op"]){ 
        case "obtenerCorreoDatos":
            if(isset($_POST["correo"])){
                $correo = $_POST["correo"];
                $data = $usuario->obtenerCorreoDatos($correo);
                echo json_encode($data);
            }else{
                echo "Error: Faltan datos.";
            }
            break;
        case "ActualizarEstadoVerificacion":
            if(isset($_POST["usu_id"])){
                $usu_id = $_POST["usu_id"];
                $usuario->update_usuario_estado($usu_id, 1);
                echo "Usuario actualizado correctamente.";
            }else{
                echo "Error: Faltan datos.";
            }
            break;
        case "recuperar_contraseña":
            $usu_id = $_POST["usu_id"];
            $contrasena = $_POST["contra"];
            $confirmar_contra = $_POST["Confirmar_contra"];

            if(TRIM($contrasena)==="" || TRIM($confirmar_contra)=== ""){
                echo "Error: Faltan datos.";
            } if($contrasena !== $confirmar_contra) {
                echo "Error: La contraseña nueva y la confirmación no coinciden.";
            } else {
                // Si todo está bien, proceder con la actualización
                $usuario->update_usuario_pass($usu_id, $contrasena);
                echo "Contraseña actualizada correctamente.";
            }
            break;

        case "cambiar_contraseña":
            
            //vamos a validar cosas

            $usu_id = $_POST["usu_id"];
            $currentPassword = $_POST["currentPassword"];
            $newPassword = $_POST["newPassword"];
            $confirmPassword = $_POST["confirmPassword"];
            $contrasena = "";

            //obtendremos la contraseña del usuario
            $data = $usuario->get_usuario_x_id($usu_id);
            $contrasena = $data["contrasena"];

            if(TRIM($currentPassword)==="" || TRIM($newPassword)=== "" || TRIM($confirmPassword)=== ""){
                echo "Error: Faltan datos.";
            } if(MD5($currentPassword) !== $contrasena){
                echo "Error: La contraseña actual no coincide.";
            }else if ($newPassword !== $confirmPassword) {
                echo "Error: La contraseña nueva y la confirmación no coinciden.";
            } else if (MD5($newPassword) === $contrasena) {
                echo "Error: La contraseña actual y la nueva son iguales.";
            } else {
                // Si todo está bien, proceder con la actualización
                $usuario->update_usuario_pass($usu_id, $newPassword);
                echo "Contraseña actualizada correctamente.";
            }

            break;
            
            case "Mostrar_Usuario":
                if(isset($_POST["usu_id"])){
                    $usu_id = $_POST["usu_id"];
                    $data = $usuario->get_usuario_x_id($usu_id);
                    echo json_encode($data);
                }
            break;
            
            case "Contar_Tickets":
                if(isset($_POST["usu_id"])){
                    $usu_id = $_POST["usu_id"];
                    $total = $usuario->Contar_Tickets_Totales($usu_id);
                    $cerrados = $usuario->Contar_Tickets_Cerrados($usu_id);
                    echo json_encode(array("total" => $total, "cerrados" => $cerrados));
                }
            break;

            case "guardardatos":
            if ($_POST["usu_id"] != "-1") {
                $usu_id = $_POST["usu_id"];
                $usuario_nuevo = $_POST["usuario"];
                $correo_nuevo = $_POST["correo"];
            
                // Verificación
                if ($usuario->get_usuario_x_usuario($usuario_nuevo, $usu_id)) {
                    echo "El nombre de usuario ya Existe";
                } else if ($usuario->get_usuario_x_correo($correo_nuevo, $usu_id)) {
                    echo "El correo ya Existe";
                } else {
                    // Si no hay duplicados, proceder con la actualización
                    $usuario->update_usuario_datos(
                        $_POST["usu_id"],
                        $_POST["nombre"],
                        $_POST["apellido"],
                        $_POST["correo"],
                        $_POST["usuario"],
                        $_POST["telefono"],
                    );

                    echo "Datos actualizados correctamente.";
                }

            }
            break;
        case "guardaryeditar":
            if ($_POST["usu_id"] == "-1") {
                if (
                    trim($_POST["nombre"]) != "" &&
                    trim($_POST["apellido"]) != "" &&
                    trim($_POST["usuario"]) != "" &&
                    trim($_POST["dni"]) != "" &&
                    trim($_POST["correo"]) != "" &&
                    trim($_POST["telefono"]) != "" &&
                    trim($_POST["area"]) != "" &&
                    trim($_POST["rol"]) != "" &&
                    trim($_POST["password"]) != ""
                ) {
                    //Vamos a validar que el usuario no se haya registrado
                    
                    if ($usuario->get_usuario_x_usuario($_POST["usuario"]) != false) {
                        echo "El usuario ya Existe, no se puede registrar.";
                    } else if ($usuario->get_usuario_x_correo($_POST["correo"]) != false) {
                        echo "El correo ya Existe, no se puede registrar.";
                    } else if ($usuario->get_usuario_x_dni($_POST["dni"]) != false) {
                        echo "El DNI ya Existe, no se puede registrar.";
                    } else {
                        $resultado = $usuario->insert_usuario(
                            $_POST["nombre"],
                            $_POST["apellido"],
                            $_POST["usuario"],
                            $_POST["dni"],
                            $_POST["correo"],
                            $_POST["telefono"],
                            $_POST["area"],
                            $_POST["rol"],
                            $_POST["password"]
                        );
                        if ($resultado === false) {
                            echo "Error al insertar el usuario.";
                        }else {
                            echo $resultado;
                        }
                    }
                } else {
                    echo "Faltan datos.";
                }
            } else {
                // Verificar duplicados excluyendo al propio usuario
                $usu_id = $_POST["usu_id"];
                $usuario_nuevo = $_POST["usuario"];
                $correo_nuevo = $_POST["correo"];
                $dni_nuevo = $_POST["dni"];
            
                // Verificación
                if ($usuario->get_usuario_x_usuario($usuario_nuevo, $usu_id)) {
                    echo "El nombre de usuario ya existe.";
                } else if ($usuario->get_usuario_x_correo($correo_nuevo, $usu_id)) {
                    echo "El correo ya existe.";
                } else if ($usuario->get_usuario_x_dni($dni_nuevo, $usu_id)) {
                    echo "El DNI ya existe.";
                } else {
                    // Si no hay duplicados, proceder con la actualización
                    $usuario->update_usuario(
                        $_POST["usu_id"],
                        $_POST["dni"],
                        $_POST["nombre"],
                        $_POST["apellido"],
                        $_POST["correo"],
                        $_POST["usuario"],
                        $_POST["rol"],
                        $_POST["telefono"],
                        $_POST["area"]
                    );
            
                    echo "Actualizado correctamente.";
                }
            }
            
            break;
        
        case "listar":

            $estado = isset($_POST["estadoSistema"]) ? $_POST["estadoSistema"] : "";

            // Si no está vacío, filtra; si está vacío, trae todo
            if ($estado !== "") {
                $datos = $usuario->get_usuario_por_estado($estado);
            } else {
                $datos = $usuario->get_usuario();
            }

            // $datos=$usuario->get_usuario();

            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                if($row["id_usuario"]!="-1"){
                    $sub_array[] = $row["dni"];
                    $sub_array[] = $row["nombre"];
                    $sub_array[] = $row["apellido"];
                    $sub_array[] = $row["correo"];
                    $sub_array[] = $row["usuario"];
                    $sub_array[] = $row["rolNombre"];
                    $sub_array[] = $row["areaNombre"];
                    
                    if($row["estado"]=="1"){
                        $sub_array[] = '<span class="badge bg-success text-black">Habilitado</span>';
                    }else{
                        if($row["estado"]=="2"){
                            $sub_array[] = '<span class="badge bg-warning text-black">No Verificado</span>';
                        }else{
                            $sub_array[] = '<span class="badge bg-danger text-black">Deshabilitado</span>';
                        }
                    }

                    if($row["estado"]=="1" || $row["estado"]=="2"){

                        if($_SESSION["id_usuario"] == "1"){
                            if(($row["id_rol"]=="1" && $row["id_usuario"]!="1") || $row["id_rol"]=="2" || $row["id_rol"]=="3"){
                                if($row["id_rol"]!="1"){
                                    if($row["estado"]=="2"){
                                        $sub_array[] = '
                                <div class="btn-group">
                                    <span class="btn-group">
                                        <button href="#" data-id="'.$row["id_usuario"].'" onclick="eliminarUsuario('.$row["id_usuario"].','.$row["estado"].');" class="btn btn-danger btn-sm btnEliminar"><i class="fa-solid fa-trash"></i></button>
                                    </span>
                                </div>';
                                    }else{
                                        $sub_array[] = '
                                        <div class="btn-group">
                                            <span class="btn-group">
                                                <button href="#" data-id="'.$row["id_usuario"].'" onclick="editar('.$row["id_usuario"].');" class="btn btn-warning btn-sm btnEditar"><i class="fa-solid fa-pen-to-square"></i></button>                    
                                            </span>
                                            <span class="btn-group">
                                                <button href="#" data-id="'.$row["id_usuario"].'" onclick="eliminarUsuario('.$row["id_usuario"].','.$row["estado"].');" class="btn btn-danger btn-sm btnEliminar"><i class="fa-solid fa-trash"></i></button>
                                            </span>
                                        </div>';
                                    }
                                }else{
                                    $sub_array[] = '
                                    <div class="btn-group">
                                        <span class="btn-group">
                                            <button href="#" data-id="'.$row["id_usuario"].'" onclick="editar('.$row["id_usuario"].');" class="btn btn-warning btn-sm btnEditar"><i class="fa-solid fa-pen-to-square"></i></button>                    
                                        </span>
                                        <span class="btn-group">
                                            <button href="#" data-id="'.$row["id_usuario"].'" onclick="eliminarUsuario('.$row["id_usuario"].','.$row["estado"].');" class="btn btn-danger btn-sm btnEliminar"><i class="fa-solid fa-trash"></i></button>                    
                                        </span>
                                    </div>';
                                }
                            }else{
                                $sub_array[] = '
                                <div class="btn-group">
                                    <span class="btn-group">
                                        <button href="#" data-id="'.$row["id_usuario"].'" onclick="editar('.$row["id_usuario"].');" class="btn btn-warning btn-sm btnEditar"><i class="fa-solid fa-pen-to-square"></i></button> 
                                    </span>
                                </div>';
                            }
                        }else{

                            if($row["id_rol"]=="1"){

                                if($row["id_usuario"]!=$_SESSION["id_usuario"]){
                                    if($row["id_usuario"] == "1"){
                                        $sub_array[] = '
                                        <div class="btn-group">
                                            <span class="btn-group">
                                                <button href="#" data-id="'.$row["id_usuario"].'" onclick="ver('.$row["id_usuario"].','.$row["estado"].');" class="btn btn-primary btn-sm btnEliminar"><i class="fa-solid fa-eye"></i></button>
                                            </span>
                                        </div>';
                                    }else{
                                        $sub_array[] = '
                                        <div class="btn-group">
                                            <span class="btn-group">
                                                <button href="#" data-id="'.$row["id_usuario"].'" onclick="eliminarUsuario('.$row["id_usuario"].','.$row["estado"].');" class="btn btn-danger btn-sm btnEliminar"><i class="fa-solid fa-trash"></i></button>
                                            </span>
                                        </div>';
                                    }
                                }else{
                                    $sub_array[] = '
                                    <div class="btn-group">
                                        <span class="btn-group">
                                            <button href="#" data-id="'.$row["id_usuario"].'" onclick="editar('.$row["id_usuario"].');" class="btn btn-warning btn-sm btnEditar"><i class="fa-solid fa-pen-to-square"></i></button>                    
                                        </span>
                                    </div>';
                                }
                            }else{
                                if($row["estado"]=="2"){
                                    $sub_array[] = '
                                    <div class="btn-group">
                                        <span class="btn-group">
                                        <button href="#" data-id="'.$row["id_usuario"].'" onclick="eliminarUsuario('.$row["id_usuario"].','.$row["estado"].');" class="btn btn-danger btn-sm btnEliminar"><i class="fa-solid fa-trash"></i></button>
                                    </span>
                                    </div>';
                                }else{
                                    $sub_array[] = '
                                <div class="btn-group">
                                    <span class="btn-group">
                                        <button href="#" data-id="'.$row["id_usuario"].'" onclick="editar('.$row["id_usuario"].');" class="btn btn-warning btn-sm btnEditar"><i class="fa-solid fa-pen-to-square"></i></button>                    
                                    </span>
                                    <span class="btn-group">
                                        <button href="#" data-id="'.$row["id_usuario"].'" onclick="eliminarUsuario('.$row["id_usuario"].','.$row["estado"].');" class="btn btn-danger btn-sm btnEliminar"><i class="fa-solid fa-trash"></i></button>
                                    </span>
                                </div>';
                                }
                            }
                        }
                        
                    }else{
                        $sub_array[] = '
                        <div class="btn-group">
                            <span class="btn-group">
                                <button href="#" data-id="'.$row["id_usuario"].'" onclick="habilitar('.$row["id_usuario"].');" class="btn btn-success btn-sm btnHabilitar"><i class="fa-solid fa-clipboard-list"></i></button>                    
                            </span>
                        </div>';
                        }
                    $data[] = $sub_array;
                }
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
            break;

        case "eliminar":
            $usuario->delete_usuario($_POST["usu_id"]);
            break;

        case "habilitar":
            $usuario->habilitar_usuario($_POST["usu_id"]);
            break;

        case "mostrar";
            $datos=$usuario->get_usuario_x_id($_POST["id"]);  
            
            if(is_array($datos)==true and count($datos)>0){
                echo json_encode($datos);
            }   
            break;

        case "total";
            $datos=$usuario->get_usuario_total_x_id($_POST["usu_id"]);  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"];
                }
                echo json_encode($output);
            }
            break;

        case "totalabierto";
            $datos=$usuario->get_usuario_totalabierto_x_id($_POST["usu_id"]);  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"];
                }
                echo json_encode($output);
            }
            break;

        case "totalcerrado";
            $datos=$usuario->get_usuario_totalcerrado_x_id($_POST["usu_id"]);  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"];
                }
                echo json_encode($output);
            }
            break;

        case "grafico";
            $datos=$usuario->get_usuario_grafico($_POST["usu_id"]);  
            echo json_encode($datos);
            break;

        case "combo";
            $datos = $usuario->get_usuario_x_rol();
            if(is_array($datos)==true and count($datos)>0){
                $html.= "<option label='Seleccionar'></option>";
                foreach($datos as $row)
                {
                    $html.= "<option value='".$row['usu_id']."'>".$row['usu_nom']."</option>";
                }
                echo $html;
            }
            break;
        /* Controller para actualizar contraseña */
        case "password":
            $usuario->update_usuario_pass($_POST["usu_id"],$_POST["usu_pass"]);
            break;

    }
?>