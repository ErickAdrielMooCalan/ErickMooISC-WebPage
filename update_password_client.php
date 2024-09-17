<?php
    require 'test_connection.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email_client = $_POST['email_client'];
        $token = $_POST['token'];

        // Encrypt the new password
        $new_password = password_hash($_POST['password'], PASSWORD_BCRYPT); 

        // Check if the token is valid
        $query = "SELECT * FROM password_resets WHERE reset_token = $1 AND fk_email_client = $2 AND reset_expiry > NOW()";
        $result = pg_query_params($conn, $query, array($token, $email_client));

        if (pg_num_rows($result) > 0) {

            // Update user password
            $query_update = "UPDATE users SET password = $1 WHERE email = $2";
            pg_query_params($conn, $query_update, array($new_password, $email_client));

            // Remove reset token
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