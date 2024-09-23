<?php
    session_start();

    // Check if the user is an administrator
    if (!isset($_SESSION['user_admin'])) {
        header("Location: admin-login");
        exit();
    }

    // Get administrator data from the session
    $user_admin = $_SESSION['user_admin'];

    require 'test_connection.php';

    // Query the database to obtain the administrator role
    $query = "SELECT admin_role FROM admin_details WHERE fk_id_user = $1";
    $result = pg_query_params($conn, $query, array($user_admin['id_user']));

    if ($result){
        $row = pg_fetch_assoc($result);
        if ($row && isset($row['admin_role'])) {
            $admin_role = htmlspecialchars($row['admin_role']);
        }
        else{
            // Define a default role in case one is not found in the database
            $admin_role = 'Administrador';
        }
    }
    else{
        // Error handling in case of query failure
        echo "Error en la consulta: " . pg_last_error($conn);
        exit();
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php include 'include/head.php';?>
    <link rel='stylesheet' type='text/css' media='screen' href='styles/style_welcome_admin.css'>
    <link rel='stylesheet' type='text/css' media='screen' href='styles/style_welcome_admin_mobile.css'>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel administrativo</title>
</head>
<body>

    <section class="main_container main_width">
        <ul class="tabs main_width">
            <li><a href="#tab1"><i class="fa-solid fa-house"></i> Inicio</a></li>
            <li><a href="#tab2"><i class="fa-solid fa-pen-to-square"></i> Editar mis datos</a></li>
            <li><a href="#tab3"><i class="fa-solid fa-cart-shopping"></i> Cobro de servicio</a></li>
            <li><a href="#tab4"><i class="fa-solid fa-ticket"></i> Asignar cupones</a></li>
        </ul>

        <div class="tab_container ancho">
            <div class="tab_content" id="tab1">
                <h3>Datos generales</h3>
                <?php if ($user_admin['profile_image']):?>
                <figure>
                    <img src="<?php echo htmlspecialchars($user_admin['profile_image']); ?>" alt="Profile Picture" class="profile_image">
                </figure>
                <?php else: ?>
                    <p>No tienes foto de perfil</p>
                <?php endif; ?>

                <div class="data_admin">
                    <div class="outgroup_data_admin">
                        <p><strong><i class="fa-solid fa-user"></i> Administrador/a:</strong></p>
                        <p><?php echo htmlspecialchars($user_admin['first_name']); ?> <?php echo htmlspecialchars($user_admin['second_name']); ?> <?php echo htmlspecialchars($user_admin['last_names']); ?></p>
                        <p><strong><i class="fa-solid fa-envelope"></i> Correo:</strong></p>
                        <p><?php echo htmlspecialchars($user_admin['email']); ?></p>
                    </div>

                    <div class="outgroup_data_admin">
                        <p><strong><i class="fa-solid fa-phone"></i> Teléfono:</strong></p>
                        <p><?php echo htmlspecialchars($user_admin['phone']); ?></p>
                        <p><strong><i class="fa-solid fa-users-gear"></i> Rol:</strong></p>
                        <p><?php echo htmlspecialchars($admin_role); ?></p>
                    </div>
                </div>

                <a href="admin-logout" class="logout_button"><i class="fa-solid fa-right-from-bracket"></i> Cerrar sesión</a>
            </div>

            <div class="tab_content" id="tab2">
                <h3 class="warning_color"><i class="fa-solid fa-triangle-exclamation"></i> Revisa tus datos antes de actualizarlos</h3>
                <form action="admin-update" method="POST" enctype="multipart/form-data" class="form_container">

                    <div class="outgroup">
                        <div class="form_group">
                            <label for="first_name">Primer nombre:</label>
                            <input type="text" name="first_name" id="first_name" value="<?php echo htmlspecialchars($user_admin['first_name']); ?>">
                        </div>

                        <div class="form_group">
                            <label for="first_name">Segundo nombre:</label>
                            <input type="text" name="second_name" id="second_name" value="<?php echo htmlspecialchars($user_admin['second_name']); ?>">
                        </div>

                        <div class="form_group">
                            <label for="last_name">Apellidos:</label>
                            <input type="text" name="last_names" id="last_names" value="<?php echo htmlspecialchars($user_admin['last_names']); ?>">
                        </div>
                    </div>

                    <div class="outgroup">
                        <div class="form_group">
                            <label for="email">Correo:</label>
                            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user_admin['email']); ?>">
                        </div>

                        <div class="form_group">
                            <label for="phone">Teléfono:</label>
                            <input type="text" name="phone" id="phone" value="<?php echo htmlspecialchars($user_admin['phone']); ?>">
                        </div>

                        <div class="form_group">
                            <label for="profile_image">Imagen de perfil:</label>
                            <input type="file" name="profile_image" id="profile_image">
                        </div>
                    </div>

                    <div class="outgroup">
                        <button type="submit" class="save_button"><i class="fa-solid fa-circle-check"></i> Guardar cambios</button>
                    </div>
                </form>
            </div>

            <div class="tab_content main_width" id="tab3">
                <form id="searchForm">
                    <label for="search_term">Buscar usuario:</label>
                    <input type="text" name="search_term" id="search_term" placeholder="Teléfono, Correo o Apellidos">
                    <!-- Eliminar el botón de búsqueda -->
                </form>

                <!-- Contenedor para la tabla de resultados -->
                <div id="result_table" class="charge_table">
                    <!-- Aquí se insertará la tabla con AJAX -->
                </div>

                <button id="backToTab3" style="display: none;">Volver a Cobro de servicio</button>

            </div>

            <div class="tab_content" id="tab4">
                <h3>Gestión de Usuarios</h3>
                <p>Aquí puedes gestionar los usuarios de la plataforma.</p>
                <!-- Aquí podrías añadir un listado o formulario para gestionar usuarios -->
            </div>

        </div>

    </section>

</body>

<?php include 'include/footer.php'; ?>

<script>
    new WOW().init();

    $(".tab_content").hide(); // Hide all content
    $("ul.tabs li:first").addClass("active").show(); // Activate the CSS of the first tab
    $(".tab_content:first").show(); // Show the content of the first tab

    // Click event for the tab
    $("ul.tabs li").click(function () {

      $("ul.tabs li").removeClass("active"); // Remove the "active" class
      $(this).addClass("active"); // Add the "active" class to the selected tab
      $(".tab_content").hide(); // Hide the content of the tabs

      var activeTab = $(this).find("a").attr("href");
      $(activeTab).fadeIn(); // Show the active container
      return false;
    });

    $(document).ready(function() {
    // Escuchar el evento de envío del formulario (aunque no se envía ahora)
    $('#searchForm').on('submit', function(e) {
        e.preventDefault(); // Prevenir que el formulario recargue la página
    });

    // Escuchar el evento de entrada en el campo de búsqueda
    $('#search_term').on('input', function() {
        // Obtener el término de búsqueda
        let search_term = $(this).val();

        // Realizar la solicitud AJAX si hay texto en el campo
        if (search_term.length > 0) {
            $.ajax({
                url: 'manage_clients_service.php', // Archivo PHP para procesar la búsqueda
                type: 'GET',
                data: { search_term: search_term }, // Enviar el término de búsqueda
                success: function(response) {
                    // Colocar la respuesta (tabla) dentro del div de resultados
                    $('#result_table').html(response);
                    
                    // Mostrar el botón para volver a la pestaña 3 (si decides mantenerlo en el futuro)
                    $('#backToTab3').show();
                },
                error: function() {
                    alert('Hubo un error al procesar la solicitud.');
                }
            });
        } else {
            // Limpiar la tabla si el campo está vacío
            $('#result_table').html('');
        }
    });

    // Manejar el clic en el botón para volver a la pestaña 3
    $('#backToTab3').on('click', function() {
        // Cambiar a la pestaña 3
        $("ul.tabs li").removeClass("active");
        $("ul.tabs li:eq(2)").addClass("active");
        $(".tab_content").hide();
        $("#tab3").fadeIn();

        // Limpiar el campo de búsqueda y la tabla
        $('#search_term').val(''); // Limpiar el campo de búsqueda
        $('#result_table').html(''); // Limpiar la tabla de resultados

        // Ocultar el botón
        $(this).hide();
    });
});


</script>

</html>
