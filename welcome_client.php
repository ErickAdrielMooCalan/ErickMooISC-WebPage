<?php
    session_start();

    // Check if the user is authenticated
    if (!isset($_SESSION['user_client'])) {
        header("Location: client-login");
        exit();
    }

    // Get client data from the session
    $user_client = $_SESSION['user_client'];

    // Initialize client details variables (type_service and company)
    $type_service = isset($user_client['type_service']) ? htmlspecialchars($user_client['type_service']) : '';
    $company = isset($user_client['company']) ? htmlspecialchars($user_client['company']) : '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php include 'include/head.php';?>
    <link rel='stylesheet' type='text/css' media='screen' href='styles/style_welcome_client.css'>
    <link rel='stylesheet' type='text/css' media='screen' href='styles/style_welcome_client_mobile.css'>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
</head>
<body>

    <section class="main_container main_width">
        <ul class="tabs main_width">
            <li><a href="#tab1"><i class="fa-solid fa-user"></i> Mi cuenta</a></li>
            <li><a href="#tab2"><i class="fa-solid fa-pen-to-square"></i> Editar mis datos</a></li>
            <li><a href="#tab3"><i class="fa-solid fa-ticket"></i> Cupones</a></li>
        </ul>

        <div class="tab_container ancho">
            <div class="tab_content" id="tab1">
                <h3>Bienvenido</h3>
                <?php if ($user_client['profile_image']):?>
                <figure>
                    <img src="<?php echo htmlspecialchars($user_client['profile_image']); ?>" alt="Profile Picture" class="profile_image">
                </figure>

                <?php else: ?>
                    <p>No tienes foto de perfil</p>
                <?php endif; ?>

                <div class="data_client">
                    <p><strong>Cliente:</strong> <?php echo htmlspecialchars($user_client['first_name']); ?> <?php echo htmlspecialchars($user_client['second_name']); ?> <?php echo htmlspecialchars($user_client['last_names']); ?></p>
                    <p><strong>Correo:</strong> <?php echo htmlspecialchars($user_client['email']); ?></p>
                    <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($user_client['phone']); ?></p>
                    <p><strong>Edad:</strong> <?php echo htmlspecialchars($user_client['age']); ?></p>
                    <p><strong>Servicio contratado:</strong> <?php echo htmlspecialchars($type_service); ?></p>
                    <p><strong>Empresa:</strong> <?php echo htmlspecialchars($company); ?></p>
                </div>

                <a href="client-logout" class="logout_buttom"><i class="fa-solid fa-right-from-bracket"></i> Cerrar sesión</a>
            </div>

            <div class="tab_content" id="tab2">
                <h5><i class="fa-solid fa-triangle-exclamation"></i> Revisa tus datos antes de actualizarlos</h5>
                <form action="client-update" method="POST" enctype="multipart/form-data" class="form_container">

                    <div class="outgroup">
                        <div class="form_group">
                            <label for="first_name">Primer nombre:</label>
                            <input type="text" name="first_name" id="first_name" value="<?php echo htmlspecialchars($user_client['first_name']); ?>">
                        </div>

                        <div class="form_group">
                            <label for="second_name">Segundo nombre:</label>
                            <input type="text" name="second_name" id="second_name" value="<?php echo htmlspecialchars($user_client['second_name']); ?>">
                        </div>

                        <div class="form_group">
                            <label for="last_names">Apellidos:</label>
                            <input type="text" name="last_names" id="last_names" value="<?php echo htmlspecialchars($user_client['last_names']); ?>">
                        </div>
                    </div>

                    <div class="outgroup">
                        <div class="form_group">
                            <label for="email">Correo:</label>
                            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user_client['email']); ?>">
                        </div>

                        <div class="form_group">
                            <label for="phone">Teléfono:</label>
                            <input type="text" name="phone" id="phone" value="<?php echo htmlspecialchars($user_client['phone']); ?>">
                        </div>

                        <div class="form_group">
                            <label for="type_service">Servicio contratado:</label>
                            <input type="text" id="type_service" name="type_service" value="<?php echo htmlspecialchars($type_service); ?>">
                        </div>
                    </div>


                    <div class="outgroup">
                        <div class="form_group">
                            <label for="company">Empresa:</label>
                            <input type="text" id="company" name="company" value="<?php echo htmlspecialchars($company); ?>">
                        </div>

                        <div class="form_group">
                            <label for="profile_image">Imagen de perfil:</label>
                            <input type="file" name="profile_image" id="profile_image">
                        </div>

                        <button type="submit" class="save_button">Guardar cambios</button>
                    </div>
                </form>
            </div>

            <div class="tab_content" id="tab3">
                <h5>Usa tus cupones para obtener descuentos</h5>
                <br>
                <p>Sección para cupones</p>
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
</script>

</html>
