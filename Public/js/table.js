function soloSoporte(){
    //cuando se activa el combobox de area, solo se debe mostrar los roles de soporte y administrador
    $('#area').change(function(){
        var area = $(this).val();
        if(area == "1"){
            //falta el seleccione
            $('#rol').html('<option value="">Seleccione</option><option value="2">Soporte Técnico</option><option value="1">Administrador</option>');
        }else{
            $('#rol').html('<option value="">Seleccione</option><option value="3">Usuario</option>');
        } 
    });
}

$(document).ready(function () {
    soloSoporte();
    var dataTable = $('#usuario_data').DataTable({
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
            null,
            null,
            null,
            null,
            null,
            null
        ],
        "ajax":{
            url: '../../controller/UsuarioController.php?op=listar',
            type : "post",
            dataType : "json",	
            data: function (d) {
                d.estadoSistema = $('#filtroEstadoSistema').val();
            },				
            error: function(e){
                console.log(e.responseText);	
            }
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
    
    //Ya esta
    $.post("../../controller/AreaController.php?op=comboArea",function(data, status){
        $('#area').html('<option value="">Seleccione</option>' + data);
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

    $('#filtroEstadoSistema').on('change', function () {
        //dataTable.search("").columns().search("");
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

    

    //Si quiero q cuando se cierre el moda se reseteen los datos:
    $('#modalEditarUsuario').on('hidden.bs.modal', function () {
        $('#formEditarUsuario')[0].reset();
    });

    $('#formEditarUsuario').submit(function(e){
        e.preventDefault(); // prevenimos el envío

        var errorDetectado = false;
        var mensaje = "";

        var nombre = $('#nombre').val();
        var apellido = $('#apellido').val();
        var usuario = $('#usuario').val();
        var correo = $('#correo').val();
        var telefono = $('#telefono').val();
        var dni = $('#dni').val();

        if (!/^[a-zA-Z]+( [a-zA-Z]+)*$/.test(nombre)) {
            errorDetectado = true;
            mensaje = "El nombre debe contener solo letras y tener 50 caracteres";
        } else if (!/^[a-zA-Z]+( [a-zA-Z]+)*$/.test(apellido)) {
            errorDetectado = true;
            mensaje = "El apellido debe contener solo letras y tener 50 caracteres";
        } else if (!/^[a-zA-Z0-9_]{6,}$/.test(usuario)) {
            errorDetectado = true;
            mensaje = "El usuario debe contener letras, números y guiones bajos, y tener minimo 6 caracteres y maximo 16";
        } else if (!/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,75}$/.test(correo)) {
            errorDetectado = true;
            mensaje = "El correo es inválido";
        } else if (!/^[0-9]{9}$/.test(telefono)) {
            errorDetectado = true;
            mensaje = "El teléfono debe tener 9 números";
        } else if (!/^[0-9]{8}$/.test(dni)) {
            errorDetectado = true;
            mensaje = "El DNI debe tener 8 números";
        }

        if (errorDetectado) {
            Swal.fire({
                title: "Error!",
                text: mensaje,
                icon: "error",
                customClass: {
                    confirmButton: 'btn btn-primary'
                }
            });
        } else {
            EditarUsuario(e);
        }

    });

    function EditarUsuario(e){
        e.preventDefault();
        var formData = new FormData($("#formEditarUsuario")[0]);
        $.ajax({
            url: "../../controller/UsuarioController.php?op=guardaryeditar",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(datos) {
                console.log(datos);
                
                // Si la respuesta contiene la palabra "Error" o "Faltan"
                if (datos.includes("Error") || datos.includes("Faltan") || datos.includes("existe")) {
                    Swal.fire({
                        title: "Error!",
                        text: datos,
                        icon: "error",
                        customClass: {
                            confirmButton: 'btn btn-primary'
                        }
                    });
                } else {
                    $('#formEditarUsuario')[0].reset();


                    Swal.fire({
                        title: "Correcto!",
                        text: datos,
                        icon: "success",
                        customClass: {
                            confirmButton: 'btn btn-primary'
                        }
                    });
                    
                    $("#modalEditarUsuario").modal('hide');
                    $('#usuario_data').DataTable().ajax.reload();
                }
            }
            
        }); 
    }

});

function generarCardsDesdeDataTable() {
    const table = $('#usuario_data').DataTable();
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
          <p><strong>Usuario:</strong> ${data[4]}</p>
          <p><strong>Rol:</strong> ${data[5]}</p>
          <p><strong>Área:</strong> ${data[6]}</p>
          <p><strong>Estado:</strong> ${data[7]}</p>
          <div class="btn-group XD">
            ${data[8]}
          </div>
        </div>
      `;

        $container.append(card);
    });
}

$(document).ready(function () {

    const table = $('#usuario_data').DataTable(); // no reconfigures aquí
    // Mover el paginador al nuevo contenedor
    // function moverPaginador() {
    //     $('#paginadorExtra').html($('#usuario_data_paginate'));
    // }

    function moverPaginador() {
        $('#usuario_data_paginate').detach().appendTo('#paginadorExtra');
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

//Eliminar
function eliminarUsuario(id, estado) {

    if(estado == "2" || estado == "0"){
        Swal.fire({
            title: 'Error!',
            text: "No puedes eliminar un usuario que aun falta verificar o que esta deshabilitado",
            icon: 'error',
            customClass: {
                confirmButton: 'btn btn-primary'
            }
        });
    }else{
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Podras revertirlo, no te preocupes!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, bórralo!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post("../../controller/UsuarioController.php?op=eliminar", {usu_id : id}, function (data) {
                }); 
    
                Swal.fire(
                    'Eliminado!',
                    'El usuario ha sido eliminado.',
                    'success'
                ).then((result) => {
                    if (result.isConfirmed) {
                        $('#usuario_data').DataTable().ajax.reload();	
                    }
                });
            }
        });
    }

    

}

function habilitar(id) {
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
            $.post("../../controller/UsuarioController.php?op=habilitar", {usu_id : id}, function (data) {
            }); 

            Swal.fire(
                'Habilitado!',
                'El usuario ha sido habilitado.',
                'success'
            ).then((result) => {
                if (result.isConfirmed) {
                    $('#usuario_data').DataTable().ajax.reload();	
                }
            });
        }
    });
}

//EDITAR
function editar(usu_id){

    const id = usu_id;
    $('#modalEditarUsuario').modal('show');
    
    $.post("../../controller/UsuarioController.php?op=mostrar", {id : id}, function (data) {
        console.log(data);
        data = JSON.parse(data);
        console.log("///////////////////////////");
        console.log(data);
        $('#idUsuario').val(data.id_usuario);
        $('#dni').val(data.dni);
        $('#nombre').val(data.nombre);
        $('#apellido').val(data.apellido);
        $('#correo').val(data.correo);
        $('#usuario').val(data.usuario);
        $('#area').val(data.id_area)
        $('#telefono').val(data.telefono);


        //otnenemos el valro de lo opculto
        var rol_loguado = $('#rol_loguado').val();
        var id_usuario_logeado = $('#id_usuario_logeado').val();

        //vamos a añadir una condición para evitar que el usuario pueda cambiar el rol y el area de el mismo xq no tiene sentido.
        console.log(id_usuario_logeado)
        console.log(data.id_usuario)
        if((data.id_usuario == id_usuario_logeado) || (rol_loguado == 1 && data.id_usuario != 1)){
            $('#areaContainer').attr('hidden', true);
            $('#rolContainer').attr('hidden', true);
            
        }else{
            $('#areaContainer').attr('hidden', false);
            $('#rolContainer').attr('hidden', false);
        }



        var area = data.id_area;
        if(area == "1"){
            //falta el seleccione
            $('#rol').html('<option value="">Seleccione</option><option value="2">Soporte Técnico</option><option value="1">Administrador</option>');
        }else{
            $('#rol').html('<option value="">Seleccione</option><option value="3">Usuario</option>');
        } 

        $('#rol').val(data.id_rol)
    }); 
}

