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
                <form id="searchForm" class="searchBar">
                    <label for="search_term"><i class="fa-solid fa-magnifying-glass"></i> Buscar cliente</label>
                        <p class="info_search"><i class="fa-solid fa-circle-info"></i> Busca a un cliente en específico por medio de su teléfono, correo o apellidos</p>
                    <input type="text" name="search_term" id="search_term" placeholder="Teléfono, Correo o Apellidos">
                </form>

                <button id="backToTab3" style="display: none;" class="clearButtom"><i class="fa-solid fa-eraser"></i> Limpiar búsqueda</button>

                <!-- Container for the results table -->
                <div id="result_table" class="charge_table">
                    <!-- Here the table will be inserted with AJAX -->
                </div>
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

    $(document).ready(function(){
        // Listen to the form submit event (even though it is not submitted now)
        $('#searchForm').on('submit', function(e) {
            // Prevent the form from reloading the page
            e.preventDefault();
        });

        // Listen to input event in search field
        $('#search_term').on('input', function(){
            // Get the search term
            let search_term = $(this).val();

            // Make AJAX request if there is text in the field
            if (search_term.length > 0){
                $.ajax({
                    // PHP file to process the search
                    url: 'manage_clients_service.php',
                    type: 'GET',
                    // Submit search term
                    data: { search_term: search_term },
                    success: function(response){
                        // Place the response (table) inside the results div
                        $('#result_table').html(response);

                        // Clean button
                        $('#backToTab3').show();
                    }
                    ,
                    error: function(){
                        alert('Hubo un error al procesar la solicitud.');
                    }
                });
            }
            else{
                // Clear table if field is empty
                $('#result_table').html('');
            }
        });

        // Handle button click to return to tab 3 (clean button)
        $('#backToTab3').on('click', function(){
            // Switch to tab 3
            $("ul.tabs li").removeClass("active");
            $("ul.tabs li:eq(2)").addClass("active");
            $(".tab_content").hide();
            $("#tab3").fadeIn();

            // Clear the search field
            $('#search_term').val('');
            // Clear the results table
            $('#result_table').html('');

            // Hide button
            $(this).hide();
        });
    });
</script>

</html>
