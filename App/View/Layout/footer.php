<footer class="footer">
                <div class="container-fluid">
                    <div class="row text-muted">
                        <div class="col-6 text-start">
                            <p class="mb-0">
                                <a href="../Login/login.php" class="text-muted">
                                    <strong>Nexo-IT Negocios</strong>
                                </a>
                            </p>
                        </div>
                        <div class="col-6 text-end">
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <a href="#" class="text-muted">Contacto</a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#" class="text-muted">Acerca de</a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#" class="text-muted">Terminos y Condiciones</a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#" class="text-muted">Soporte</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
            
            <script>
                setInterval(function() {
                    $.ajax({
                        url: './../../controller/actualizar_sesion.php',
                        type: 'POST',
                        success: function(response) {
                            console.log(response);
                        }
                    });
                }, 60000);
            </script>
            <!-- Coloca esto en tu archivo HTML, dentro del <head> o justo antes del cierre del <body> -->
            
            

            <!-- <script src="
            https://cdn.jsdelivr.net/npm/sweetalert2@11.22.0/dist/sweetalert2.all.min.js
            "></script>
            <link href="
            https://cdn.jsdelivr.net/npm/sweetalert2@11.22.0/dist/sweetalert2.min.css
            " rel="stylesheet"> -->


