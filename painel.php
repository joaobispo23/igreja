<?php
session_start();

// Assuming you have code here to validate the login credentials
// If login is successful, set the session variables
$_SESSION['usuario_id'] = $user_id; // Set this to the logged-in user's ID
$_SESSION['username'] = $username; // Set this to the logged-in user's username

// Redirect to cadastro_visitante.php after successful login
header("Location: sistema/cadastro_visitante.php");
exit();
?>