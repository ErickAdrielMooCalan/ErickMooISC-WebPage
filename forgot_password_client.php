<!DOCTYPE html>
<html lang="es">
<head>
    <?php include 'include/head.php';?>
    <link rel='stylesheet' type='text/css' media='screen' href='styles/style_forgot_password_client.css'>
    <link rel='stylesheet' type='text/css' media='screen' href='styles/style_forgot_password_client_mobile.css'>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar accesso</title>
</head>
<body>
    <?php include 'include/header.php';?>

    <section class="main_section main_width">
        <div class="form_container">
        <i class="fa-solid fa-envelope-circle-check icon_mail"></i>

            <form action="client-link-reset" method="POST">
                <div class="form_group">
                    <label for="email_client">¿Cuál es su correo?</label>
                    <input type="email" id="email_client" name="email_client" required placeholder="Escribe tu correo electrónico">
                    <button type="submit" class="buttom_recover">Enviar enlace de recuperación</button>
                </div>
            </form>
        </div>

    </section>
</body>

<?php include 'include/footer.php'; ?>

<script>
    document.querySelector('.menu_button').addEventListener('click', function() {
    document.querySelector('.menu_nav').classList.toggle('active');
    });
</script>

</html>