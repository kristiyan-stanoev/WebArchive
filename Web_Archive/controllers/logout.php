<?php
session_start();

if(isset($_SESSION['logged']) && $_SESSION['logged'] == true)
{
  $_SESSION['logged'] = false;
  $_SESSION['user'] = null;
  $_SESSION['role'] = null;
  session_destroy();
}
 
header("Location: ../views/index.php");
?>
