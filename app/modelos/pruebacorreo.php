<?php
$to = "tomasoscarcr7@gmail.com";
$subject = "Correo de prueba";
$message = "Este es un correo de prueba.";
$headers = "From: lesly.beca.2024@gmail.com";

if (mail($to, $subject, $message, $headers)) {
    echo "Correo enviado correctamente.";
} else {
    echo "Error al enviar el correo.";
}
