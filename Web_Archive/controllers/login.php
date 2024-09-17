<?php
require_once('useDatabase.php');
session_start();
define("ERROR", "Invalid username or password.");

if(!isset($_POST["username"]) || !isset($_POST["password"]) || empty($_POST["username"]) || empty($_POST["password"]))
{
  header("Location: ../views/login.php");
  exit();
}

if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_SESSION['logged']) && $_SESSION['logged'] == true)
{
  header("Location: ../views/login.php");
  exit();
}

$username = trim(htmlspecialchars($_POST["username"]));
$password = trim(htmlspecialchars($_POST["password"]));
$hashedPassword = sha1($password);

$sql = "SELECT * FROM `users` WHERE `username`='$username' AND `password` = '$hashedPassword'";
$stmt = $db->connection->prepare($sql);
$stmt->execute();
$rows = $stmt->fetch();

if($rows == 0)
{
  $_SESSION['error'] = ERROR;
  $_SESSION['login'] = true;
  header("Location: ../views/login.php");
}

else
{
  $_SESSION['logged'] = true;
  $_SESSION['user'] = $username;
  $_SESSION['role'] = $rows['role'];
  header("Location: ../views/index.php");
}

?>
