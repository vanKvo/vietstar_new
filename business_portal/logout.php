<?php 
session_start();
//session_unset(); // free all the session variable
session_destroy(); //  end the complete session
header("Location:index.php");
?>
