<?php

    require 'test_connection.php';

    if (isset($_POST['email_client']) && isset($_POST['password_client'])){
        $email = $_POST['email_client'];
        $password = $_POST['password_client'];

        // Verify the connection to the database
        if ($conn) {
            $query = "SELECT * FROM users WHERE email = $1 LIMIT 1";
            $result = pg_query_params($conn, $query, array($email));

            // Check if the user exists
            if ($result && pg_num_rows($result) > 0){
                // Get user data
                $user = pg_fetch_assoc($result);

                // Check if the password is correct
                if ($user['password'] === $password){
                    echo "Successful login, welcome" . $user['first_name'];
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