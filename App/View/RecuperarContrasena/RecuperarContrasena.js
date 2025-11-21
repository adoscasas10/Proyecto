$(document).ready(function () {
    const queryString = window.location.search;

    const urlParams = new URLSearchParams(queryString);

    const valorCodificado = urlParams.get('d');

    const jsonString = atob(valorCodificado);

    const datosUsuario = JSON.parse(jsonString);

    $(".toggle-password").on("click", function() {
        
        // 'this' es el botón que se presionó
        var boton = $(this);
        
        // Obtiene el ID del input asociado desde el atributo 'data-target'
        var targetInputId = boton.data("target");
        var input = $(targetInputId);
        
        // Encuentra el ícono <i> dentro del botón
        var icono = boton.find("i");

        // Revisa el tipo de input y lo cambia
        if (input.attr("type") === "password") {
            
            // Cambia el input a tipo 'text' (para mostrar)
            input.attr("type", "text");
            
            // Cambia el ícono al de "ojo tachado"
            icono.removeClass("fa-eye").addClass("fa-eye-slash");
            
        } else {
            
            // Cambia el input a tipo 'password' (para ocultar)
            input.attr("type", "password");
            
            // Cambia el ícono de vuelta al de "ojo normal"
            icono.removeClass("fa-eye-slash").addClass("fa-eye");
        }
    });

    $('.form_recuperar').submit(function (e) {
        
        e.preventDefault();
        
        var formData = new FormData(this);

        let contra = $('#contra').val();
        let Confirmar_contra = $('#Confirmar_contra').val();
        let usu_id = datosUsuario.id_usuario;

        console.log(contra);
        console.log(Confirmar_contra);

        //las validaciones para las contraseñas
        var errorDetectado = false;
        var mensaje = "";

        if (!/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[^\s]{8,16}$/.test(contra)) {
            errorDetectado = true;
            mensaje = "La contraseña nueva debe tener al menos 8 caracteres, una mayúscula, una minúscula, un número y un carácter especial";
        }


        if(errorDetectado){
            Swal.fire({
                icon: "error",
                title: "Error!!!!",
                text: mensaje,
                customClass: {
                    confirmButton: 'btn btn-primary'
                }
            })
        }else{
            Swal.fire({
                title: '¿Desea realizar el cambio de contraseña?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, guardar',
                cancelButtonText: 'No, cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "../../controller/UsuarioController.php?op=recuperar_contraseña",
                        type: "POST",
                        data: {usu_id:usu_id, contra:contra, Confirmar_contra : Confirmar_contra},
                        success: function (data) {
                            console.log(data);
                            if (data.includes("Error") || data.includes("Error:") || data.includes("Existe") || data.includes("Faltan")) {
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

                                $('#form_recuperar')[0].reset();

                                $.post("../../controller/emailController.php?op=cambio_contraseña", {usu_id : usu_id}, function (data) {
                                    console.log(data);
                                });

                                window.location.href = "../Login/Login.php";
                                
                            }
                        }
                    });
    
                }
            });
        }

    });

});