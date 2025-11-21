$(document).ready(function () {

    
    var tick_id = getUrlParameter('idTicket');

    //existe el ticker?
    validarTicket(tick_id);

    

    
    listardetalle(tick_id);


    $('#tickd_descripusu').summernote({
        height: 300,
        placeholder: 'Escribe tu mensaje o inserta una imagen...',
        dialogsInBody: true,
        callbacks: {
            onInit: function() {
            $('#tickd_descripusu').summernote('disable');
            }
        },
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['insert', ['link', 'picture']],
        ]
    });
  
    $('#tickd_descrip').summernote({
        height: 250,
        lang: 'es-ES', // 👈 idioma español
        placeholder: 'Escriba su respuesta aquí...',
        dialogsInBody: true,
        lang: "es-ES",
        callbacks: {
            onImageUpload: function(image) {
                console.log("Image detect...");
                myimagetreat(image[0]);
            },
            onPaste: function (e) {
                console.log("Text detect...");
            }
        },
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['insert', ['link', 'picture']],
        ]
    });

    // function myimagetreat(file) {
    //     var reader = new FileReader();
    //     reader.onload = function(e) {
    //         // Inserta la imagen directamente en Summernote
    //         $('#tickd_descrip').summernote('insertImage', e.target.result, function($image) {
    //             $image.attr('alt', file.name); // opcional: agregar nombre
    //             $image.css('width', '35%');   // 👈 fuerza a 25% del tamaño
    //             $image.css('height', 'auto'); // mantiene la proporción
    //         });
    //     };
    //     reader.readAsDataURL(file);
    // }

    function myimagetreat(file) {
    
        // 1. Tu API Key de ImgBB
        var apiKey = '3342be8b6ae4468fbbf22cfa512fcf8c';

        // 2. Creamos un objeto FormData para enviar el archivo
        var formData = new FormData();
        formData.append('image', file);
        formData.append('key', apiKey); // Agregamos la API key

        // 3. Usamos jQuery.ajax para subir la imagen
        // (Usamos ajax de jQuery ya que estás usando Summernote, que depende de jQuery)
        $.ajax({
            url: 'https://api.imgbb.com/1/upload',
            type: 'POST',
            data: formData,
            contentType: false, // Requerido para enviar archivos
            processData: false, // Requerido para enviar archivos
            
            // 4. En caso de éxito (la imagen se subió)
            success: function(response) {
                if (response.success) {
                    // Obtenemos la URL de la imagen subida
                    var imageUrl = response.data.url;

                    // 5. Insertamos la imagen en Summernote usando la URL
                    $('#tickd_descrip').summernote('insertImage', imageUrl, function($image) {
                        $image.attr('alt', file.name); // Tu código original
                        $image.css('width', '35%');  // Tu código original
                        $image.css('height', 'auto'); // Tu código original
                    });

                } else {
                    // Manejo de error si ImgBB devuelve un error
                    console.error('Error al subir la imagen a ImgBB:', response.error.message);
                    alert('Hubo un error al subir la imagen.');
                }
            },
            
            // 5. En caso de error de red (no se pudo conectar)
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error de red al subir la imagen:', textStatus, errorThrown);
                alert('Error de red al intentar subir la imagen.');
            }
        });
    }

    //Otro para subir imaenes con una api
    //Aun no se ara 

    //Esta la tabla de los docuemntos q se ancalaron para evidneciar el problema, no es obligatorio
   tabla=$('#documentos_data').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        dom: 'Bfrtip',
        "searching": true,
        lengthChange: false,
        colReorder: true,
        buttons: [
    {
        extend: 'copyHtml5',
        text: '<i class="fas fa-copy"></i> Copiar',
        className: 'btn btn-primary me-1 bg-primary text-white rounded-3'
    },
    {
        extend: 'pdfHtml5',
        text: '<i class="fas fa-file-pdf"></i> PDF',
        className: 'btn btn-danger me-1 bg-danger text-white rounded-3',
    },
    //Con bootstrap
],
        "ajax":{
            url: './../../controller/documento.php?op=listar',
            type : "POST",
            data : {tick_id:tick_id},
            dataType : "json",
            error: function(e){
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "responsive": true,
        "bInfo":true,
        "iDisplayLength": 10,
        "autoWidth": false,
        "language": {
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }
    }).DataTable();
    
    
    $("#cam_soporte").keyup(function(){
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
            $("#nuevo_id_asig").val(0);
        }
    });

    $(document).on("click", ".opcion", function(){
        let nombre = $(this).text();
        let id = $(this).data("id");
        let dni = $(this).data("dni");

        $("#cam_soporte").val(nombre);  // lo pone en el input principal
        $("#nuevo_id_asig").val(id);        // guarda el ID en hidden
        $("#resultados").hide();     // oculta lista
        $("#nom_asig").val(nombre);  // lo pone en el input principal
        $("#dni_asig").val(dni);        // guarda el ID en hidden
    });

    $('#btnAsignar').click(function(){
        let tick_id = getUrlParameter('idTicket');
        let usu_id = $('#nuevo_id_asig').val();
        let nom_asig = $('#nom_asig').val();
        let dni_asig = $('#dni_asig').val();
        
        if(usu_id == 0){
            Swal.fire({
                icon: "warning",
                title: "Advertencia!",
                text: "Falta seleccionar un soporte",
                customClass: {
                    confirmButton: 'btn btn-primary'
                }
            });
        }else{
            Swal.fire({
                title: "¿Estas seguro que quieres reasignar el ticket?",
                text: "A " + nom_asig + "- " + dni_asig + "?",
                showCancelButton: true,
                confirmButtonText: 'Sí',
                cancelButtonText: 'No',
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-danger'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post("../../controller/ticketController.php?op=asignar", { tick_id : tick_id,usu_id : usu_id }, function (data) {
                        console.log("Se reasigno el ticket...");
                    });
                    
                    listardetalle(tick_id);

                    Swal.fire({
                        title: "Correcto!",
                        text: "Ticket reasignado correctamente.",
                        type: "success",
                        confirmButtonClass: "btn-success"
                    });
                    
                }
            });
        }
    });

    
    //aora vamos acer en tiempo real la conversación
    setInterval(function(){
        //obtnerneNuevosMensajes(tick_id);
        actualizarConversacionTicket(tick_id);
    }, 2000);

    // function loopConversacion() {
    //     actualizarConversacionTicket(tick_id).then(() => {
    //         setTimeout(loopConversacion, 2000);
    //     });
    // }
    // loopConversacion();


});

//Funciones a utilizar:
var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};



//Se va a utilziar
$(document).on("click","#btnenviar", function(){
    var tick_id = getUrlParameter('idTicket');
    var usu_id = $('#usuario_idxd').val();
    var tickd_descrip = $('#tickd_descrip').val();

    if ($('#tickd_descrip').summernote('isEmpty')){
        Swal.fire({
            icon: "warning",
            title: "Advertencia!",
            text: "Falta Descripción",
            customClass: {
                confirmButton: 'btn btn-primary'
            }
        });
    }else{
        $.post("../../controller/ticketController.php?op=insertdetalle", { tick_id:tick_id,usu_id:usu_id,tickd_descrip:tickd_descrip}, function (data) {
            listardetalle(tick_id);
            $('#tickd_descrip').summernote('reset');
            Swal.fire({
                icon: "success",
                title: "Correcto!",
                text: "Registrado Correctamentex",
                customClass: {
                    confirmButton: 'btn btn-primary'
                }
            });

            
            console.log("Entrando aquí.")

            $.post("../../controller/ticketController.php?op=mostrar", { tick_id:tick_id}, function (data) {
                data = JSON.parse(data);
                var id_usuario_asig = data.id_asig;
                var usuario_creador = data.usu_id;
                var usuario_logueado = usu_id;

                if(id_usuario_asig != null){

                    if(usuario_creador != usuario_logueado){
                        $.post("../../controller/notificacionesController.php?op=insert", { tick_id:tick_id,usu_id:usuario_creador}, function (data) {
                            console.log("Esperando... 1");
                        });
                    }else if(usuario_creador == usuario_logueado && id_usuario_asig != usuario_logueado){
                        $.post("../../controller/notificacionesController.php?op=insert", { tick_id:tick_id,usu_id:id_usuario_asig}, function (data) {
                            console.log(data);
                            console.log("Esperando... 2");
                        });
                    }

                }else{
                    if(usuario_creador != usuario_logueado){
                        $.post("../../controller/notificacionesController.php?op=insert", { tick_id:tick_id,usu_id:usuario_creador}, function (data) {
                            console.log("Esperando... 1");
                        });
                    }
                }

            });

            
        }); 
    }
});


//Aun no se utiliza
$(document).on("click","#btncerrarticket", function(){
    Swal.fire({
        title: '¿Seguro?',
        icon: 'warning',
        text: '¿Estas seguro de cerrar el ticket?',
        showCancelButton: true,
        confirmButtonText: 'Sí',
        cancelButtonText: 'No',
        customClass: {
          confirmButton: 'btn btn-success',
          cancelButton: 'btn btn-danger'
        }
      }).then((result) => {
        if (result.isConfirmed) {
            var tick_id = getUrlParameter('idTicket');
            var usu_id = $('#usuario_idxd').val();
            $.post("../../controller/ticketController.php?op=update", { tick_id : tick_id,usu_id : usu_id }, function (data) {
                console.log("Se cerro el ticket...");
            });
            
            listardetalle(tick_id);


            // $.post("../../controller/emailController.php?op=ticket_cerrado", {tick_id : tick_id}, function (data) {

            // });

            //esto que ace

            Swal.fire({
                title: "HelpDesk!",
                text: "Ticket Cerrado correctamente.",
                type: "success",
                confirmButtonClass: "btn-success"
            });
        }
      });
});


//Se esta utilizando
function listardetalle(tick_id){
    $.post("./../../controller/ticketController.php?op=listardetalle", { tick_id : tick_id }, function (data) {
        $('#lbldetalle').html(data);
    }); 

    $.post("./../../controller/ticketController.php?op=mostrar", { tick_id : tick_id }, function (data) {

        var usu_id_logueado = $('#usuario_idxd').val()
        var rol_id_logueado = $('#rol_idxd').val()

        
        data = JSON.parse(data);

        if((usu_id_logueado == data.usu_id) || (rol_id_logueado == 1 || rol_id_logueado == 2) ){
            $('#lblestado').html(data.tick_estado);
            if(data.tick_estado_texto == "Cerrado"){
                $('#lblestado').addClass('badge bg-danger text-white rounded-3 m-1');
            }else{
                $('#lblestado').addClass('badge bg-success text-white rounded-3 m-1');
            }
            $('#lblnomusuario').html(data.usu_nom +' '+data.usu_ape);
            $('#lblfechcrea').html(data.fech_crea);
            
            $('#lblnomidticket').html("Detalle Ticket - "+data.tick_id);
    
            $('#cat_nom').val(data.cat_nom);
            $('#prioridad_nom').val(data.tick_prioridad);
            $('#tick_titulo').val(data.tick_titulo);
            $('#tickd_descripusu').summernote ('code',data.tick_descrip);
    
            //Añadir redondly si el ticket esta cerrada
    
            console.log( data.tick_estado_texto);
            if (data.tick_estado_texto == "Cerrado"){
                $('#pnldetalle').hide();
                $('#cam_soporte').attr('readonly', true);
                $('#cam_soporte').val('El ticket ya esta cerrado');
                $('#btnAsignar').attr('disabled', true);
            }else{
                $('#cam_soporte').attr('readonly', false);
                $('#btnAsignar').attr('disabled', false);
            }
        }else{
            console.log("No tienes permiso para ver este ticket");
            window.location.href = "./../Login/login.php";
        }
    }); 
}

//actualizar el label de conversación
// function actualizarConversacionTicket(tick_id) {
//     return $.post(
//         "./../../controller/ticketController.php?op=listardetalle",
//         { tick_id: tick_id },
//         function (data) {
//             $('#lbldetalle').html(data);
//         }
//     );
// }

function actualizarConversacionTicket(tick_id) {
    $.post("./../../controller/ticketController.php?op=listardetalle", { tick_id : tick_id }, function (data) {
        $('#lbldetalle').html(data);
    }); 
}



function validarTicket(tick_id){
    $.post("./../../controller/ticketController.php?op=mostrar", { tick_id : tick_id}, function (data) {
        data = JSON.parse(data);
        if(data.tick_id == tick_id){
            console.log("Ticket encontrado");
        }else{
            window.location.href = "./../Login/login.php";
        }
    }); 
}


//En un futuro se implementara, por ahora no se utiliza
function obtnerneNuevosMensajes(tick_id){
    //obtner el mensaje id data-id
    var id = $('#lbldetalle').find('.mensaje').last().data('id');
    var ticket_id = tick_id;
    $.post("./../../controller/ticketController.php?op=listardetalleNuevos", { tick_id : ticket_id, id_detalle : id }, function (data) {
        //Aca añadiremos a la tabla de conversación
        //$('#lbldetalle').append(data);
        
        if(data != 0){
            data = JSON.parse(data);
            console.log(data);   
        }else{
            console.log("No hay nuevos mensajes");
        }

        //añadir de manera dinámica otro div con mensaje y fecha
        
    }); 
    
}
