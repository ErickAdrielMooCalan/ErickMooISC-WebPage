<!DOCTYPE html>
<html lang="es">
<head>
    <?php include 'include/head.php';?>
    <link rel='stylesheet' type='text/css' media='screen' href='styles/style_login_administrator.css'>
    <link rel='stylesheet' type='text/css' media='screen' href='styles/style_login_administrator_mobile.css'>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión como administrador</title>
</head>
<body>
    <?php include 'include/header.php';?>

    <section class="main_width section_1_login_client">
        <div class="form_container">

            <div class="icons_container">
                <i class="fa-solid fa-user-tie admin_icon"></i>
            </div>

            <form action="admin-validate-login" method="POST" class="login_form">
                <div class="form_group">
                    <label for="email_client">Correo</label>
                    <input type="email" id="email_admin" name="email_admin" required placeholder="Dirección de correo">
                </div>

                <div class="form_group">
                    <label for="password_client">Contraseña</label>
                    <input type="password" id="password_admin" name="password_admin" required placeholder="Contraseña">
                </div>

                <button type="submit" class="login_client_buttom">Ingresar</button>
            </form>

            <div class="info_create_client">
                <p><i class="fa-solid fa-triangle-exclamation"></i> ¿Necesitas una cuenta de administrador?</p>
                <p><i class="fa-solid fa-envelope"></i> Envía tu solicitud al correo: erick.moo.isc@gmail.com</p>
                <p>Si eres cliente inicia sesión aquí:</p>
                <a href="client-login" class="client_buttom"><i class="fa-solid fa-circle-check"></i> Soy cliente</a>
            </div>

        </div>
    </section>
</body>

<script>
    document.querySelector('.menu_button').addEventListener('click', function() {
    document.querySelector('.menu_nav').classList.toggle('active');
    });
</script>

<?php include 'include/footer.php'; ?>
</html>