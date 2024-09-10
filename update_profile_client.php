<?php
    require 'test_connection.php';

    session_start();

    // Check if the user is authenticated
    if (!isset($_SESSION['user_client'])) {
        header("Location: client-login");
        exit();
    }

    // Retrieve the user data from the session
    $user_client = $_SESSION['user_client'];

    // Get the submitted data from the form
    $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
    $second_name = isset($_POST['second_name']) ? $_POST['second_name'] : '';
    $last_names = isset($_POST['last_names']) ? $_POST['last_names'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $type_service = isset($_POST['type_service']) ? $_POST['type_service'] : '';
    $company = isset($_POST['company']) ? $_POST['company'] : '';

    // Handle profile image upload
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/profile/';
        $cleaned_first_name = preg_replace('/[^a-zA-Z0-9]/', '', $first_name);
        $cleaned_second_name = preg_replace('/[^a-zA-Z0-9]/', '', $second_name);
        $cleaned_last_names = preg_replace('/[^a-zA-Z0-9]/', '', $last_names);
        $imageFileType = strtolower(pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION));
        $unique_name = $cleaned_first_name . '_' . $cleaned_second_name . '_' . $cleaned_last_names . '_' . uniqid() . '.' . $imageFileType;
        $target_file = $upload_dir . $unique_name;

        if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file)) {
            // Remove the old profile image if it exists
            if (!empty($user_client['profile_image']) && file_exists($user_client['profile_image'])) {
                unlink($user_client['profile_image']);
            }
            $profile_image = $target_file;
        } else {
            // If upload fails, keep the old profile image
            $profile_image = $user_client['profile_image'];
        }
    } else {
        // No new file uploaded, keep the old profile image
        $profile_image = $user_client['profile_image'];
    }

    // Check the database connection
    if ($conn) {
        // Update user information in the `users` table
        $query_update_user = "UPDATE users SET first_name = $1, second_name = $2, last_names = $3, email = $4, phone = $5, profile_image = $6 WHERE id_user = $7";
        $result_update_user = pg_query_params($conn, $query_update_user, array($first_name, $second_name, $last_names, $email, $phone, $profile_image, $user_client['id_user']));

        // Update client details in the `client_details` table
        $query_update_details = "UPDATE client_details SET type_service = $1, company = $2 WHERE fk_id_user = $3";
        $result_update_details = pg_query_params($conn, $query_update_details, array($type_service, $company, $user_client['id_user']));

        // Check if the updates were successful
        if ($result_update_user && $result_update_details) {
            // Refresh the session data
            $_SESSION['user_client'] = array_merge($user_client, ['first_name' => $first_name, 'second_name' => $second_name, 'last_names' => $last_names, 'email' => $email, 'phone' => $phone, 'type_service' => $type_service, 'company' => $company, 'profile_image' => $profile_image]);

            // Redirect to the welcome page
            header("Location: client-welcome");
            exit();
        } else {
            // Error updating data
            echo "<script>alert('Error updating data'); window.location.href = 'client-welcome';</script>";
        }
    } else {
        // Error connecting to the database
        echo "<script>alert('Error connecting to the database'); window.location.href = 'client-welcome';</script>";
    }

    // Close the database connection
    pg_close($conn);
?>
