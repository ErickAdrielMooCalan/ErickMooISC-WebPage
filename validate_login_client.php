<?php
    require 'test_connection.php';

    if (isset($_POST['email_client']) && isset($_POST['password_client'])){
        $email_client = $_POST['email_client'];
        $password_client = $_POST['password_client'];

        // Verify the connection to the database
        if ($conn) {
            $query_client = "SELECT * FROM users WHERE email = $1 LIMIT 1";
            $result_client = pg_query_params($conn, $query_client, array($email_client));

            // Check if the user exists
            if ($result_client && pg_num_rows($result_client) > 0){
                // Get user data
                $user_client = pg_fetch_assoc($result_client);

                // Check if the password is correct
                if ($user_client['password'] === $password_client){

                    // SAVE USER DATA IN THE SESSION
                    $_SESSION['user_client'] = $user_client;

                    // Redirect the user to "welcome_client.php"
                    header("Location: welcome_client.php");
                    exit();
                }
                else{
                    echo "Incorrect password.";
                }
            }
            else{
                echo "User not found.";
            }
        }
        else{
            echo "Database connection error.";
        }

        // Close the connection
        pg_close($conn);
    }
    else{
        echo "Please complete all fields.";
    }
?>