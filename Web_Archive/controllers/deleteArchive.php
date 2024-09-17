<?php
require_once('useDatabase.php');
session_start();
define("PREMIUM", "premium");
define("PERSONAL", "personal");
define("VISIBLE", "visible");
define("USER", "USER");
define("ADMIN", "ADMIN");
define("PREMIUM_USER", "PREMIUM_USER");
define("ERROR_NOT_OWNER_OR_NOT_EXIST", "You are not the owner of the archive or this archive does not exist!");
define("SUCCESS", "Archive deleted successfully!");

if(!isset($_SESSION['logged']) || $_SESSION['logged'] == false || !isset($_SESSION['user']) || $_SESSION['user'] == "")
{
  header("Location: ../views/login.php");
  exit();
}
$user = $_SESSION['user'];

$sql = "SELECT * FROM `users`  WHERE `username` = '$user'";
$stmt = $db->connection->prepare($sql);
$stmt->execute();
$userId = $stmt->fetch()['id'];
if(!$userId)
{
  header("Location: ../views/login.php");
  exit();
}

$sql = "SELECT * FROM `archives`  WHERE `userId` = '$userId' ORDER BY `date` DESC";
$stmt = $db->connection->prepare($sql);
$stmt->execute();
$archivesToDelete = $stmt->fetchAll();

if($_SERVER['REQUEST_METHOD'] == "GET")
{
  $_SESSION['deleteArchive'] = true;
  $_SESSION['archivesToDelete'] = $archivesToDelete;
  header("Location: ../views/deleteArchive.php");
  exit();
}
else if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['archiveId']) && $_POST['archiveId'] != null)
{
  $archiveId = $_POST['archiveId'];

  $sql = "SELECT * FROM `archives`  WHERE `id` = '$archiveId'";
  $stmt = $db->connection->prepare($sql);
  $stmt->execute();
  $archiveToDelete = $stmt->fetch();

  if($archiveToDelete['userId'] != $userId)
  {
    $_SESSION['error'] = ERROR_NOT_OWNER_OR_NOT_EXIST;
    header("Location: ../views/index.php");
    exit();
  }

  $sql = "DELETE FROM `archives` WHERE `id` = '$archiveId'";
  $stmt = $db->connection->prepare($sql);
  $stmt->execute();

  $sql = "SELECT * FROM `archives`  WHERE `userId` = '$userId' ORDER BY `date` DESC";
  $stmt = $db->connection->prepare($sql);
  $stmt->execute();
  $archivesToDelete = $stmt->fetchAll();

  $_SESSION['deleteArchive'] = true;
  $_SESSION['archivesToDelete'] = $archivesToDelete;
  $_SESSION['success'] = SUCCESS;
  header("Location: ../views/deleteArchive.php");
  exit();
}

header("Location: ../views/index.php");
exit();
?>
