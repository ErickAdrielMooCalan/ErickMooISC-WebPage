<?php
    require 'test_connection.php';

    $token = $_GET['token'] ?? '';

    if (empty($token)) {
        echo "<script>
                alert('Token no válido');
                window.location.href = 'client-forgot-password';
            </script>";
        exit;
    }

    // Verificar si el token es válido y no ha expirado
    $query = "SELECT * FROM password_resets WHERE reset_token = $1 AND reset_expiry > NOW()";
    $result = pg_query_params($conn, $query, array($token));

    if (pg_num_rows($result) === 0) {
        echo "<script>
                alert('El enlace de restablecimiento ha expirado o es inválido.');
                window.location.href = 'client-forgot-password';
            </script>";
        exit;
    }

    $email_client = pg_fetch_assoc($result)['fk_email_client'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php include 'include/head.php';?>
    <link rel='stylesheet' type='text/css' media='screen' href='styles/style_reset_client_password.css'>
    <link rel='stylesheet' type='text/css' media='screen' href='styles/style_reset_client_password_mobile.css'>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña</title>
</head>
<body>
    <?php include 'include/header.php';?>

    <section class="main_section main_width">
        <h6><i class="fa-solid fa-user-lock"></i> Restablece tu contraseña</h6>

        <div class="form_container">
            <form action="client-update-password" method="POST">
                <input type="hidden" name="email_client" value="<?php echo htmlspecialchars($email_client); ?>">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">

                <div class="form_group">
                    <label for="password">Nueva Contraseña:</label>
                    <input type="password" id="password" name="password" required>
                    <button type="submit" class="buttom_recover"><i class="fa-solid fa-circle-check"></i> Cambiar Contraseña</button>
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