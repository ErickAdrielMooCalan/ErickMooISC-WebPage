<?php
    require 'test_connection.php';

    session_start();

    if (isset($_POST['email_client']) && isset($_POST['password_client'])){
        $email_client = $_POST['email_client'];
        $password_client = $_POST['password_client'];

        // Verify the connection to the database
        if ($conn){
            $query_client = "SELECT * FROM users WHERE email = $1 LIMIT 1";
            $result_client = pg_query_params($conn, $query_client, array($email_client));

            // Check if the user exists
            if ($result_client && pg_num_rows($result_client) > 0){
                // Get user data
                $user_client = pg_fetch_assoc($result_client);

                // Check if the user is a client
                if ($user_client['fk_id_user_type'] === 'a1261531-fec8-4a4d-8f6b-bed7a47031ab'){
                    // Check if the password is correct
                    if (password_verify($password_client, $user_client['password'])){
                        // SAVE USER DATA IN THE SESSION
                        $_SESSION['user_client'] = $user_client;

                        // Redirect the user to "welcome_client.php"
                        header("Location: client-welcome");
                        exit();
                    }
                    else{
                        // Incorrect password
                        echo "<script>alert('Contraseña incorrecta'); window.location.href = 'client-login';</script>";
                    }
                }
                else{
                    // Access denied for non-clients
                    echo "<script>alert('Acceso denegado, solo clientes pueden iniciar sesión'); window.location.href = 'client-login';</script>";
                }
            }
            else{
                // User not found
                echo "<script>alert('Usuario no encontrado'); window.location.href = 'client-login';</script>";
            }
        }
        else{
            // Database connection error
            echo "<script>alert('Error de conexión con la base de datos'); window.location.href = 'client-login';</script>";
        }

        // Close the connection
        pg_close($conn);
    }
    else{
        // Missing fields
        echo "<script>alert('Por favor complete todos los campos.'); window.location.href = 'client-login';</script>";
    }
?>
