$(document).ready(function () {
   


    $('.form-signin').submit(function (e) {
        e.preventDefault();
        let correo = $('#correo').val();
        $.post('../../controller/UsuarioController.php?op=obtenerCorreoDatos', { correo: correo }).done(function (data) {
            //console.log(data);
            let datos = JSON.parse(data);

            if(!datos){
                //recargar la pagina con un parametro
                // window.location.href = "../../view/Login/forgotPassword.php?m=1";
                //Quitar un atributo de un div
                $("#alerta").removeAttr("hidden");
                timmer = setTimeout(() => {
                    $("#alerta").attr("hidden", true);
                }, 3000);
            }else{
                if(datos.estado == 1){

                    Swal.fire({
                        icon: "success",
                        title: "Exito",
                        text: "¿Deseas recuperar tu contraseña?",
                        showCancelButton: true,
                        confirmButtonText: 'Continuar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {

                            $.post('../../controller/emailController.php?op=recuperar_contraseña', { correo: correo, usu_id: datos.id_usuario, datos: datos }).done(function (data) {
                                console.log(data);
                                
                            });

                            Swal.fire({
                                    icon: "success",
                                    title: "Exito",
                                    text: "Se envio un correo con su nueva contraseña",
                                    customClass: {
                                        confirmButton: 'btn btn-primary'
                                    }
                            });
                           
                        }
                    });

                }else if(datos.estado == 2){
                    //No verificado
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "No se puede recuperar la contraseña, verifique su correo electrónica",
                        showCancelButton: true,
                        confirmButtonText: 'Reenviar correo',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            //Aca el correo reenviar para confirmar, aun no esta XD
                        }
                    });
                }else{
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "No se puede recuperar la contraseña, su cuenta esta deshabilitada",
                        customClass: {
                            confirmButton: 'btn btn-primary'
                        }
                    });
                }
            }
        })
    });

});