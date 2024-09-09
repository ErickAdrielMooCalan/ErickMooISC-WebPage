<?php
    // Database connection
    require 'test_connection.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        // Get form data
        $first_name = $_POST['first_name'];
        $second_name = $_POST['second_name'];
        $last_names = $_POST['last_names'];
        $age = $_POST['age'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $phone = $_POST['phone'];
        // ID for clients
        $fk_id_user_type = 'a1261531-fec8-4a4d-8f6b-bed7a47031ab';
        $profile_image = null;

        // Managing profile image upload
        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK){
            // Directory where images will be saved
            $target_dir = "uploads/profile";
            $target_file = $target_dir . basename($_FILES['profile_image']['name']);

            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file)){
                // Save the path of the uploaded file
                $profile_image = $target_file;
            }

        }

        // Verify the connection to the database
        if ($conn){

            // Insert the data into the 'users' table
            $query = "INSERT INTO users (first_name, second_name, last_names, age, email, password, phone, fk_id_user_type, profile_image)
                        VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9)";
            $params = array($first_name, $second_name, $last_names, $age, $email, $password, $phone, $fk_id_user_type, $profile_image);
            $result = pg_query_params($conn, $query, $params);

            if ($result){
                echo "<script>alert('Cliente registrado exitosamente.'); window.location.href = 'login.php';</script>";
            }
            else{
                echo "<script>alert('Error al registrar el cliente.'); window.location.href = 'login.php';</script>";
            }
        }
        else{
                echo "<script>alert('Error en la conexión a la base de datos.');</script>";
        }

        //Close the connection to the database
        pg_close($conn);
    }
?>