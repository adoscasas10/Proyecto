$(document).ready(function () {
    

    var dataTable = $('#notificaciones_data').DataTable({
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
                "title": 'Usuarios',
                "exportOptions": {
                    "columns": ':visible'
                }
            },
            {
                extend: 'pdfHtml5',
                text: 'Exportar PDF',
                title: 'Reporte de Usuarios',
                orientation: 'landscape',
                pageSize: 'A4',
                exportOptions: {
                    // Excluir la última columna (la de "Opciones")
                    columns: function (idx, data, node) {
                        const totalCols = $('#usuario_data thead th').length;
                        return idx < totalCols - 1;
                    }
                },
                customize: function (doc) {
                    doc.pageMargins = [40, 60, 40, 60];
            
                    doc.content.splice(0, 1, {
                        text: 'Reporte de Usuarios',
                        fontSize: 18,
                        alignment: 'center',
                        margin: [0, 0, 0, 20],
                        bold: true,
                        color: '#003366'
                    });
            
                    doc.styles.tableHeader = {
                        fillColor: '#003366',
                        color: 'white',
                        bold: true,
                        fontSize: 12,
                        alignment: 'center'
                    };
            
                    doc.styles.tableBodyEven = { alignment: 'center', fontSize: 10 };
                    doc.styles.tableBodyOdd = { alignment: 'center', fontSize: 10 };
            
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
            null,
            null,
            null,
            null
        ],
        "ajax":{
            url: '../../controller/notificacionesController.php?op=listar',
            type : "post",
            dataType : "json",	
            data: function (d) {
                d.estado = $('#filtroEstadoSistema').val();
                d.id_usuario = $('#id_usuario').val();
                d.fecha_desde = $('#fecha_desde').val();
                d.fecha_hasta = $('#fecha_hasta').val();
            },				
        },
        scrollX: false,
        autoWidth: false,
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


    $('#btnMarcarLeido').on('click', function () {
        $.ajax({
            type: "POST",
            url: "../../controller/notificacionesController.php?op=marcarLeido",
            data: { id_usuario: $('#id_usuario').val() },
            dataType: "json",
            success: function (response) {
                dataTable.ajax.reload();
            }
        });
    });
    
    $("#buscador").on("keyup", function () {
        const value = this.value;
        dataTable.search(value).draw();
    });

    $('#filtroEstadoSistema').on('change', function () {
        dataTable.ajax.reload();
    });
    
    $('#fecha_desde').on('change', function () {
        dataTable.ajax.reload();
    });
    
    $('#fecha_hasta').on('change', function () {
        dataTable.ajax.reload();
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

    $('#btnPdf').on('click', function () {
        // Forzar un redraw antes de exportar
        dataTable.draw();

        // Esperar para asegurar sincronización antes de exportar
        setTimeout(() => {
            dataTable.button('.buttons-pdf').trigger();
        }, 200);
    });

});



function generarCardsDesdeDataTable() {
    const table = $('#notificaciones_data').DataTable();
    const $container = $('#cardContainer');
    $container.empty();

    // Solo muestra los datos de la página actual (paginada)
    table.rows({ page: 'current', search: 'applied' }).every(function () {
        const data = this.data();

        const card = `
        <div class="card-user">
          <h5>${data[1]} ${data[2]}</h5>
          <p><strong>DNI:</strong> ${data[0]}</p>
          <p><strong>Correo:</strong> ${data[3]}</p>
        </div>
      `;

        $container.append(card);
    });
}

$(document).ready(function () {

    const table = $('#notificaciones_data').DataTable(); // no reconfigures aquí
    // Mover el paginador al nuevo contenedor
    // function moverPaginador() {
    //     $('#paginadorExtra').html($('#usuario_data_paginate'));
    // }

    function moverPaginador() {
        $('#notificaciones_data_paginate').detach().appendTo('#paginadorExtra');
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

function updateNotificacion(id_notificacion, id_ticket){
    $.post("./../../controller/notificacionesController.php?op=update", { id_notificacion : id_notificacion}, function (data) {
        
        window.open("./../Tickets/detalleTickets.php?idTicket="+id_ticket,"_blank");
        location.reload();
    }); 
}
 