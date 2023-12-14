<?php

// Start the session with session $_SESSION['username123321']
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the index.php page after logging out
header("Location: index.php");
exit;
?>
