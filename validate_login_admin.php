<?php
    require 'test_connection.php';

    session_start();

    if (isset($_POST['email_admin']) && isset($_POST['password_admin'])) {
        $email_admin = $_POST['email_admin'];
        $password_admin = $_POST['password_admin'];

        // Verificar la conexión a la base de datos
        if ($conn) {
            $query_admin = "SELECT * FROM users WHERE email = $1 LIMIT 1";
            $result_admin = pg_query_params($conn, $query_admin, array($email_admin));

            // Comprobar si el usuario existe
            if ($result_admin && pg_num_rows($result_admin) > 0) {
                // Obtener datos del usuario
                $user_admin = pg_fetch_assoc($result_admin);

                // Comprobar si el usuario es un administrador
                if ($user_admin['fk_id_user_type'] === '643dce86-c777-41c1-837e-53a6831f3d85') {
                    // Verificar si la contraseña es correcta
                    if (password_verify($password_admin, $user_admin['password'])) {
                        // Obtener detalles adicionales del administrador desde la tabla `admin_details`
                        $query_details = "SELECT admin_role FROM admin_details WHERE fk_id_user = $1 LIMIT 1";
                        $result_details = pg_query_params($conn, $query_details, array($user_admin['id_user']));

                        // Si existen detalles del administrador, agregarlos a la sesión
                        if ($result_details && pg_num_rows($result_details) > 0) {
                            $admin_details = pg_fetch_assoc($result_details);
                            // Agregar detalles del administrador a la información de la sesión
                            $_SESSION['user_admin'] = array_merge($user_admin, $admin_details);
                        } else {
                            // Si no se encuentran detalles, inicializar los campos como vacíos
                            $_SESSION['user_admin'] = array_merge($user_admin, ['admin_role' => '']);
                        }

                        // Redirigir al usuario a "admin-welcome.php"
                        header("Location: admin-welcome");
                        exit();
                    } else {
                        // Contraseña incorrecta
                        echo "<script>alert('Contraseña incorrecta, prueba de nuevo'); window.location.href = 'admin-login';</script>";
                    }
                } else {
                    // Acceso denegado para usuarios que no son administradores
                    echo "<script>alert('Acceso denegado, debes ser administrador para iniciar sesión.'); window.location.href = 'admin-login';</script>";
                }
            } else {
                // Usuario no encontrado
                echo "<script>alert('Administrador no encontrado. ¿Has creado una cuenta?'); window.location.href = 'admin-login';</script>";
            }
        } else {
            // Error en la conexión a la base de datos
            echo "<script>alert('No se puede establecer conexión con la base de datos'); window.location.href = 'admin-login';</script>";
        }

        // Cerrar la conexión
        pg_close($conn);
    } else {
        // Campos faltantes
        echo "<script>alert('Llene los campos requeridos'); window.location.href = 'admin-login';</script>";
    }
?>
