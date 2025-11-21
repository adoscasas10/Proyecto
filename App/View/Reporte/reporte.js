$(document).ready(function () {
    $('#aten_garantia').select2({
        theme: 'bootstrap-5',
        dropdownParent: $('#aten_garantia').closest('.card-body')
    });
    $('#filtroGraficoTecnico').select2({
        theme: 'bootstrap-5',
        width: '100%',
        dropdownParent: $('#filtroGraficoTecnico').closest('.card-body')
    });


    $('#btnFiltrar').click(function () {
        var EstadoTicketAC = $('#filtroEstadoSistema').val();
        var FechaDesde = $('#filtroDesde').val();
        var FechaHasta = $('#filtroHasta').val();
        var aten_garantia = $('#aten_garantia').val();
        
        dataTable.ajax.reload();
        console.log(EstadoTicketAC + ' ' + FechaDesde + ' ' + FechaHasta + ' ' + aten_garantia);
    });

    //Colocar dato en el select:
    $.post("../../controller/ticketController.php?op=listar_tecnico", function (data) {
        var tecnico = JSON.parse(data);
        $('#aten_garantia').append('<option value="0">Todos</option>');
        for (var i = 0; i < tecnico.length; i++) {
            $('#aten_garantia').append('<option value="' + tecnico[i].id_usuario + '">' + tecnico[i].nombre + ' ' + tecnico[i].apellido + '</option>');
        }
    })


    $.post("../../controller/ticketController.php?op=listar_tecnico", function (data) {
        var tecnico = JSON.parse(data);
        $('#filtroGraficoTecnico').append('<option value="0">Todos</option>');
        for (var i = 0; i < tecnico.length; i++) {
            $('#filtroGraficoTecnico').append('<option value="' + tecnico[i].id_usuario + '">' + tecnico[i].nombre + ' ' + tecnico[i].apellido + '</option>');
        }
    })
    

    //Ahora cuando 

    

    var dataTable = $('#tickets_data').DataTable({
        "pageLength": 10,
        "order": [],
        "aoColumnDefs": [{
            "bSortable": false,
            "aTargets": ['nosort'] 
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
            null, null, null, null, null, null, null
        ],
        "ajax":{
            url: '../../controller/ticketController.php?op=listarReporte',
            type : "post",
            dataType : "json",		
            data: function (d) {
                d.EstadoTicketAC = $('#filtroEstadoSistema').val();
                d.FechaDesde = $('#filtroDesde').val();
                d.FechaHasta = $('#filtroHasta').val();
                d.aten_garantia = $('#aten_garantia').val();
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



});