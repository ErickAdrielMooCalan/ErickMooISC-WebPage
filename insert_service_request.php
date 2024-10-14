<?php
    // Database connection
    require 'test_connection.php';

    if (!$conn) {
        die("Error de conexión a la base de datos.");
    }

    // Get form data
    $service_type = pg_escape_string($conn, $_POST['service_type']);
    $actions_taken = $_POST['actions_taken'];
    $total_cost = pg_escape_string($conn, $_POST['total_cost']);
    $service_date = pg_escape_string($conn, $_POST['service_date']);
    $delivery_date = isset($_POST['delivery_date']) && !empty($_POST['delivery_date']) ? pg_escape_string($conn, $_POST['delivery_date']) : NULL;
    $fk_client_id = pg_escape_string($conn, $_POST['fk_client_id']);

    // Convert actions to JSON format
    // Separate actions by commas
    $actions_array = explode(',', $actions_taken);
    $actions_json = json_encode(array_map('trim', $actions_array), JSON_UNESCAPED_UNICODE); // Convertir el array a JSON sin escape de caracteres Unicode

    // Check if the client exists
    $check_client_query = "SELECT COUNT(*) FROM client_details WHERE id_client = '$fk_client_id'";
    $result = pg_query($conn, $check_client_query);

    if (!$result) {
        die("Error en la consulta: " . pg_last_error($conn));
    }

    $client_exists = pg_fetch_result($result, 0, 0);

    if ($client_exists > 0) {
        // If the client exists, proceed with the insertion
        $insert_query = "
            INSERT INTO service_requests (service_type, actions_taken, total_cost, service_date, delivery_date, fk_client_id)
            VALUES ('$service_type', '$actions_json', '$total_cost', '$service_date', " . ($delivery_date ? "'$delivery_date'" : 'NULL') . ", '$fk_client_id')
        ";

        if (pg_query($conn, $insert_query)) {
            echo "Solicitud de servicio registrada con éxito.";
        } else {
            echo "Error al registrar la solicitud de servicio: " . pg_last_error($conn);
        }
    } else {
        echo "Error: El cliente no existe en la base de datos.";
    }

    // Close the connection
    pg_close($conn);
?>
