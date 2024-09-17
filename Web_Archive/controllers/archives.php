<?php
require_once('useDatabase.php');
session_start();
define("PREMIUM", "premium");
define("PERSONAL", "personal");
define("VISIBLE", "visible");
define("USER", "USER");
define("ADMIN", "ADMIN");
define("PREMIUM_USER", "PREMIUM_USER");

if($_SERVER['REQUEST_METHOD'] == "GET" && (!isset($_SESSION['archiveRank']) || $_SESSION['archiveRank'] == ""))
{
  $sql = "SELECT * FROM `archives`  GROUP BY `rank`";
  $stmt = $db->connection->prepare($sql);
  $stmt->execute();
  $archiveRanks = $stmt->fetchAll();

  $_SESSION['archive'] = true;
  $_SESSION['archiveRanks'] = $archiveRanks;
  header("Location: ../views/archives.php");
  exit();
}

if((!isset($_POST["archiveRank"]) || empty($_POST["archiveRank"])) && (!isset($_SESSION["archiveRank"]) || empty($_SESSION["archiveRank"])))
{
  header("Location: ../views/archives.php");
  exit();
}


$archiveRank = $_POST["archiveRank"] != "" ? $_POST["archiveRank"] : $_SESSION['archiveRank'];


if (strtolower($archiveRank) == PREMIUM)
{

  if((!isset($_SESSION['logged']) || $_SESSION['logged'] == false )||($_SESSION['role'] == USER))
  {
    $_SESSION['error'] = 'You are not authorized to access '. PREMIUM .' archives.';
    $_SESSION['archivePost'] = true;
  }
  else
  {
    $sql = "SELECT * FROM `archives` WHERE `rank` = '$archiveRank' ORDER BY `date` DESC ";
    $stmt = $db->connection->prepare($sql);
    $stmt->execute();
    $archives = $stmt->fetchAll();

    $_SESSION['archives'] = $archives;
  }
}
else if(strtolower($archiveRank) == PERSONAL)
{
  if((!isset($_SESSION['logged']) || $_SESSION['logged'] == false ))
  {
    $_SESSION['archivePost'] = true;
    $_SESSION['error'] = 'Log in to see '. PERSONAL .' archives.';
  }
  else
  {
    $user = $_SESSION['user'];
    $sql = "SELECT * FROM `users` WHERE `username` = '$user'";
    $stmt = $db->connection->prepare($sql);
    $stmt->execute();
    $id = $stmt->fetch()['id'];

    $sql = "SELECT * FROM `archives` WHERE `rank` = '$archiveRank' AND `userId` = '$id' ORDER BY `date` DESC ";
    $stmt = $db->connection->prepare($sql);
    $stmt->execute();
    $archives = $stmt->fetchAll();

    $_SESSION['archives'] = $archives;
  }


}
else if(strtolower($archiveRank) == VISIBLE)
{
  $sql = "SELECT * FROM `archives` WHERE `rank` = '$archiveRank' ORDER BY `date` DESC ";
  $stmt = $db->connection->prepare($sql);
  $stmt->execute();
  $archives = $stmt->fetchAll();

  $_SESSION['archives'] = $archives;
}

if(isset($_SESSION['archives']))
{
  $sql = "SELECT * FROM `users`";
  $stmt = $db->connection->prepare($sql);
  $stmt->execute();
  $users = $stmt->fetchAll();

  foreach ($users as $user) {
    $filteredUsers[$user['id']] = $user['username'];
  }

  $_SESSION['users'] = $filteredUsers;
}
$_SESSION['archive'] = true;
$_SESSION['archiveRank'] = $archiveRank;

header("Location: ../views/archives.php");



?>
