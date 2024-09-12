<!DOCTYPE html>
<html lang="es">
<head>
    <?php include 'include/head.php';?>
    <link rel='stylesheet' type='text/css' media='screen' href='styles/style_login_client.css'>
    <link rel='stylesheet' type='text/css' media='screen' href='styles/style_login_client_mobile.css'>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión como cliente</title>
</head>
<body>
    <?php include 'include/header.php';?>

    <section class="main_width section_1_login_client">
        <div class="form_container">

            <div class="icons_container">
                <i class="fa-solid fa-user key_user_icon"></i>
            </div>

            <form action="validate-client-login" method="POST" class="login_form">
                <div class="form_group">
                    <label for="email_client">Correo</label>
                    <input type="email" id="email_client" name="email_client" required placeholder="Escribe tu correo electrónico">
                </div>

                <div class="form_group">
                    <label for="password_client">Contraseña</label>
                    <input type="password" id="password_client" name="password_client" required placeholder="Escribe tu contraseña">
                </div>

                <button type="submit" class="login_client_buttom">Ingresar</button>
            </form>

            <div class="info_create_client">
                <p>¿Olvidaste tu contraseña?</p>
                <a href="client-forgot-password" class="recover_password">Recuperar accesso</a>

            </div>

            <div class="info_create_client">
                <p>Crea una cuenta totalmente gratis</p>
                <a href="register-client" class="create_client_buttom">Regístrate</a>
            </div>
        </div>
    </section>

</body>

<script>
    new WOW().init();

    document.querySelector('.menu_button').addEventListener('click', function() {
    document.querySelector('.menu_nav').classList.toggle('active');
    });

    var splide = new Splide( '.splide', {type: 'loop', autoplay: false, interval: '2000'} );
    splide.mount();
</script>

<?php include 'include/footer.php'; ?>

</html>