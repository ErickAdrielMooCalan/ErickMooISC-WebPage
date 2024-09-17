<?php
require 'test_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email_client = $_POST['email_client'];
    $token = $_POST['token'];
    $new_password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Encripta la nueva contraseña

    // Verificar si el token es válido
    $query = "SELECT * FROM password_resets WHERE reset_token = $1 AND fk_email_client = $2 AND reset_expiry > NOW()";
    $result = pg_query_params($conn, $query, array($token, $email_client));

    if (pg_num_rows($result) > 0) {
        // Actualizar la contraseña del usuario
        $query_update = "UPDATE users SET password = $1 WHERE email = $2";
        pg_query_params($conn, $query_update, array($new_password, $email_client));

        // Eliminar el token de restablecimiento
        $query_delete = "DELETE FROM password_resets WHERE fk_email_client = $1";
        pg_query_params($conn, $query_delete, array($email_client));

        echo "<script>
                alert('Contraseña actualizada correctamente');
                window.location.href = 'client-login';
            </script>";
    } else {
        echo "<script>
                alert('El enlace de restablecimiento ha expirado o es inválido');
                window.location.href = 'client-forgot-password';
            </script>";
    }
}
?>