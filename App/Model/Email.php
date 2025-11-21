<?php
/* librerias necesarias para que el proyecto pueda enviar emails */
require('class.phpmailer.php');
include("class.smtp.php");

/* llamada de las clases necesarias que se usaran en el envio del mail */
require_once("../../Config/Config.php");
require_once("../Model/ticket.php");
require_once("../Model/Usuario.php");

class Email extends PHPMailer{

    //variable que contiene el correo del destinatario
    protected $gCorreo = 'soportenexoitnegocios@gmail.com';
    protected $gContrasena = 'qljcmyttchnkzqzj';
    protected $tu_nombre = 'Soporte Nexoit Negocios';
    //variable que contiene la contraseña del destinatario

    public function ticket_abierto($tick_id){
        $ticket = new Ticket();
        $datos = $ticket->listar_ticket_x_id($tick_id);
        foreach ($datos as $row){
            $id = $row["tick_id"];
            $usu = $row["usu_nom"] ." " . $row["usu_ape"];
            $titulo = $row["tick_titulo"];
            $categoria = $row["cat_nom"];
            $correo = $row["usu_correo"];
            $prioridad = $row["tick_prioridad"];
        }

        //IGual//
        $this->IsSMTP();
        // $this->Host = 'smtp.office365.com';//Aqui el server
        $this->Host = 'smtp.gmail.com';//Aqui el server
        $this->Port = 587;//Aqui el puerto
        $this->SMTPAuth = true;
        $this->Username = $this->gCorreo;
        $this->Password = $this->gContrasena;
        $this->From = $this->gCorreo;
        $this->SMTPSecure = 'tls';
        $this->FromName = $this->tu_nombre = "Ticket Abierto T-".$id;
        $this->CharSet = 'UTF8';
        $this->addAddress($correo);
        $this->WordWrap = 50;
        $this->IsHTML(true);
        $this->Subject = "Ticket Abierto";
        //Igual//
        $cuerpo = file_get_contents('../../Public/NuevoTicket.html'); /* Ruta del template en formato HTML */
        /* parametros del template a remplazar */
        $cuerpo = str_replace("xnroticket", $id, $cuerpo);
        $cuerpo = str_replace("lblNomUsu", $usu, $cuerpo);
        $cuerpo = str_replace("lblTitu", $titulo, $cuerpo);
        $cuerpo = str_replace("lblCate", $categoria, $cuerpo);
        if($prioridad == "Baja"){
            $prioridad = "<b style='color: black; background-color: green; border-radius: 5px; padding: 2px;'>Baja</b>";
        }else if($prioridad == "Media"){
            $prioridad = "<b style='color: black; background-color: yellow; border-radius: 5px; padding: 2px;'>Media</b>";
        }else if($prioridad == "Alta"){
            $prioridad = "<b style='color: black; background-color: orange; border-radius: 5px; padding: 2px;'>Alta</b>";
        }else if($prioridad == "Critica"){
            $prioridad = "<b style='color: black; background-color: red; border-radius: 5px; padding: 2px;'>Critica</b>";
        }

        $cuerpo = str_replace("lblPrioridad", $prioridad, $cuerpo);

        $this->Body = $cuerpo;
        $this->AltBody = strip_tags("Ticket Abierto");
        return $this->Send();
    }

    public function ticket_cerrado($tick_id){
        $ticket = new Ticket();
        $datos = $ticket->listar_ticket_x_id($tick_id);
        foreach ($datos as $row){
            $id = $row["tick_id"];
            $usu = $row["usu_nom"];
            $titulo = $row["tick_titulo"];
            $categoria = $row["cat_nom"];
            $correo = $row["usu_correo"];
        }

        //IGual//
        $this->IsSMTP();
        $this->Host = 'smtp.office365.com';//Aqui el server
        $this->Port = 587;//Aqui el puerto
        $this->SMTPAuth = true;
        $this->Username = $this->gCorreo;
        $this->Password = $this->gContrasena;
        $this->From = $this->gCorreo;
        $this->SMTPSecure = 'tls';
        $this->FromName = $this->tu_nombre = "Ticket Cerrado ".$id;
        $this->CharSet = 'UTF8';
        $this->addAddress($correo);
        $this->WordWrap = 50;
        $this->IsHTML(true);
        $this->Subject = "Ticket Cerrado";
        //Igual//
        $cuerpo = file_get_contents('../public/CerradoTicket.html'); /* Ruta del template en formato HTML */
        /* parametros del template a remplazar */
        $cuerpo = str_replace("xnroticket", $id, $cuerpo);
        $cuerpo = str_replace("lblNomUsu", $usu, $cuerpo);
        $cuerpo = str_replace("lblTitu", $titulo, $cuerpo);
        $cuerpo = str_replace("lblCate", $categoria, $cuerpo);

        $this->Body = $cuerpo;
        $this->AltBody = strip_tags("Ticket Cerrado");
        return $this->Send();
    }

    public function ticket_asignado($tick_id){
        $ticket = new Ticket();
        $datos = $ticket->listar_ticket_x_id($tick_id, 2);
        foreach ($datos as $row){
            $id = $row["tick_id"];
            $usu = $row["usu_nom"] . " " . $row["usu_ape"];
            $titulo = $row["tick_titulo"];
            $categoria = $row["cat_nom"];
            $correo = $row["usu_correo"];
            $correoAsignado = $row["asig_correo"];
            $prioridad = $row["tick_prioridad"];
            $usuario_asignado = $row["asig_nom"] . " " . $row["asig_ape"];
        }

        //IGual//
        $this->IsSMTP();
        $this->Host = 'smtp.gmail.com';//Aqui el server
        $this->Port = 587;//Aqui el puerto
        $this->SMTPAuth = true;
        $this->Username = $this->gCorreo;
        $this->Password = $this->gContrasena;
        $this->From = $this->gCorreo;
        $this->SMTPSecure = 'tls';
        $this->FromName = $this->tu_nombre = "Ticket Asignado T-".$id;
        $this->CharSet = 'UTF8';
        if($correo == $correoAsignado){
            $this->addAddress($correo);
        }else{
            $this->addAddress($correo);
            $this->addAddress($correoAsignado);
        }
        $this->WordWrap = 50;
        $this->IsHTML(true);
        $this->Subject = "Ticket Asignado";
        //Igual//
        $cuerpo = file_get_contents('../../Public/AsignarTicket.html'); /* Ruta del template en formato HTML */
        /* parametros del template a remplazar */
        $cuerpo = str_replace("xnroticket", $id, $cuerpo);
        $cuerpo = str_replace("lblNomUsu", $usuario_asignado, $cuerpo);
        $cuerpo = str_replace("lblTitu", $titulo, $cuerpo);
        $cuerpo = str_replace("lblCate", $categoria, $cuerpo);
        if($prioridad == "Baja"){
            $prioridad = "<b style='color: black; background-color: green; border-radius: 5px; padding: 2px;'>Baja</b>";
        }else if($prioridad == "Media"){
            $prioridad = "<b style='color: black; background-color: yellow; border-radius: 5px; padding: 2px;'>Media</b>";
        }else if($prioridad == "Alta"){
            $prioridad = "<b style='color: black; background-color: orange; border-radius: 5px; padding: 2px;'>Alta</b>";
        }else if($prioridad == "Critica"){
            $prioridad = "<b style='color: black; background-color: red; border-radius: 5px; padding: 2px;'>Critica</b>";
        }

        $cuerpo = str_replace("lblPrioridad", $prioridad, $cuerpo);

        $this->Body = $cuerpo;
        $this->AltBody = strip_tags("Ticket Asignado");
        return $this->Send();
    }

    public function cambio_contraseña($usu_id){
        $usuario = new Usuario();
        $datos = $usuario->get_usuario_x_id($usu_id);
       
        $id = $datos["id_usuario"];
        $usu = $datos["nombre"] . " " . $datos["apellido"];
        $correo = $datos["correo"];
        $rol = $datos["rolNombre"];   
        $area = $datos["areaNombre"]; 

        //IGual//
        $this->IsSMTP();
        // $this->Host = 'smtp.office365.com';//Aqui el server
        $this->Host = 'smtp.gmail.com';//Aqui el server
        $this->Port = 587;//Aqui el puerto
        $this->SMTPAuth = true;
        $this->Username = $this->gCorreo;
        $this->Password = $this->gContrasena;
        $this->From = $this->gCorreo;
        $this->SMTPSecure = 'tls';
        $this->FromName = $this->tu_nombre = "Cambio de Contraseña C-".$id;
        $this->CharSet = 'UTF8';
        $this->addAddress($correo);
        $this->WordWrap = 50;
        $this->IsHTML(true);
        $this->Subject = "Cambio de Contraseña";
        //Igual//
        $cuerpo = file_get_contents('../../Public/CambioContrasena.html'); /* Ruta del template en formato HTML */
        /* parametros del template a remplazar */
        // $cuerpo = str_replace("xnroticket", $id, $cuerpo);
        $cuerpo = str_replace("lblNomUsu", $usu, $cuerpo);
        if($rol == "Administrador"){
            $rol = "<b style='color: black; background-color: green; border-radius: 5px; padding: 2px;'>Administrador</b>";
        }else if($rol == "Soporte"){
            $rol = "<b style='color: black; background-color: yellow; border-radius: 5px; padding: 2px;'>Soporte</b>";
        }else if($rol == "Usuario"){
            $rol = "<b style='color: black; background-color: orange; border-radius: 5px; padding: 2px;'>Usuario</b>";
        }

        $cuerpo = str_replace("lblRol", $rol, $cuerpo);
        $cuerpo = str_replace("lblArea", $area, $cuerpo);

        $this->Body = $cuerpo;
        $this->AltBody = strip_tags("Cambio de Contraseña");
        return $this->Send();
    }

    public function recuperar_contraseña($usu_id, $correo, $datos){
        $enlace = Conectar::ruta();

        
        $usuario = new Usuario();
        $datos = $usuario->get_usuario_x_id($usu_id);
       
        $id = $datos["id_usuario"];
        $usu = $datos["nombre"] . " " . $datos["apellido"];
        $correo = $datos["correo"];

        //IGual//
        $this->IsSMTP();
        // $this->Host = 'smtp.office365.com';//Aqui el server
        $this->Host = 'smtp.gmail.com';//Aqui el server
        $this->Port = 587;//Aqui el puerto
        $this->SMTPAuth = true;
        $this->Username = $this->gCorreo;
        $this->Password = $this->gContrasena;
        $this->From = $this->gCorreo;
        $this->SMTPSecure = 'tls';
        $this->FromName = $this->tu_nombre = "Recuperar Contraseña C-".$id;
        $this->CharSet = 'UTF8';
        $this->addAddress($correo);
        $this->WordWrap = 50;
        $this->IsHTML(true);
        $this->Subject = "Recuperar Contraseña";
        //Igual//
        $cuerpo = file_get_contents('../../Public/RecuperarContrasena.html');
        $cuerpo = str_replace("lblNomUsu", $usu, $cuerpo);
        
        //transformar los datos en json
        $datos = json_encode($datos);
        //Incriptar los datos
        $datos = base64_encode($datos);
        //Ahora desencriptarlos
        //$datos = base64_decode($datos);

        $enlace = "<a href='".$enlace."App/View/RecuperarContrasena/RecuperarContrasena.php?datoRamdon=".$id."21324&d=".$datos."'>".$enlace."App/View/RecuperarContrasena.php</a>";



        $cuerpo = str_replace("lblEnlace", $enlace, $cuerpo);

        $this->Body = $cuerpo;
        $this->AltBody = strip_tags("Cambio de Contraseña");
        return $this->Send();
        
        
    }


    public function verificar_cuenta($usu_id, $correo){
        $enlace = Conectar::ruta();

        
        $usuario = new Usuario();
        $datos = $usuario->get_usuario_x_id($usu_id);
       
        $id = $datos["id_usuario"];
        $usu = $datos["nombre"] . " " . $datos["apellido"];
        $correo = $datos["correo"];

        //IGual//
        $this->IsSMTP();
        // $this->Host = 'smtp.office365.com';//Aqui el server
        $this->Host = 'smtp.gmail.com';//Aqui el server
        $this->Port = 587;//Aqui el puerto
        $this->SMTPAuth = true;
        $this->Username = $this->gCorreo;
        $this->Password = $this->gContrasena;
        $this->From = $this->gCorreo;
        $this->SMTPSecure = 'tls';
        $this->FromName = $this->tu_nombre = "Verificar Cuenta C-".$id;
        $this->CharSet = 'UTF8';
        $this->addAddress($correo);
        $this->WordWrap = 50;
        $this->IsHTML(true);
        $this->Subject = "Verificar Cuenta";
        //Igual//
        $cuerpo = file_get_contents('../../Public/VerificarCuenta.html');
        $cuerpo = str_replace("lblNomUsu", $usu, $cuerpo);
        
        //transformar los datos en json
        $datos = json_encode($datos);
        //Incriptar los datos
        $datos = base64_encode($datos);
        //Ahora desencriptarlos
        //$datos = base64_decode($datos);

        $enlace = "<a href='".$enlace."App/View/VerificarCuenta/VerificarCuenta.php?datoRamdon=".$id."21324&d=".$datos."'>".$enlace."App/View/VerificarCuenta.php</a>";



        $cuerpo = str_replace("lblEnlace", $enlace, $cuerpo);

        $this->Body = $cuerpo;
        $this->AltBody = strip_tags("Verificar Cuenta");
        return $this->Send();
        
        
    }
}

?>