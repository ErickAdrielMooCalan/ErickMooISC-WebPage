<?php
session_start(); // start session

// Check if the user is authenticated
if (!isset($_SESSION['user_client'])) {
    header("Location: client-login"); // Redirige al usuario a la página de inicio de sesión si no está autenticado
    exit();
}

// Retrieve user data from the session
$user_client = $_SESSION['user_client'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
        }
        .welcome-message {
            font-size: 24px;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="welcome-message">
        <p>Bienvenido: <?php echo htmlspecialchars($user_client['first_name']); ?> <?php echo htmlspecialchars($user_client['second_name']); ?> <?php echo htmlspecialchars($user_client['last_names']); ?>!</p>
        <p>Tu edad es: <?php echo htmlspecialchars($user_client['age']); ?></p>
    </div>
</body>
</html>