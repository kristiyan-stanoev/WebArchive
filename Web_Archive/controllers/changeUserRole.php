<?php
require_once('useDatabase.php');
session_start();
define("PREMIUM", "premium");
define("PERSONAL", "personal");
define("VISIBLE", "visible");
define("USER", "USER");
define("ADMIN", "ADMIN");
define("PREMIUM_USER", "PREMIUM_USER");
define("SUCCESS", "User role changed successfully!");
define("ERROR", "The provided user does not exist.");
define("ERROR_EXISTS", "The provided user is already a ");
define("ERROR_ADMIN", "The admin's role cannot be changed.");

if($_SERVER['REQUEST_METHOD'] == "GET")
{
  header("Location: ../views/changeUserRole.php");
  exit();
}

if((!isset($_SESSION["role"]) || $_SESSION["role"] != ADMIN) && (!isset($_POST["username"]) || empty($_POST["username"])))
{
  header("Location: ../views/changeUserRole.php");
  exit();
}

$username = $_POST['username'];
$userRole = $_POST['userRole'];

$sql = "SELECT * FROM `users` WHERE `username` = '$username'";
$stmt = $db->connection->prepare($sql);
$stmt->execute();
$user = $stmt->fetch();

if(!isset($user) || !$user)
{
  $_SESSION['error'] = ERROR;
  $_SESSION['changeUserRole'] = true;

  header("Location: ../views/changeUserRole.php");
  exit();
}

if($user['role'] == ADMIN)
{
  $_SESSION['error'] = ERROR_ADMIN;
  $_SESSION['changeUserRole'] = true;

  header("Location: ../views/changeUserRole.php");
  exit();
}
if($user['role'] == $userRole)
{
  $_SESSION['error'] = ERROR_EXISTS . "$userRole.";
  $_SESSION['changeUserRole'] = true;

  header("Location: ../views/changeUserRole.php");
  exit();
}

$id = $user['id'];

$sql = "UPDATE `users` SET `role` = '$userRole' WHERE `users`.`id` = $id";
$stmt = $db->connection->prepare($sql);
$stmt->execute();

$_SESSION['success'] = SUCCESS;
$_SESSION['changeUserRole'] = true;
header("Location: ../views/changeUserRole.php");

?>
