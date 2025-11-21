<?php
    /* llamada a las clases necesarias */
    require_once("../../Config/Config.php");
    require_once("../Model/Documento.php");
    $documento = new Documento();

    /* opciones del controlador */
    switch($_GET["op"]){
        /* manejo de json para poder listar en el datatable, formato de json segun documentacion */
        case "listar":
            $datos=$documento->get_documento_x_ticket($_POST["tick_id"]);
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = '<a href="./../../../Public/document/'.$_POST["tick_id"].'/'.$row["doc_nombre"].'" target="_blank">'.$row["doc_nombre"].'</a>
                <img src="./../../../Public/document/'.$_POST["tick_id"].'/'.$row["doc_nombre"].'" alt="'.$row["doc_nombre"].'" width="100" height="100" style="display: none;">
                ';
                $sub_array[] = '<a type="button" href="./../../../Public/document/'.$_POST["tick_id"].'/'.$row["doc_nombre"].'" target="_blank" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></a>';
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
        break;
    }
?>
