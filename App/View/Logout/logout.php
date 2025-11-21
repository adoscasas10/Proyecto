<?php
    require_once("../../../Config/Config.php");
    session_destroy();
    header("Location:".Conectar::ruta()."index.php");
    exit();
?>