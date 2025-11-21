<?php
    require_once("../../../Config/Config.php");
    session_destroy();
    header("Location: index.php");
    exit();
?>
