<?php
    // Database connection
    require 'test_connection.php';

    // Initialize the search variable
    $search_term = '';
    $search_query = '';

    if (isset($_GET['search_term']) && !empty($_GET['search_term'])){
        $search_term = pg_escape_string($conn, $_GET['search_term']);

        // Build the WHERE part to search by phone, email or last name
        $search_query = " WHERE (u.phone LIKE '%$search_term%'
                        OR u.email LIKE '%$search_term%'
                        OR u.first_name LIKE '%$search_term%'
                        OR u.second_name LIKE '%$search_term%'
                        OR u.last_names LIKE '%$search_term%')";
    }

    // Check if there is a connection to the database
    if ($conn) {
        // SQL query to get users with search filter
        $query_users = "
            SELECT
                u.id_user,
                u.first_name,
                u.second_name,
                u.last_names,
                u.email,
                u.phone,
                cd.id_client AS client_id, -- Añadir el id_client aquí
                CASE
                    WHEN ad.id_admin IS NOT NULL THEN 'Administrador'
                    WHEN cd.id_client IS NOT NULL THEN 'Cliente'
                    ELSE 'No verificado'
                END AS user_type
            FROM users u
            LEFT JOIN admin_details ad ON u.id_user = ad.fk_id_user
            LEFT JOIN client_details cd ON u.id_user = cd.fk_id_user
            $search_query
        ";

        $result_users = pg_query($conn, $query_users);

        if ($result_users && pg_num_rows($result_users) > 0) {
            echo '<table border="1">';
            echo '<tr>
                    <th>ID</th>
                    <th>Primer nombre</th>
                    <th>Segundo nombre</th>
                    <th>Apellidos</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Tipo</th>
                    <th>Acciones</th>
                </tr>';

            // Loop through the results and generate the table rows
            while ($row = pg_fetch_assoc($result_users)) {
                echo '<tr>';
                echo '<td data-label="ID">' . htmlspecialchars($row['id_user']) . '</td>';
                echo '<td data-label="Primer nombre">' . htmlspecialchars($row['first_name']) . '</td>';
                echo '<td data-label="Segundo nombre">' . htmlspecialchars($row['second_name']) . '</td>';
                echo '<td data-label="Apellidos">' . htmlspecialchars($row['last_names']) . '</td>';
                echo '<td data-label="Correo">' . htmlspecialchars($row['email']) . '</td>';
                echo '<td data-label="Teléfono">' . htmlspecialchars($row['phone']) . '</td>';
                echo '<td data-label="Tipo">' . htmlspecialchars($row['user_type']) . '</td>';

                // Check if the user is an administrator
                if ($row['user_type'] === 'Administrador') {
                    echo '<td data-label="Acciones"><button type="button" class="charge_button_disabled" disabled>N/A</button></td>';
                } else {
                    echo '<td data-label="Acciones"><button type="button" class="charge_button" data-client-id="' . htmlspecialchars($row['client_id']) . '">Cobrar</button></td>'; // Cambiar a client_id
                }

                echo '</tr>';
            }

            echo '</table>';
        } else {
            echo '<p>No se encontraron usuarios con ese criterio de búsqueda.</p>';
        }

        // Close the connection
        pg_close($conn);
    } else {
        echo "<p>Error al conectar a la base de datos.</p>";
    }
?>

<!-- Modal -->
<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close-button">&times;</span>
        <h2>Solicitud de Servicio</h2>
        <form id="serviceRequestForm" method="POST" action="insert_service_request.php">
            <input type="hidden" id="fk_client_id" name="fk_client_id" value="">
            <label for="service_type">Tipo de Servicio:</label>
            <input type="text" id="service_type" name="service_type" required><br>

            <label for="actions_taken">Acciones Realizadas:</label>
            <textarea id="actions_taken" name="actions_taken" required></textarea><br>

            <label for="total_cost">Costo Total:</label>
            <input type="number" id="total_cost" name="total_cost" step="0.01" required><br>

            <label for="service_date">Fecha de Servicio:</label>
            <input type="date" id="service_date" name="service_date" required><br>

            <label for="delivery_date">Fecha de Entrega:</label>
            <input type="date" id="delivery_date" name="delivery_date"><br>

            <button type="submit">Enviar</button>
        </form>
    </div>
</div>

<style>
    .modal {
        display: none; /* Oculto por defecto */
        position: fixed; /* Mantener el modal en la pantalla */
        z-index: 1; /* Asegurarse de que esté encima */
        left: 0;
        top: 0;
        width: 100%; /* Ancho completo */
        height: 100%; /* Altura completa */
        overflow: auto; /* Habilitar el desplazamiento si es necesario */
        background-color: rgba(0, 0, 0, 0.5); /* Fondo oscuro */
    }

    .modal-content {
        background-color: #fefefe;
        margin: 15% auto; /* Centrado en la pantalla */
        padding: 20px;
        border: 1px solid #888;
        width: 80%; /* Ancho del modal */
    }

    .close-button {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close-button:hover,
    .close-button:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
</style>

<script>
    // Get the modal
    var modal = document.getElementById("myModal");

    // Get the button that opens the modal
    var buttons = document.querySelectorAll(".charge_button");

    // Assign event to each button to open the modal
    buttons.forEach(function(button){
        button.onclick = function(){
            // Get client ID
            var clientId = this.getAttribute("data-client-id");
            // Set ID to hidden field
            document.getElementById("fk_client_id").value = clientId;
            // Show the modal
            modal.style.display = "block";
        }
    });

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close-button")[0];

    // When the user clicks <span> (x), close the modal
    span.onclick = function(){
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside the modal, close it
    window.onclick = function(event){
        if (event.target == modal){
            modal.style.display = "none";
        }
    }
</script>
