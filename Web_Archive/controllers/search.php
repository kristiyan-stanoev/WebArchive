<?php
require_once('useDatabase.php');
session_start();
define("PREMIUM", "premium");
define("PERSONAL", "personal");
define("VISIBLE", "visible");
define("USER", "USER");
define("ADMIN", "ADMIN");
define("PREMIUM_USER", "PREMIUM_USER");


if(($_SERVER['REQUEST_METHOD'] == "GET") || !isset($_POST['searchBox']) || $_POST['searchBox'] == "")
{
  header("Location: ../views/index.php");
  exit();
}

$searchBox = trim(htmlspecialchars($_POST['searchBox']));

var_dump($searchBox);
if((!isset($_SESSION['logged']) || $_SESSION['logged'] == false ))
{
  $sql = "SELECT * FROM `archives` WHERE `rank` = 'Visible' AND `url` LIKE '%$searchBox%' ORDER BY `date` DESC ";
  $stmt = $db->connection->prepare($sql);
  $stmt->execute();
  $results = $stmt->fetchAll();
}
else if(isset($_SESSION['role']))
{
  $user = $_SESSION['user'];
  $sql = "SELECT * FROM `users` WHERE `username` = '$user'";
  $stmt = $db->connection->prepare($sql);
  $stmt->execute();
  $id = $stmt->fetch()['id'];

  if($_SESSION['role'] == USER)
  {
    $sql = "SELECT * FROM `archives` WHERE `rank` = 'Visible' AND `url` LIKE '%$searchBox%' UNION
            SELECT * FROM `archives` WHERE `rank` = 'Personal' AND `userId` = $id AND `url` LIKE '%$searchBox%'
            ORDER BY `date` DESC";
  }
  else if($_SESSION['role'] == PREMIUM_USER || $_SESSION['role'] == ADMIN)
  {
    $sql =
    "SELECT * FROM `archives` WHERE (`rank` = 'Visible' OR `rank` = 'Premium') AND `url` LIKE '%$searchBox%' UNION
            SELECT * FROM `archives` WHERE `rank` = 'Personal' AND `userId` = $id AND `url` LIKE '%$searchBox%'
            ORDER BY `date` DESC";
  }

  $stmt = $db->connection->prepare($sql);
  $stmt->execute();
  $results = $stmt->fetchAll();
}

$sql = "SELECT * FROM `users`";
$stmt = $db->connection->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll();

foreach ($users as $user) {
  $filteredUsers[$user['id']] = $user['username'];
}

$_SESSION['users'] = $filteredUsers;

$_SESSION['results'] = $results;
$_SESSION['searchBox'] = $searchBox;
$_SESSION['search'] = true;
header("Location: ../views/search.php");


?>
