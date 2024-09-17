<?php
    require 'test_connection.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email_client'];

        // Check if the email exists in the database
        $query = "SELECT * FROM users WHERE email = $1";
        $result = pg_query_params($conn, $query, array($email));

        if (pg_num_rows($result) > 0) {
            // The email exists, generate a unique token and its expiration date
            // Generate a secure token
            $token = bin2hex(random_bytes(50));
            $expiry = date("Y-m-d H:i:s", strtotime('+1 hour'));

            // Save the token and expiration in the "password_resets" table
            $query_insert = "INSERT INTO password_resets (reset_token, reset_expiry, fk_email_client) VALUES ($1, $2, $3)";
            pg_query_params($conn, $query_insert, array($token, $expiry, $email));

            // Send password reset link via email
            $reset_link = "http://localhost/MyPersonalWebsite/client-reset-password?token=$token";
            $subject = "Recuperación de contraseña";
            $message = '
                            <html>
                            <head>
                                <title>Restablecer Contraseña</title>
                                <style>
                                    .reset-button {
                                        display: inline-block;
                                        padding: 10px 20px;
                                        font-size: 16px;
                                        color: #fff;
                                        background-color: #28a745;
                                        text-decoration: none;
                                        border-radius: 5px;
                                    }
                                    p {
                                        font-family: Arial, sans-serif;
                                        font-size: 14px;
                                    }
                                </style>
                            </head>
                            <body>
                                <p>Haz clic en el botón de abajo para restablecer tu contraseña:</p>
                                <a href="' . $reset_link . '" class="reset-button">Restablecer Contraseña</a>
                                <p>Si el botón no funciona, copia y pega el siguiente enlace en tu navegador:</p>
                                <p><a href="' . $reset_link . '">' . $reset_link . '</a></p>
                            </body>
                            </html>
                        ';

            // Headers so that the email is sent as HTML
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
            $headers .= "From: erick.moo.isc@gmail.com" . "\r\n";

            if (mail($email, $subject, $message, $headers)) {
                echo "<script>
                        alert('Enlace de restablecimiento de contraseña enviado. Revisa tu correo (también verifica la sección de SPAM)');
                        window.location.href = 'client-login';
                      </script>";
            } else {
                echo "<script>
                        alert('Error al enviar el correo');
                        window.location.href = 'client-forgot-password';
                      </script>";
            }

        } else {
            echo "<script>
                    alert('No existe una cuenta con ese correo');
                    window.location.href = 'client-forgot-password';
                  </script>";
        }
    }
?>
