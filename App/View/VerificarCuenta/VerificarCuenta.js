$(document).ready(function () {
    const queryString = window.location.search;

    const urlParams = new URLSearchParams(queryString);

    const valorCodificado = urlParams.get('d');

    const jsonString = atob(valorCodificado);

    const datosUsuario = JSON.parse(jsonString);

    // console.log(datosUsuario.id_usuario);

    $.post("./../../controller/UsuarioController.php?op=ActualizarEstadoVerificacion", { usu_id: datosUsuario.id_usuario }, function (data) {
        console.log(data);
    });
});