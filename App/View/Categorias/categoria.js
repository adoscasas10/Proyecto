function validar() {
    var codigoCategoria = $('#codigo');
    var nombreCategoria = $('#nombre');
    var descripcionCategoria = $('#descripcion');

    $('#btnCancelar').click(function(){
        $('#formCategoria')[0].reset();
        codigoCategoria.css("border-color", "#3F454B");
        nombreCategoria.css("border-color", "#3F454B");
        descripcionCategoria.css("border-color", "#3F454B");
    });

    nombreCategoria.keyup(function(){
        var expression = /^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ()]+( [a-zA-ZáéíóúÁÉÍÓÚñÑüÜ()]+)*$/; 
        var valor = $(this).val();
        if(!expression.test(valor)){
            nombreCategoria.css("border-color", "#F00");
        }else{
            nombreCategoria.css("border-color", "#090");
        }
        if(valor.length === 0 ){
            nombreCategoria.css("border-color", "#3F454B");
        }
    });

    codigoCategoria.keyup(function(){
        //Solo deben ser 5 caracteres
        var expression = /^[a-zA-Z0-9]{7}$/; 
        var valor = $(this).val();
        if(!expression.test(valor)){
            codigoCategoria.css("border-color", "#F00");
        }else{
            codigoCategoria.css("border-color", "#090");
        }
        if(valor.length === 0 ){
            codigoCategoria.css("border-color", "#3F454B");
        }
    });

    descripcionCategoria.keyup(function(){
        var expression = /^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ()]+( [a-zA-ZáéíóúÁÉÍÓÚñÑüÜ()]+)*$/; 
        var valor = $(this).val();
        if(!expression.test(valor)){
            descripcionCategoria.css("border-color", "#F00");
        }else{
            descripcionCategoria.css("border-color", "#090");
        }
        if(valor.length === 0 ){
            descripcionCategoria.css("border-color", "#3F454B");
        }
    });
    
}

function init(){
    $('#formCategoria').on('submit', function(e){
        e.preventDefault();
        
        var errorDetectado = false;
        var mensaje = "";

            
        var codigoCategoria = $('#codigo').val();
        var nombreCategoria = $('#nombre').val();
        var descripcionCategoria = $('#descripcion').val();

        if(!/^[a-zA-Z0-9]{7}$/.test(codigoCategoria)){
            errorDetectado = true;
            mensaje = "El código debe tener 7 letras y es obligatorio";
        }else if(!/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ()]+( [a-zA-ZáéíóúÁÉÍÓÚñÑüÜ()]+)*$/.test(nombreCategoria)){
            errorDetectado = true;
            mensaje = " El nombre debe contener solo letras y tener 50 caracteres y es obligatorio";
        }else if(!/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ()]+( [a-zA-ZáéíóúÁÉÍÓÚñÑüÜ()]+)*$/.test(descripcionCategoria)){
            errorDetectado = true;
            mensaje = " La descripción debe contener solo letras y tener 255 caracteres y es obligatorio";
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
    var formData = new FormData($('#formCategoria')[0]);
    $.ajax({
        url: '../../controller/CategoriaController.php?op=guardaryeditar',
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
                $('#formCategoria')[0].reset();
                Swal.fire({
                    title: "Correcto!",
                    text: data,
                    icon: "success",
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    }
                });
                $('#modalCategoria').modal('hide');
                $('#categoria_data').DataTable().ajax.reload();
            }
        },
    });
}

$(document).ready(function () {


    validar();
    init();
    
    var dataTable = $('#categoria_data').DataTable({
        "pageLength": 10,
        'aoColumnDefs': [{
                'bSortable': false,
                'aTargets': ['nosort'],
        }],
        "buttons": [
        {
            "extend": 'excelHtml5',
            "text": 'Exportar Excel',
            "title": 'Categorias',
            "exportOptions": {
                "columns": ':visible'
            }
        },
        {
            extend: 'pdfHtml5',
            text: 'Exportar PDF',
            title: 'Reporte de Categorias',
            orientation: 'portrait',
            pageSize: 'A4',
            exportOptions: {
                // Excluir la última columna (la de "Opciones")
                columns: function (idx, data, node) {
                    const totalCols = $('#categoria_data thead th').length;
                    return idx < totalCols - 1;
                }
            },
            customize: function (doc) {
                doc.pageMargins = [40, 60, 40, 60];
            
                // Título centrado con estilo
                doc.content.splice(0, 1, {
                    text: 'Reporte de Categorias',
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
            null,
            null
        ],
        "ajax":{
            url: '../../controller/CategoriaController.php?op=listar',
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


    $('#filtroEstadoSistema').on('change', function () {
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

    $('#btnPdf').on('click', function () {
        // Forzar un redraw antes de exportar
        dataTable.draw();

        // Esperar para asegurar sincronización antes de exportar
        setTimeout(() => {
            dataTable.button('.buttons-pdf').trigger();
        }, 200);
    });

    //Para limpiar el formulario
    $('#modalCategoria').on('hidden.bs.modal', function () {
        $('#formCategoria')[0].reset();
        $('#btnCancelar').click();
    });

    // Cuando se abre el modal
    $('#modalCategoria').on('shown.bs.modal', function() {
        $('#modalCategoria').removeAttr('inert');
        $('#modalCategoria').removeAttr('aria-hidden');
    });

    // Cuando se cierra el modal
    $('#modalCategoria').on('hidden.bs.modal', function() {
        $('#modalCategoria').attr('inert', '');
        $('#modalCategoria').attr('aria-hidden', 'true');
    });

    $('#modalCategoria').on('hidden.bs.modal', function () {
        $('#formCategoria')[0].reset();
        $('#div_estado').attr('hidden', true);
    });

    //Boton nuevo
    $('#btnnuevo').click(function(){
        $.post("../../controller/CategoriaController.php?op=crearCodigo",function(data, status){
            $('#codigo').val(data);
            $('#idCategoria').val(-1);
        });
    });

});

function generarCardsDesdeDataTable() {
    const table = $('#categoria_data').DataTable();
    const $container = $('#cardContainer');
    $container.empty();

    // Solo muestra los datos de la página actual (paginada)
    table.rows({ page: 'current', search: 'applied' }).every(function () {
        const data = this.data();

        const card = `
        <div class="card-user">
          <h5>${data[0]}</h5>
          <p><strong>Nombre:</strong> ${data[1]}</p>
          <p><strong>Descripcion:</strong> ${data[2]}</p>
          <p><strong>Estado:</strong> ${data[3]}</p>
          <div class="btn-group">
            ${data[4]}
          </div>
        </div>
      `;

        $container.append(card);
    });
}

$(document).ready(function () {

    const table = $('#categoria_data').DataTable(); // no reconfigures aquí
    // Mover el paginador al nuevo contenedor
    // function moverPaginador() {
    //     $('#paginadorExtra').html($('#usuario_data_paginate'));
    // }

    function moverPaginador() {
        $('#categoria_data_paginate').detach().appendTo('#paginadorExtra');
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
    
    $('#modalCategoria').modal('show');
    $('#idCategoria').val(id);

    $.post("../../controller/CategoriaController.php?op=mostrar", {id : id}, function (data) {
        data = JSON.parse(data);
        $('#idCategoria').val(data.id_categoria);
        $('#codigo').val(data.cod_categoria);
        $('#descripcion').val(data.descripcion);
        $('#nombre').val(data.nombre);
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
            $.post("../../controller/CategoriaController.php?op=habilitar", {categoria_id : id}, function (data) {
            }); 

            Swal.fire(
                'Habilitado!',
                'La categoria ha sido habilitado.',
                'success'
            ).then((result) => {
                if (result.isConfirmed) {
                    $('#categoria_data').DataTable().ajax.reload();	
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
            $.post("../../controller/CategoriaController.php?op=eliminar", {categoria_id : id}, function (data) {
            }); 

            Swal.fire(
                'Eliminado!',
                'La categoria ha sido deshabilitada.',
                'success'
            ).then((result) => {
                if (result.isConfirmed) {
                    $('#categoria_data').DataTable().ajax.reload();	
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