//Esto inicia cuando el documento este listo, o sea cuando la pagina este lista 
$(document).ready(function () {
    // validar();
    init(1)

    function validar(){
        var nombre = $('#nombre');
        var apellido = $('#apellido');
        var usuario = $('#usuario');
        var correo = $('#correo');
        var telefono = $('#telefono');
        var dni = $('#dni');
        
        nombre.keyup(function(){
            var expression = /^[a-zA-Z]+( [a-zA-Z]+)*$/; 
            var valor = $(this).val();
            if(!expression.test(valor)){
                nombre.css("border-color", "#F00");
            }else{
                nombre.css("border-color", "#090");
            }
            if(valor.length === 0 ){
                nombre.css("border-color", "#3F454B");
            }
        });
    
        apellido.keyup(function(){
            var expression = /^[a-zA-Z]+( [a-zA-Z]+)*$/;
            var valor = $(this).val();
            if(!expression.test(valor)){
                apellido.css("border-color", "#F00");
            }else{
                apellido.css("border-color", "#090");
            }
            if(valor.length === 0){
                apellido.css("border-color", "#3F454B");
            }
        });
    
        usuario.keyup(function(){
            var expression = /^[a-zA-Z0-9_]{6,}$/; // Esto hace que el usuario tenga solo 16 caracteres y que solo pueda contener letras, números y guiones bajos
            var valor = $(this).val();
            if(!expression.test(valor)){
                usuario.css("border-color", "#F00");
            }else{
                usuario.css("border-color", "#090");
            }
            if(valor.length === 0){
                usuario.css("border-color", "#3F454B");
            }
        });
    
        correo.keyup(function(){
            var expression = /^[a-zA-Z0 -9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,75}$/;
            var valor = $(this).val();
            if(!expression.test(valor)){
                correo.css("border-color", "#F00");
            }else{
                correo.css("border-color", "#090");
            }
            if(valor.length === 0){
                correo.css("border-color", "#3F454B");
            }
        });
    
        telefono.keyup(function(){
            var expression = /^[0-9]{9}$/;
            var valor = $(this).val();
            if(!expression.test(valor)){
                telefono.css("border-color", "#F00");
            }else{
                telefono.css("border-color", "#090");
            }
            if(valor.length === 0){
                telefono.css("border-color", "#3F454B");
            }
        });
    
        dni.keyup(function(){
            var expression = /^[0-9]{8}$/;//Esto hace que el DNI tenga solo 8 caracteres
            var valor = $(this).val();
            if(!expression.test(valor)){
                dni.css("border-color", "#F00");
            }else{
                dni.css("border-color", "#090");
            }
            if(valor.length === 0){
                dni.css("border-color", "#3F454B");
            }
        });
        
    }

    validar();
    
    //fornulario
    var formEditar = $('#formEditarUsuario');
    formEditar.submit(function (e) {

        e.preventDefault(); // prevenimos el envío
        var errorDetectado = false;
        var mensaje = "";

        Swal.fire({
            title: '¿Desea guardar los cambios?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, guardar',
            cancelButtonText: 'No, cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                var nombre = $('#nombre').val();
                var apellido = $('#apellido').val();
                var usuario = $('#usuario').val();
                var correo = $('#correo').val();
                var telefono = $('#telefono').val();

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
                }

                if (errorDetectado) {
                    console.log(mensaje);
                    Swal.fire({
                        title: "Error!",
                        text: mensaje,
                        icon: "error",
                        customClass: {
                            confirmButton: 'btn btn-primary'
                        }
                    });
                } else {
                    guardaryeditar()
                }
            }
        })
    });

});

function guardaryeditar() {
    var formData = new FormData($('#formEditarUsuario')[0]);
    $.ajax({
        url: "../../controller/UsuarioController.php?op=guardardatos",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {
            console.log(data);
            if (data.includes("Error") || data.includes("Faltan") || data.includes("Existe")) {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: data,
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    }
                });
            } else {
                Swal.fire({
                    title: "Correcto!",
                    text: data,
                    icon: "success",
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    }
                });
            }
        }
    });

}

//La funcion se activa al iniciar la pagina
function init(usuario) {
    $.ajax({
        type: "post",
        url: "../../controller/UsuarioController.php?op=mostrar",
        data: {id : usuario},
        dataType: "json",
        success: function (response) {
            console.log(response);
            $('#idUsuario').val(response.id_usuario);
            $('#dni').val(response.dni);
            $('#nombre').val(response.nombre);
            $('#apellido').val(response.apellido);
            $('#correo').val(response.correo);
            $('#usuario').val(response.usuario);
            $('#telefono').val(response.telefono);

            $('#areaNombre').html(response.areaNombre);
            $('#rolNombre').html(response.rolNombre);
        }
    });
}