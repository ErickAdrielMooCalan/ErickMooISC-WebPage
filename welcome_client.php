<?php
session_start(); // start session

// Check if the user is authenticated
if (!isset($_SESSION['user_client'])) {
    header("Location: client-login"); // Redirige al usuario a la página de inicio de sesión si no está autenticado
    exit();
}

// Retrieve user data from the session
$user_client = $_SESSION['user_client'];
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
                    <img src="<?php echo htmlspecialchars($user_client['profile_image']); ?>" alt="Foto de perfil" class="profile_image">
                </figure>

                <?php else: ?>
                    <p>No tienes una foto de perfil.</p>
                <?php endif; ?>

                <div class="data_client">
                    <p><strong>Cliente:</strong> <?php echo htmlspecialchars($user_client['first_name']); ?> <?php echo htmlspecialchars($user_client['second_name']); ?> <?php echo htmlspecialchars($user_client['last_names']); ?></p>
                    <p><strong>Correo:</strong> <?php echo htmlspecialchars($user_client['email']); ?></p>
                    <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($user_client['phone']); ?></p>
                    <p><strong>Edad:</strong> <?php echo htmlspecialchars($user_client['age']); ?></p>
                    <p><strong>Servicio contratado:</strong></p>
                    <p><strong>Empresa:</strong></p>
                </div>

                <a href="client-logout" class="logout_buttom"><i class="fa-solid fa-right-from-bracket"></i> Cerrar sesión</a>
            </div>

            <div class="tab_content" id="tab2">
                <h5>Revisa cuidadosamente tus datos antes de aplicar cambios</h5>
                <br>
                <p>Sección para editar los datos del cliente</p>
            </div>

            <div class="tab_content" id="tab3">
                <h5>Usa tus cupones para obtener grandes descuentos</h5>
                <br>
                <p>Sección para visualizar cupones</p>
            </div>

        </div>

    </section>

</body>


<?php include 'include/footer.php'; ?>

<script>
    new WOW().init();

    $(".tab_content").hide(); //oculta todo el contenido
    $("ul.tabs li:first").addClass("active").show(); //Activa el css del primer tab
    $(".tab_content:first").show(); //Muestra el contenido del primer tab

    //Evento click al boton
    $("ul.tabs li").click(function () {

      $("ul.tabs li").removeClass("active"); //Quita la clase "active"
      $(this).addClass("active"); //Agrega la clase "active"al tab seleccionado
      $(".tab_content").hide(); //Oculta el contenido de las pestaña

      var activeTab = $(this).find("a").attr("href");
      $(activeTab).fadeIn(); //Aparece el contenedor activo
      return false;
    });
</script>

</html>