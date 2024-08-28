<?php
session_start(); // Inicia la sesión

// Verifica si el usuario está autenticado
if (!isset($_SESSION['user_client'])) {
    header("Location: login_client.php"); // Redirige al usuario a la página de inicio de sesión si no está autenticado
    exit();
}

// Recupera los datos del usuario de la sesión
$user_client = $_SESSION['user_client'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
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
        <p>Welcome, <?php echo htmlspecialchars($user_client['first_name']); ?> <?php echo htmlspecialchars($user_client['second_name']); ?> <?php echo htmlspecialchars($user_client['last_names']); ?>!</p>
        <p>Your age is: <?php echo htmlspecialchars($user_client['age']); ?></p>
    </div>
</body>
</html>