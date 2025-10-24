<?php
    session_start();
    
    // Clear all session data
    session_unset();
    session_destroy();
    
    // Redirect to kezdolap.php
    header("Location: kezdolap.php");
    exit();
?>