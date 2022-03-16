<?php
//echo 'connect.php file';
  $dsn = 'mysql:host=localhost;dbname=vietstar_shipping';
  $username = 'root';
  $password = 'root';
  /**  Create DB Connection */
  try {
    //$db = new PDO($dsn, $username);
    $db = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
    $error = "Database Error: ";
    $error .= $e->getMessage();
    exit();
}

  
?>	
