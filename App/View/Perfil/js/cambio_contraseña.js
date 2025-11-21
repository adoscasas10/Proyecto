
document.querySelectorAll(".togglePassword").forEach(button => {
    button.addEventListener("click", () => {
      const input = button.previousElementSibling;
      const icon = button.querySelector("i");
      const isPassword = input.type === "password";

      // alterna el tipo de input
      input.type = isPassword ? "text" : "password";

      // alterna entre fa-eye y fa-eye-slash
      icon.classList.toggle("fa-eye", !isPassword);
      icon.classList.toggle("fa-eye-slash", isPassword);
    });
});


$(document).ready(function () {
    $("#formCambiarContraseña").submit(function (e) { 

        e.preventDefault();

        var currentPassword = $("#currentPassword").val();
        var newPassword = $("#newPassword").val();
        var confirmPassword = $("#confirmPassword").val();
        var usu_id = $("#usu_id").val();

        console.log("Pass Actual: " + currentPassword);
        console.log("Pass Nueva: " + newPassword);
        console.log("Confirmacion: " + confirmPassword);
        

        var formData = new FormData($('#formCambiarContraseña')[0]);
        

        //las validaciones para las contraseñas
        var errorDetectado = false;
        var mensaje = "";

        if (!/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[^\s]{8,16}$/.test(newPassword)) {
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
            });
        }else{
            Swal.fire({
                title: '¿Desea realizar los cambios?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, guardar',
                cancelButtonText: 'No, cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "../../controller/UsuarioController.php?op=cambiar_contraseña",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
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
                                $('#formCambiarContraseña')[0].reset();

                                
                                $.post("../../controller/emailController.php?op=cambio_contraseña", {usu_id : usu_id}, function (data) {
                                    console.log(data);
                                });

                                
                            }
                        }
                    });
    
                }
            })
        }
    });

});