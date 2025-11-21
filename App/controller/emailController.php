<?php
    /* llamada a las clases necesarias */
    require_once("../../Config/Config.php");
    require_once("../Model/Email.php");
    $email = new Email();

    /* opciones del controlador */
    switch ($_GET["op"]) {
        /*  enviar ticket abierto con el ID */
        //Se esta utilizando
        case "ticket_abierto":
            $email->ticket_abierto($_POST["tick_id"]);
            break;

        case "ticket_cerrado":
            $email->ticket_cerrado($_POST["tick_id"]);
            break;

            //Se estara utilizando
        case "ticket_asignado":
            $email->ticket_asignado($_POST["tick_id"]);
            break;

        case "cambio_contraseña":
            $email->cambio_contraseña($_POST["usu_id"]);
            break;
        
        case "recuperar_contraseña":
            $email->recuperar_contraseña($_POST["usu_id"], $_POST["correo"], $_POST["datos"]);
            break;

        case "verificar_cuenta":
            $email->verificar_cuenta($_POST["usu_id"], $_POST["usu_correo"]);
            break;

    }
?>