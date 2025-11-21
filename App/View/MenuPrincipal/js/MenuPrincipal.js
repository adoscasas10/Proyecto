$(document).ready(function () {
    
    var usu_id = $("#usu_id").val();

    $(".ticketTotales").html("12");
    $(".ticketResueltos").html("12");
    $(".ultimaSesion").html("12");

    var dataTable = $('#DataTableTickets').DataTable({
        "pageLength": 5,
        "order": [], // ✅ permite ordenar desde los encabezados
        "aoColumnDefs": [{
            "bSortable": false,
            "aTargets": ['nosort'] // ✅ opcional, si usas columnas no ordenables
        }],
        "aoColumns": [
            null, null, null, null
        ],
        "ajax":{
            url: '../../controller/ticketController.php?op=listarMenuPrincipal',
            type : "POST",
            dataType : "json",
            data:{usu_id:usu_id}
        },
        "scrollX": false,
        "autoWidth": false,
        "paging": true,
        "bLengthChange": false,
        "dom": '<"top">ct<"top"p><"clear">',
        "language": {
            "paginate": {
                "previous": "Anterior",
                "next": "Siguiente"
            },
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "zeroRecords": "No se encontraron resultados"
        }
    });


    $.ajax({
        type: "POST",
        url: "./../../controller/UsuarioController.php?op=Mostrar_Usuario",
        data: {usu_id:usu_id},
        dataType: "json",
        success: function (response) {
            //Dar formato a la fecha
            var fecha = new Date(response.ultima_sesion);
            var fecha_formateada = fecha.toLocaleDateString();
            $(".ultimaSesion").html(fecha_formateada);
        }
    });

    $.ajax({
        type: "POST",
        url: "./../../controller/UsuarioController.php?op=Contar_Tickets",
        data: {usu_id:usu_id},
        dataType: "json",
        success: function (response) {
            console.log(response.total.TOTAL);
            console.log(response.cerrados.TOTAL_CERRADOS);
            $(".ticketTotales").html(response.total.TOTAL);
            $(".ticketResueltos").html(response.cerrados.TOTAL_CERRADOS);
        }
    });


    

});