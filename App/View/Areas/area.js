function validar() {
    var codigoArea = $('#codigoArea');
    var nombreArea = $('#nombreArea');

    $('#btnCancelar').click(function(){
        $('#formArea')[0].reset();
        codigoArea.css("border-color", "#3F454B");
        nombreArea.css("border-color", "#3F454B");
    });

    nombreArea.keyup(function(){
        var expression = /^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ()]+( [a-zA-ZáéíóúÁÉÍÓÚñÑüÜ()]+)*$/; 
        var valor = $(this).val();
        if(!expression.test(valor)){
            nombreArea.css("border-color", "#F00");
        }else{
            nombreArea.css("border-color", "#090");
        }
        if(valor.length === 0 ){
            nombreArea.css("border-color", "#3F454B");
        }
    });

    codigoArea.keyup(function(){
        //Solo deben ser 5 caracteres
        var expression = /^[a-zA-Z0-9]{5}$/; 
        var valor = $(this).val();
        if(!expression.test(valor)){
            codigoArea.css("border-color", "#F00");
        }else{
            codigoArea.css("border-color", "#090");
        }
        if(valor.length === 0 ){
            codigoArea.css("border-color", "#3F454B");
        }
    });
    
}

function init(){
    $('#formArea').on('submit', function(e){
        e.preventDefault();
        
        var errorDetectado = false;
        var mensaje = "";

            
        var codigoArea = $('#codigoArea').val();
        var nombreArea = $('#nombreArea').val();

        if(!/^[a-zA-Z0-9]{5}$/.test(codigoArea)){
            errorDetectado = true;
            mensaje = "El código debe tener 5 letras y es obligatorio";
        }else if(!/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ()]+( [a-zA-ZáéíóúÁÉÍÓÚñÑüÜ()]+)*$/.test(nombreArea)){
            errorDetectado = true;
            mensaje = " El nombre debe contener solo letras y tener 50 caracteres y es obligatorio";
        }

        
        // alert("codigoArea: " + codigoArea);
        // alert("nombreArea: " + nombreArea);
        // alert("errorDetectado: " + errorDetectado);
        // alert("mensaje: " + mensaje);
        
        if(errorDetectado){
            Swal.fire({
                icon: "error",
                title: "Error",
                text: mensaje,
                customClass: {
                    confirmButton: 'btn btn-primary'
                }
            });
        }else{
            guardaryeditar(e);
        }
    });
}

function guardaryeditar(e) {
    var formData = new FormData($('#formArea')[0]);
    $.ajax({
        url: '../../controller/AreaController.php?op=guardaryeditar',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {

            if(data.includes("Error") || data.includes("Faltan") || data.includes("Existe")){
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: data,
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    }
                });
            }else{
                $('#formArea')[0].reset();
                Swal.fire({
                    title: "Correcto!",
                    text: data,
                    icon: "success",
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    }
                });
                $('#modalArea').modal('hide');
                $('#area_data').DataTable().ajax.reload();
            }
        },
    });
}

$(document).ready(function () {

    init();
    validar();

    var dataTable = $('#area_data').DataTable({
        "pageLength": 10,
        'aoColumnDefs': [{
                'bSortable': false,
                'aTargets': ['nosort'],
        }],
        "buttons": [
        {
            "extend": 'excelHtml5',
            "text": 'Exportar Excel',
            "title": 'Areas',
            "exportOptions": {
                "columns": ':visible'
            }
        },
        {
            extend: 'pdfHtml5',
            text: 'Exportar PDF',
            title: 'Reporte de Areas',
            orientation: 'portrait',
            pageSize: 'A4',
            exportOptions: {
                // Excluir la última columna (la de "Opciones")
                columns: function (idx, data, node) {
                    const totalCols = $('#area_data thead th').length;
                    return idx < totalCols - 1;
                }
            },
            customize: function (doc) {
                doc.pageMargins = [40, 60, 40, 60];
            
                // Título centrado con estilo
                doc.content.splice(0, 1, {
                    text: 'Reporte de Areas',
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
        // columnDefs:[
        //     {type:'date-dd-mm-yyyy',aTargets:[5]}
        // ],
        "aoColumns": [
            null,
            null,
            null,
            null
        ],
        "ajax":{
            url: '../../controller/AreaController.php?op=listar',
            type : "post",
            dataType : "json",	
            data: function (d) {
                d.estadoSistema = $('#filtroEstadoSistema').val();
            },				
            error: function(e){
                console.log(e.responseText);	
            }
        },
        "scrollX": false,
        "autoWidth": false,
        "paging": true,
        "order": false,
        "bLengthChange": false,
        "dom": 'B<"top">ct<"top"p><"clear">',
        "language": {
            "paginate": {
                "previous": "Anterior",
                "next": "Siguiente"
            },
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "zeroRecords": "No se encontraron resultados",
        }
    });

    $("#buscador").on("keyup", function () {
        const column = $("#filtro").val();
        const value = this.value;

        if (column !== "") {
            dataTable.search("").columns().search("");

            dataTable.column(column).search(value).draw();
        } else {
            dataTable.columns().search("");
            dataTable.search(value).draw();
        }
    });

    $('#filtro').on('change', function () {
        dataTable.search("").columns().search("");
        $("#buscador").trigger("keyup");
    });

    $('#filtroEstadoSistema').on('change', function () {
        dataTable.ajax.reload();
    });
   
    //Ocultar botones
    $('.dt-button').hide();
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

    
    //Para limpiar el formulario
    $('#modalArea').on('hidden.bs.modal', function () {
        $('#formArea')[0].reset();
        $('#btnCancelar').click();
    });

    //Para cuando se quiere crear un nuevo registro, se genera un codigo unico y se pone el id en -1 para que se pueda registrar
    // Y no actualice el registro existente
    $('#btnnuevo').click(function(){
        $.post("../../controller/AreaController.php?op=crearCodigo",function(data, status){
            $('#codigoArea').val(data);
            $('#idArea').val(-1);
        });
    });



    // Cuando se abre el modal
    $('#modalArea').on('shown.bs.modal', function() {
        $('#modalArea').removeAttr('inert');
        $('#modalArea').removeAttr('aria-hidden');
    });

    // Cuando se cierra el modal
    $('#modalArea').on('hidden.bs.modal', function() {
        $('#modalArea').attr('inert', '');
        $('#modalArea').attr('aria-hidden', 'true');
    });

});

function generarCardsDesdeDataTable() {
    const table = $('#area_data').DataTable();
    const $container = $('#cardContainer');
    $container.empty();

    // Solo muestra los datos de la página actual (paginada)
    table.rows({ page: 'current', search: 'applied' }).every(function () {
        const data = this.data();

        const card = `
        <div class="card-user">
          <h5>${data[0]}</h5>
          <p><strong>Nombre:</strong> ${data[1]}</p>
          <p><strong>Estado:</strong> ${data[2]}</p>
          <div class="btn-group">
            ${data[3]}
          </div>
        </div>
      `;

        $container.append(card);
    });
}

$(document).ready(function () {

    const table = $('#area_data').DataTable(); // no reconfigures aquí
    // Mover el paginador al nuevo contenedor
    // function moverPaginador() {
    //     $('#paginadorExtra').html($('#usuario_data_paginate'));
    // }

    function moverPaginador() {
        $('#area_data_paginate').detach().appendTo('#paginadorExtra');
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

//FUNCIONES PARA EDITAR, HABILITAR Y DESHABILITAR

function editar(id){
    
    $('#modalArea').modal('show');
    $('#idArea').val(id);

    $.post("../../controller/AreaController.php?op=mostrar", {id : id}, function (data) {
        data = JSON.parse(data);
        $('#idArea').val(data.id_area);
        $('#codigoArea').val(data.codigo);
        $('#nombreArea').val(data.nombre);
    });
}

function habilitar(id){
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Aceptas revertirlo?!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, lo voy a revertir!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post("../../controller/AreaController.php?op=habilitar", {area_id : id}, function (data) {
            }); 

            Swal.fire(
                'Habilitado!',
                'El area ha sido habilitado.',
                'success'
            ).then((result) => {
                if (result.isConfirmed) {
                    $('#area_data').DataTable().ajax.reload();	
                }
            });
        }
    });
}

function eliminar(id){
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Podras revertirlo, no te preocupes!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, deshabilitalo!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post("../../controller/AreaController.php?op=eliminar", {area_id : id}, function (data) {
            }); 

            Swal.fire(
                'Eliminado!',
                'El area ha sido deshabilitada.',
                'success'
            ).then((result) => {
                if (result.isConfirmed) {
                    $('#area_data').DataTable().ajax.reload();	
                }
            });
        }
    });
}

function ver(codigo, nombre){
    //aora un swal para ver la información
    
    Swal.fire({
        title: 'Información',
        text: "Código: " + codigo + "\nNombre: " + nombre,
        icon: 'info',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Aceptar'
    });
}



