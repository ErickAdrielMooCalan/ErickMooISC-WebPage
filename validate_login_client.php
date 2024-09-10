<?php
    require 'test_connection.php';

    session_start();

    if (isset($_POST['email_client']) && isset($_POST['password_client'])) {
        $email_client = $_POST['email_client'];
        $password_client = $_POST['password_client'];

        // Verify the connection to the database
        if ($conn) {
            $query_client = "SELECT * FROM users WHERE email = $1 LIMIT 1";
            $result_client = pg_query_params($conn, $query_client, array($email_client));

            // Check if the user exists
            if ($result_client && pg_num_rows($result_client) > 0) {
                // Get user data
                $user_client = pg_fetch_assoc($result_client);

                // Check if the user is a client
                if ($user_client['fk_id_user_type'] === 'a1261531-fec8-4a4d-8f6b-bed7a47031ab') {
                    // Check if the password is correct
                    if (password_verify($password_client, $user_client['password'])) {
                        // Get additional client details from the `client_details` table
                        $query_details = "SELECT type_service, company FROM client_details WHERE fk_id_user = $1 LIMIT 1";
                        $result_details = pg_query_params($conn, $query_details, array($user_client['id_user']));

                        // If client details exist, add them to the session
                        if ($result_details && pg_num_rows($result_details) > 0) {
                            $client_details = pg_fetch_assoc($result_details);
                            // Add client details to the session information
                            $_SESSION['user_client'] = array_merge($user_client, $client_details);
                        } else {
                            // If no details are found, initialize the fields as empty
                            $_SESSION['user_client'] = array_merge($user_client, ['type_service' => '', 'company' => '']);
                        }

                        // Redirect the user to "client-welcome.php"
                        header("Location: client-welcome");
                        exit();
                    } else {
                        // Incorrect password
                        echo "<script>alert('Contraseña incorrecta, prueba de nuevo'); window.location.href = 'client-login';</script>";
                    }
                } else {
                    // Access denied for non-clients
                    echo "<script>alert('Acceso denegado ¿Eres un administrador?'); window.location.href = 'client-login';</script>";
                }
            } else {
                // User not found
                echo "<script>alert('Cliente no encontrado ¿Has creado una cuenta?'); window.location.href = 'client-login';</script>";
            }
        } else {
            // Database connection error
            echo "<script>alert('No se puede establecer conexión con la base de datos'); window.location.href = 'client-login';</script>";
        }

        // Close the connection
        pg_close($conn);
    } else {
        // Missing fields
        echo "<script>alert('Lleva los campos requeridos'); window.location.href = 'client-login';</script>";
    }
?>
