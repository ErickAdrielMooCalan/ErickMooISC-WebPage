<!DOCTYPE html>
<html lang="es">
<head>
    <?php include 'include/head.php';?>
    <link rel='stylesheet' type='text/css' media='screen' href='styles/style_create_client.css'>
    <link rel='stylesheet' type='text/css' media='screen' href='styles/style_create_client_mobile.css'>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regístrate</title>
</head>
<body>
    <?php include 'include/header.php';?>

    <section class="main_width section_1_create_client">
        <div class="form_container">
            <div class="icons_container">
                <i class="fa-solid fa-user-plus create_new_client"></i>
            </div>

            <form action="validate-register-client" method="POST" enctype="multipart/form-data" class="login_form">

                <div class="form_group">
                    <label for="first_name">Primer nombre</label>
                    <input type="text" name="first_name" required>

                    <label for="second_name">Segundo nombre</label>
                    <input type="text" name="second_name">

                    <label for="last_names">Apellidos</label>
                    <input type="text" name="last_names" required>

                    <label for="age">Edad</label>
                    <input type="number" name="age" required>
                </div>

                <div class="form_group">
                    <label for="email">Correo electrónico</label>
                    <input type="email" name="email" required>

                    <label for="phone">Teléfono</label>
                    <input type="text" name="phone" pattern="\d{10}" required title="Debe ser un número de 10 dígitos">

                    <label for="profile_image">Imagen de perfil</label>
                    <input type="file" name="profile_image" accept="image/*">

                    <label for="password">Contraseña</label>
                    <input type="password" name="password" required>
                </div>

                <div class="form_group">
                    <button type="submit" class="register_client_buttom">Registrar</button>
                </div>
            </form>
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