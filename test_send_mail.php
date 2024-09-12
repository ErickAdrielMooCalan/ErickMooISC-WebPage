<?php
    $to = "erickadrielmoocalan498@gmail.com";
    $subject = "Prueba de servicio SMTP";
    $message = "Este es un correo de prueba para verificar el funcionamiendo del servidor SMTP";
    $headers = "From: erick.moo.isc@gmail.com";

    // Send mail
    if (mail($to, $subject, $message, $headers)) {
        echo "Correo enviado correctamente!";
    } else {
        echo "Error al enviar el correo.";
    }
?>