
function validar(){
    var nombre = $('#nombre');
    var apellido = $('#apellido');
    var usuario = $('#usuario');
    var correo = $('#correo');
    var rol = $('#rol');
    var area = $('#area');
    var telefono = $('#telefono');
    var dni = $('#dni');
    var password = $('#password');

    $('#btnCancelar').click(function(){
        $('#usuario_form')[0].reset();
        nombre.css("border-color", "#3F454B");
        apellido.css("border-color", "#3F454B");
        usuario.css("border-color", "#3F454B");
        correo.css("border-color", "#3F454B");
        rol.css("border-color", "#3F454B");
        area.css("border-color", "#3F454B");
        telefono.css("border-color", "#3F454B");
        dni.css("border-color", "#3F454B");
        password.css("border-color", "#3F454B");
    });
    
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

    password.keyup(function(){
        var expression = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[^\s]{8,16}$/; // Esto hace que la contraseña tenga al menos 8 caracteres, una mayúscula, una minúscula, un número y un carácter especial
        var valor = $(this).val();
        if(!expression.test(valor)){
            password.css("border-color", "#F00");
        }else{
            password.css("border-color", "#090");
        }
        if(valor.length === 0){
            password.css("border-color", "#3F454B");
        }
    });
    
}

function soloSoporte(){
    //cuando se activa el combobox de area, solo se debe mostrar los roles de soporte y administrador
    $('#area_id').change(function(){
        var area = $(this).val();
        if(area == "1"){
            //falta el seleccione
            $('#rol_id').html('<option value="">Seleccione</option><option value="2">Soporte Técnico</option><option value="1">Administrador</option>');
        }else{
            $('#rol_id').html('<option value="">Seleccione</option><option value="3">Usuario</option>');
        } 
    });
}

function init() {
    $("#usuario_form").on("submit", function(e) {
        e.preventDefault(); // prevenimos el envío

        var errorDetectado = false;
        var mensaje = "";

        var nombre = $('#nombre').val();
        var apellido = $('#apellido').val();
        var usuario = $('#usuario').val();
        var correo = $('#correo').val();
        var telefono = $('#telefono').val();
        var dni = $('#dni').val();
        var password = $('#password').val();

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
        } else if (!/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[^\s]{8,16}$/.test(password)) {
            errorDetectado = true;
            mensaje = "La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula, un número y un carácter especial";
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
            guardaryeditar(e);
        }
    });
}


function guardaryeditar(e){
    e.preventDefault();
	var formData = new FormData($("#usuario_form")[0]);
    $.ajax({
        url: "../../controller/UsuarioController.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos) {
            console.log(datos);
            

            
            //separar el dni y el correo
            var usu_id_ = datos.split("-")[0];
            var usu_correo_ = datos.split("-")[1];

            console.log(usu_id_);
            console.log(usu_correo_);


            // Si la respuesta contiene la palabra "Error" o "Faltan"
            if (datos.includes("Error") || datos.includes("Faltan") || datos.includes("Existe")) {
                Swal.fire({
                    title: "Error!",
                    text: datos,
                    icon: "error",
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    }
                });
            } else {
                $('#modalmantenimiento').modal('hide');
                $('#usuario_form')[0].reset();
                //Cambiando el color, simulando el click en el boton cancelar
                $('#btnCancelar').click();

                // $("#modalmantenimiento").modal('hide');
                //$('#usuario_data').DataTable().ajax.reload();

                Swal.fire({
                    title: "Correcto!",
                    text: datos,
                    icon: "success",
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    }
                });

                $.post("../../controller/emailController.php?op=verificar_cuenta", {usu_id : usu_id_, usu_correo : usu_correo_}, function (data) {
                     console.log(data);
                });

            }
        }
        
    }); 
}

$(document).ready(function(){
    init();
    validar();
    soloSoporte();

    //Aun falta
    $.post("../../controller/rolController.php?op=comboRol",function(data, status){
        $('#rol_id').html('<option value="">Seleccione</option>' + data);
    });

    //Ya esta
    $.post("../../controller/AreaController.php?op=comboArea",function(data, status){
        $('#area_id').html('<option value="">Seleccione</option>' + data);
    });
    
});


$(document).on("click","#btnnuevo", function(){
    $('#mdltitulo').html('Nuevo Registro');
    $('#usuario_form')[0].reset();
    $('#modalmantenimiento').modal('show');
});

//init();