$(document).ready(function () {
    $('#tick_descrip').summernote({
        height: 200,
        lang: 'es-ES', // 👈 idioma español
        placeholder: 'Escriba su respuesta aquí...',
        dialogsInBody: true,
        // callbacks: {
        //     onImageUpload: function(files) {
        //         const editor = $(this);
        //         for (let i = 0; i < files.length; i++) {
        //             const reader = new FileReader();
        //             reader.onloadend = function () {
        //                 editor.summernote('insertImage', reader.result);
        //             };
        //             reader.readAsDataURL(files[i]);
        //         }
        //     }
        // }
        height: 150,
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
    //         $('#tick_descrip').summernote('insertImage', e.target.result, function($image) {
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
                    $('#tick_descrip').summernote('insertImage', imageUrl, function($image) {
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


     //Ya esta
    $.post("../../controller/CategoriaController.php?op=comboCategoria",function(data, status){
        $('#id_categoria').html('<option value="">Seleccione</option>' + data);
    });
});




function init(){
    $("#ticket_form").on("submit",function(e){
        guardaryeditar(e);	
    });
    
}

function guardaryeditar(e){
    e.preventDefault();
    var formData = new FormData($("#ticket_form")[0]);
    if ($('#tick_descrip').summernote('isEmpty') || $('#tick_titulo').val()==''){
        Swal.fire({
            icon: "warning",
            title: "Advertencia!",
            text: "Campos Vacios",
            customClass: {
                confirmButton: 'btn btn-primary'
            }
        });
    }else{
        // var totalfiles = $('#fileElem').val().length;
        var totalfiles = $('#fileElem')[0].files.length;

        let text = '';
        for (var i = 0; i < totalfiles; i++) {
            formData.append("files[]", $('#fileElem')[0].files[i]);
        }

        $.ajax({
            url: "../../controller/ticketController.php?op=insert",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data){
                data = JSON.parse(data);
                console.log(data[0].tick_id);

                //Ver como funciona
                
                $.post("../../controller/emailController.php?op=ticket_abierto", {tick_id : data[0].tick_id}, function (data) {
                    console.log(data);
                });

                $('#tick_titulo').val('');
                $('#tick_descrip').summernote('reset');
                $('#fileElem').val('');
                $('#tick_prioridad').val('');
                $('#id_categoria').val('');

                Swal.fire({
                    icon: "success",
                    title: "Correcto!",
                    text: "Registrado Correctamente",
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    }
                });
            }
        });
    }
}

init();