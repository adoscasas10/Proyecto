$(document).ready(function () {


    init();

    //Aca acontinución vamos a agregar la funcionalidad al input usu_asig, primero vamos a 
    $("#usu_asig").keyup(function(){
        let query = $(this).val();
        let id_rol = $("#id_rol").val();
        if(query.length > 0){
            $.ajax({
                url: "./../../controller/ticketController.php?op=buscar_persona",
                method: "POST",
                data: { accion: "buscar_persona", query: query, id_rol: id_rol },
                success: function(data){
                    $("#resultados").html(data).show();
                }
            });
        } else {
            $("#resultados").hide();
            $("#usu_id").val(0);
        }
    });

    $(document).on("click", ".opcion", function(){
        let nombre = $(this).text();
        let id = $(this).data("id");

        $("#usu_asig").val(nombre);  // lo pone en el input principal
        $("#usu_id").val(id);        // guarda el ID en hidden
        $("#resultados").hide();     // oculta lista
    });

    $('#btnCerrar').click(function(){
        $('#modalasignar').modal('hide');
    });

    // Cuando se abre el modal
    $('#modalasignar').on('shown.bs.modal', function() {
        $('#modalasignar').removeAttr('inert');
        $('#modalasignar').removeAttr('aria-hidden');
    });

    // Cuando se cierra el modal
    $('#modalasignar').on('hidden.bs.modal', function() {
        $('#modalasignar').attr('inert', '');
        $('#modalasignar').attr('aria-hidden', 'true');

        $("#resultados").hide();
        $("#usu_id").val(0);
        $("#usu_asig").val("");
    });

    var dataTable = $('#tabla_tickets_data').DataTable({
        "pageLength": 10,
        "order": [], // ✅ permite ordenar desde los encabezados
        "aoColumnDefs": [{
            "bSortable": false,
            "aTargets": ['nosort'] // ✅ opcional, si usas columnas no ordenables
        }],
        "buttons": [
            {
                "extend": 'excelHtml5',
                "text": 'Exportar Excel',
                "title": 'Mis Tickets',
                "exportOptions": {
                    "columns": ':visible'
                }
            },
            {
                extend: 'pdfHtml5',
                text: 'Exportar PDF',
                title: 'Reporte de Tickets',
                orientation: 'landscape',
                pageSize: 'A4',
                exportOptions: {
                    // Excluir la última columna (la de "Opciones")
                    columns: function (idx, data, node) {
                        const totalCols = $('#tabla_tickets_data thead th').length;
                        return idx < totalCols - 1;
                    }
                },
                customize: function (doc) {
                    doc.pageMargins = [40, 60, 40, 60];
                
                    // Título centrado con estilo
                    doc.content.splice(0, 1, {
                        text: 'Reporte de Tickets',
                        fontSize: 18,
                        alignment: 'center',
                        margin: [0, 0, 0, 20],
                        bold: true,
                        color: '#003366'
                    });
                
                    // Buscar la tabla exportada
                    var table = doc.content.find(c => c.table);
                
                    if (table && table.table) {
                        // Contar cuántas columnas hay (longitud del header)
                        var numCols = table.table.body[0].length;
                
                        // Generar anchos iguales para todas las columnas
                        var colWidths = [];
                        for (var i = 0; i < numCols; i++) {
                            colWidths.push('*'); // '*' reparte el ancho equitativamente
                        }
                
                        // Asignar los anchos
                        table.table.widths = colWidths;
                        table.alignment = 'center';
                
                        // Mejorar diseño de la tabla
                        table.layout = {
                            hLineWidth: function () { return 0.5; },
                            vLineWidth: function () { return 0.5; },
                            hLineColor: function () { return '#ccc'; },
                            vLineColor: function () { return '#ccc'; },
                            paddingLeft: function () { return 8; },
                            paddingRight: function () { return 8; },
                            paddingTop: function () { return 6; },
                            paddingBottom: function () { return 6; }
                        };
                    }
                
                    // Estilo de encabezados
                    doc.styles.tableHeader = {
                        fillColor: '#003366',
                        color: 'white',
                        bold: true,
                        fontSize: 12,
                        alignment: 'center'
                    };
                
                    doc.styles.tableBodyEven = { alignment: 'center', fontSize: 10 };
                    doc.styles.tableBodyOdd = { alignment: 'center', fontSize: 10 };
                
                    // Pie de página
                    doc.footer = function (currentPage, pageCount) {
                        return {
                            columns: [
                                { text: 'NexoIT Negocios - Software empresarial', alignment: 'left', margin: [40, 0] },
                                { text: 'Página ' + currentPage + ' de ' + pageCount, alignment: 'right', margin: [0, 0, 40, 0] }
                            ],
                            fontSize: 9
                        };
                    };
                }
            } 
        ],
        "aoColumns": [
            null, null, null, null, null, null, null, null, null, null
        ],
        "ajax":{
            url: '../../controller/ticketController.php?op=listar',
            type : "post",
            dataType : "json",		
            data: function (d) {
                d.EstadoAsignacion = $('#filtro_estado').val();
                d.EstadoTicketAC = $('#filtroEstadoSistema').val();
                d.Prioridad = $('#filtroPrioridad').val();

            },				
            error: function(e){
                console.log(e.responseText);	
            }
        },
        "scrollX": false,
        "autoWidth": false,
        "paging": true,
        "bLengthChange": false,
        "dom": 'B<"top">ct<"top"p><"clear">',
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

    $('#filtro_estado').on('change', function () {
        dataTable.ajax.reload();
    });
    $('#filtroEstadoSistema').on('change', function () {
        dataTable.ajax.reload();
    });
    $('#filtroPrioridad').on('change', function () {
        dataTable.ajax.reload();
    });

    $("#buscador").on("keyup", function () {
        const column = $("#filtro").val();
        const value = this.value;

        if (column !== "") {
            // Limpia búsqueda global y búsqueda de otras columnas
            dataTable.search("").columns().search("");

            // Aplica búsqueda solo en columna específica
            dataTable.column(column).search(value).draw();
        } else {
            // Sin filtro específico, búsqueda global
            dataTable.columns().search(""); // Limpia filtros por columnas
            dataTable.search(value).draw();
        }
    });

    $('#filtro').on('change', function () {
        // Al cambiar filtro, limpia todo y dispara búsqueda
        dataTable.search("").columns().search("");
        $("#buscador").trigger("keyup");
    });

    //Ocultar botones
    $('.dt-button').hide();
    //Boton Excel personalizado
    $('#btnExcel').on('click', function () {
        // Forzar un redraw antes de exportar
        dataTable.draw();

        // Esperar para asegurar sincronización antes de exportar
        setTimeout(() => {
            dataTable.button('.buttons-excel').trigger();
        }, 200);
    });

    //Boton PDF personalizado
    $('#btnPDF').on('click', function () {
        // Forzar un redraw antes de exportar
        dataTable.draw();

        // Esperar para asegurar sincronización antes de exportar
        setTimeout(() => {
            dataTable.button('.buttons-pdf').trigger();
        }, 200);
    });


    $('#btnAutoasignar').on('click', function () {
        alert("Autoasignar");
        console.log("Autoasignar");

        //Lo mismo que asignar

        var formData = new FormData($("#ticket_form")[0]);
        $.ajax({
            url: "../../controller/ticketController.php?op=asignar",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(datos){
                var tick_id = $('#tick_id').val();
                var usu_id = $('#usu_Actual').val();

                
                $("#modalasignar").modal('hide');
                $('#tabla_tickets_data').DataTable().ajax.reload();

                //Esto aun falta implementario, lo demas si esta
                $.post("../../controller/emailController.php?op=ticket_asignado", {tick_id : tick_id, usu_id : usu_id}, function (data) {


                });

                Swal.fire({
                    icon: "success",
                    title: "Correcto!",
                    text: "Asignado Correctamente",
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    }
                });
            }
        });


    })

});

function generarCardsDesdeDataTable() {
    const table = $('#tabla_tickets_data').DataTable();
    const $container = $('#cardContainer');
    $container.empty();

    // Solo muestra los datos de la página actual (paginada)
    table.rows({ page: 'current', search: 'applied' }).every(function () {
        const data = this.data();

        const card = `
        <div class="card-user">
          <h5>${data[0]}</h5>
          <p><strong>Prioridad:</strong> ${data[1]}</p>
          <p><strong>Categoria:</strong> ${data[2]}</p>
          <p><strong>Titulo:</strong> ${data[3]}</p>
          <p><strong>Estado:</strong> ${data[4]}</p>
          <p><strong>Fecha de Creación:</strong> ${data[5]}</p>
          <p><strong>Fecha Asignación:</strong> ${data[6]}</p>
          <p><strong>Usuario:</strong> ${data[7]}</p>
          <p><strong>Soporte:</strong> ${data[8]}</p>
          <div class="btn-group">
            ${data[9]}
          </div>
        </div>
      `;

        $container.append(card);
    });

     
}

$(document).ready(function () {

    const table = $('#tabla_tickets_data').DataTable(); // no reconfigures aquí
    // Mover el paginador al nuevo contenedor
    // function moverPaginador() {
    //     $('#paginadorExtra').html($('#usuario_data_paginate'));
    // }

    function moverPaginador() {
        $('#tabla_tickets_data_paginate').detach().appendTo('#paginadorExtra');
    }
    
    // Al hacer draw, moverlo de nuevo (porque DataTables lo vuelve a pintar)
    table.on('draw', moverPaginador);

    // Al cargar por primera vez
    moverPaginador();

    // Función para actualizar las cards si estamos en pantalla móvil
    function actualizarCardsSiEsMovil() {
        if (window.innerWidth < 768) {
            generarCardsDesdeDataTable();
        }
    }

    // Detecta acciones de búsqueda, paginación, filtrado, etc.
    table.on('draw', function () {
        actualizarCardsSiEsMovil();
    });

    // También al cambiar tamaño de pantalla
    $(window).on('resize', actualizarCardsSiEsMovil);

    // Y al cargar por primera vez
    actualizarCardsSiEsMovil();
});


function init(){
    $("#ticket_form").on("submit",function(e){
        guardar(e);	
    });
}


//Desde aqui para abajo no se utiliza aun

//Aun no se utiliza
function ver(tick_id){
    window.open('../Tickets/DetalleTickets.php?idTicket='+ tick_id +'');
}

//Se esta probando para ver como es
function verTicketDetalles(idTicket) {
    console.log("Primero probaremos con el 'get'");
    window.open('../Tickets/DetalleTickets.php?idTicket=' + idTicket);
}

//Primero terminemos con los detalles tickets
function verTicketNotas(idTicket) {
    console.log("Ahora probaremos con este notas");
    window.open('./DetalleNotas.php?idTicket=' + idTicket);
}



//Se esta utilizando
function asignar(tick_id){
    $.post("../../controller/ticketController.php?op=mostrar", {tick_id : tick_id}, function (data) {
        data = JSON.parse(data);
        $('#tick_id').val(data.tick_id);

        $('#mdltitulo').html('Asignar Agente');
        $("#modalasignar").modal('show');
    });
 
}


//Falta de autoasignacion // Aun no se utiliza
// function autoasignar(tick_id){
//     $.post("../../controller/ticketController.php?op=mostrar", {tick_id : tick_id}, function (data) {
//         data = JSON.parse(data);
//         $('#tick_id').val(data.tick_id);

//         $('#mdltitulo').html('Asignar Agente');
//         $("#modalasignar").modal('show');
//     });
// }


//Se esta utilizando
function guardar(e){
    e.preventDefault();
	var formData = new FormData($("#ticket_form")[0]);
    $.ajax({
        url: "../../controller/ticketController.php?op=asignar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){
            var tick_id = $('#tick_id').val();
            var usu_id = $('#usu_id').val();

            
            $("#modalasignar").modal('hide');
            $('#tabla_tickets_data').DataTable().ajax.reload();


            //Esto aun falta implementario, lo demas si esta
            $.post("../../controller/emailController.php?op=ticket_asignado", {tick_id : tick_id, usu_id : usu_id}, function (data) {


            });

            Swal.fire({
                icon: "success",
                title: "Correcto!",
                text: "Asignado Correctamente",
                customClass: {
                    confirmButton: 'btn btn-primary'
                }
            });

            

            

        }
    });
}

//No se utilizara aun, por el momento
function CambiarEstado(tick_id){
    swal({
        title: "HelpDesk",
        text: "Esta seguro de Reabrir el Ticket?",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-warning",
        confirmButtonText: "Si",
        cancelButtonText: "No",
        closeOnConfirm: false
    },
    function(isConfirm) {
        if (isConfirm) {
            $.post("../../controller/ticket.php?op=reabrir", {tick_id : tick_id,usu_id : usu_id}, function (data) {

            });

            $('#ticket_data').DataTable().ajax.reload();	

            swal({
                title: "HelpDesk!",
                text: "Ticket Abierto.",
                type: "success",
                confirmButtonClass: "btn-success"
            });
        }
    });
}
