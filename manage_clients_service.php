<?php
     // Database connection
     require 'test_connection.php';

    // Initialize the search variable
    $search_term = '';
    $search_query = '';

    if (isset($_GET['search_term']) && !empty($_GET['search_term'])) {
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
                if ($row['user_type'] === 'Administrador'){
                    echo '<td data-label="Acciones"><button type="button" class="charge_button_disabled" disabled>N/A</button></td>';
                }
                else{
                    echo '<td data-label="Acciones"><button type="button" class="charge_button">Cobrar</button></td>';
                }

                echo '</tr>';
            }

            echo '</table>';
        }
        else{
            echo '<p>No se encontraron usuarios con ese criterio de búsqueda.</p>';
        }

        // Close the connection
        pg_close($conn);
    }
    else{
        echo "<p>Error al conectar a la base de datos.</p>";
    }
?>


<!-- Modal -->
<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close-button">&times;</span>
        <p>Contenido del Modal</p>
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
    // Obtener el modal
    var modal = document.getElementById("myModal");

    // Obtener el botón que abre el modal
    var buttons = document.querySelectorAll(".charge_button");

    // Asignar evento a cada botón para abrir el modal
    buttons.forEach(function(button) {
        button.onclick = function() {
            modal.style.display = "block";
        }
    });

    // Obtener el elemento <span> que cierra el modal
    var span = document.getElementsByClassName("close-button")[0];

    // Cuando el usuario hace clic en <span> (x), cerrar el modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // Cuando el usuario hace clic en cualquier parte fuera del modal, cerrarlo
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>