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
                if ($user_client['fk_id_user_type'] === '319fc478-7452-4049-b9ef-ce52350a22ca'){
                    // Check if the password is correct
                    if ($user_client['password'] === $password_client){

                        // SAVE USER DATA IN THE SESSION
                        $_SESSION['user_client'] = $user_client;

                        // Redirect the user to "welcome_client.php"
                        header("Location: welcome_client.php");
                        exit();
                    }
                    else{
                        // Incorrect password
                        echo "<script>alert('Incorrect password.'); window.location.href = 'login_client.php';</script>";
                    }
                }
                else{
                    // Access denied for non-clients
                    echo "<script>alert('Access denied. Only clients can log in.'); window.location.href = 'login_client.php';</script>";
                }
            }
            else{
                // User not found
                echo "<script>alert('User not found.'); window.location.href = 'login_client.php';</script>";
            }
        }
        else{
            // Database connection error
            echo "<script>alert('Database connection error.'); window.location.href = 'login_client.php';</script>";
        }

        // Close the connection
        pg_close($conn);
    }
    else{
        // Missing fields
        echo "<script>alert('Please complete all fields.'); window.location.href = 'login_client.php';</script>";
    }
?>