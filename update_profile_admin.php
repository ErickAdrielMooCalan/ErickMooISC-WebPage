<?php
    require 'test_connection.php';

    session_start();

    // Check if the admin is authenticated
    if (!isset($_SESSION['user_admin'])) {
        header("Location: admin-login");
        exit();
    }

    // Retrieve the admin data from the session
    $user_admin = $_SESSION['user_admin'];

    // Get the submitted data from the form
    $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
    $second_name = isset($_POST['second_name']) ? $_POST['second_name'] : '';
    $last_names = isset($_POST['last_names']) ? $_POST['last_names'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';

    // Handle profile image upload
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/profile/';
        $cleaned_first_name = preg_replace('/[^a-zA-Z0-9]/', '', $first_name);
        $cleaned_second_name = preg_replace('/[^a-zA-Z0-9]/', '', $second_name);
        $cleaned_last_names = preg_replace('/[^a-zA-Z0-9]/', '', $last_names);
        $imageFileType = strtolower(pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION));
        $unique_name = 'admin_' . $cleaned_first_name . '_' . $cleaned_second_name . '_' . $cleaned_last_names . '_' . uniqid() . '.' . $imageFileType;
        $target_file = $upload_dir . $unique_name;

        if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file)) {
            // Remove the old profile image if it exists
            if (!empty($user_admin['profile_image']) && file_exists($user_admin['profile_image'])) {
                unlink($user_admin['profile_image']);
            }
            $profile_image = $target_file;
        } else {
            // If upload fails, keep the old profile image
            $profile_image = $user_admin['profile_image'];
        }
    } else {
        // No new file uploaded, keep the old profile image
        $profile_image = $user_admin['profile_image'];
    }

    // Check the database connection
    if ($conn) {
        // Update admin information in the `users` table
        $query_update_user = "UPDATE users SET first_name = $1, second_name = $2, last_names = $3, email = $4, phone = $5, profile_image = $6 WHERE id_user = $7";
        $result_update_user = pg_query_params($conn, $query_update_user, array($first_name, $second_name, $last_names, $email, $phone, $profile_image, $user_admin['id_user']));

        // Check if updates were successful
        if ($result_update_user) {
            // Refresh the session data
            $_SESSION['user_admin'] = array_merge($user_admin, [
                'first_name' => $first_name,
                'second_name' => $second_name,
                'last_names' => $last_names,
                'email' => $email,
                'phone' => $phone,
                'profile_image' => $profile_image
            ]);

            // Redirect to the welcome page
            header("Location: admin-welcome");
            exit();
        } else {
            // Error updating data
            echo "<script>alert('Error en actualización de datos'); window.location.href = 'admin-welcome';</script>";
        }
    } else {
        // Error connecting to the database
        echo "<script>alert('No tienes conexión con la base de datos'); window.location.href = 'admin-welcome';</script>";
    }

    // Close the database connection
    pg_close($conn);
?>
