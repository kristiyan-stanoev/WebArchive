<?php
require_once('useDatabase.php');
session_start();
define("SUCCESS", "You have registered successfully.", true);
define("ERROR", "There is already a user with such email or username.", true);

if(!isset($_POST["email"]) || !isset($_POST["username"]) || !isset($_POST["password"]) || empty($_POST["email"]) || empty($_POST["username"]) || empty($_POST["password"]) || strcmp($_SESSION["password"], $_SESSION["repeatPassword"]) != 0)
{
  header("Location: ../views/register.php");
  exit();
}

if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_SESSION['logged']) && $_SESSION['logged'] == true)
{
  header("Location: ../views/login.php");
  exit();
}

$email = trim(htmlspecialchars($_POST["email"]));
$username = trim(htmlspecialchars($_POST["username"]));
$password = trim(htmlspecialchars($_POST["password"]));

$sql = "SELECT * FROM `users` WHERE `email`='$email' OR `username`='$username'";
$stmt = $db->connection->prepare($sql);
$stmt->execute();
$rows = $stmt->fetch();

if($rows > 0)
{
  $_SESSION['error'] = ERROR;
  $_SESSION['register'] = true;
  header("Location: ../views/register.php");
}

else
{

  $_SESSION['logged'] = true;
  $_SESSION['user'] = $username;
  $_SESSION['role'] = "USER";
  $_SESSION['success'] = SUCCESS;
  $hashedPassword = sha1($password);
  $sql = "INSERT INTO `users` (`id`, `email`, `username`, `password`, `role`) VALUES (NULL, '$email', '$username', '$hashedPassword', 'USER')";
  $stmt = $db->connection->prepare($sql);
  $stmt->execute();
  header("Location: ../views/index.php");

}

 ?>
