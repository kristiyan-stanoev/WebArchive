<?php
require_once('useDatabase.php');
session_start();
define("PREMIUM", "premium");
define("PERSONAL", "personal");
define("VISIBLE", "visible");
define("USER", "USER");
define("ADMIN", "ADMIN");
define("PREMIUM_USER", "PREMIUM_USER");
define("SUCCESS", "Archive created successfully!");
define("PATH_ERROR", "There was a problem with the path!");
define("COMMAND_ERROR", "There was a problem with the command!");
define("NOT_AUTHORIZED_ERROR", "You are not authorized to create a Premium archive!");
date_default_timezone_set("Europe/Sofia");

if(($_SERVER['REQUEST_METHOD'] == "GET") || ((!isset($_SESSION['logged']) || $_SESSION['logged'] == false ) || (!isset($_SESSION['user']) || $_SESSION['user'] == "")))
{
  $sql = "SELECT * FROM `archives`  GROUP BY `rank`";
  $stmt = $db->connection->prepare($sql);
  $stmt->execute();
  $archiveRanks = $stmt->fetchAll();

  $_SESSION['archiveRanks'] = $archiveRanks;

  $_SESSION['createArchive'] = true;
  $_SESSION['downloadType'] = "";

  header("Location: ../views/createArchive.php");
  exit();
}

if(!isset($_POST["downloadType"]) || empty($_POST["downloadType"]) || !isset($_POST["url"]) || empty($_POST["url"])|| !isset($_POST["archiveRank"]) || empty($_POST["archiveRank"]))
{
  header("Location: ../views/createArchive.php");
  exit();
}

$downloadType = trim(htmlspecialchars($_POST["downloadType"]));
$url = trim(htmlspecialchars($_POST["url"]));
$archiveRank = trim(htmlspecialchars($_POST["archiveRank"]));

if(isset($_SESSION['logged']) && $_SESSION['logged'] == true && isset($_SESSION['user']) && !empty($_SESSION['user']) && isset($_SESSION['role']) && $_SESSION['role'] == "USER" && strtolower($archiveRank) == PREMIUM)
{
  $_SESSION['createArchive'] = true;
  $_SESSION['error'] = NOT_AUTHORIZED_ERROR;
  header("Location: ../views/createArchive.php");
  exit();
}

$dateDirectory = date("Y/m/d/H/i/s");
$dateDatabase = date("Y-m-d H:i:s");

$urlArray = cleanUrl(parse_url("$url"));

$urlClean = "{$urlArray['user']}{$urlArray['pass']}{$urlArray['host']}{$urlArray['path']}{$urlArray['query']}{$urlArray['fragment']}";

$urlEncoded = encodeUrl($urlClean);

$destination = "../database/{$dateDirectory}/{$urlEncoded}";

$username = $_SESSION['user'];

$absolutePath = "";

if($downloadType == "wget")
{

  exec("..\phantomjs-2.1.1-windows\bin\wget -k -np -p -nH -nd -E -U Mozilla -nc -P {$destination} {$urlClean}");

  $biggestFile = "";
  $biggestFileSize = -1;
  foreach(glob("$destination/*") as $file)
  {
    $fileSize = filesize($file);
    if((substr($file, -4, 4) == "html" || substr($file, -4, 4) == ".htm") && $fileSize > $biggestFileSize)
    {
      $biggestFileSize = $filesize;
      $biggestFile = $file;
    }
  }

  echo $biggestFile;
  rename("{$biggestFile}", "{$destination}/index.html");

  $absolutePath = changeBackSlash(realpath("{$destination}"));

}
else if($downloadType == "Headless Chrome PDF" || $downloadType == "Headless Chrome PNG" || $downloadType == "PhantomJS PDF" || $downloadType == "PhantomJS PNG")
{
  $backSlashDestination = changeForwardSlash($destination);
  exec("mkdir \"$backSlashDestination\"");
  $forwardSlashUrl = changeBackSlash($url);
  $absolutePath = realpath("{$destination}");

  if($downloadType == "Headless Chrome PDF")
  {
    exec("cd C:/Program Files/Google/Chrome/Application && chrome.exe --headless --disable-gpu --run-all-compositor-stages-before-draw --user-data-dir=\"C:\Users\thres\AppData\Local\Google\Chrome\User Data\" --print-to-pdf=\"{$absolutePath}/index.pdf\" $forwardSlashUrl --virtual-time-budget=5000");

    chdir(__DIR__);
  }
  else if($downloadType == "Headless Chrome PNG")
  {
    exec("cd C:/Program Files/Google/Chrome/Application && chrome.exe --headless --disable-gpu --run-all-compositor-stages-before-draw --user-data-dir=\"C:\Users\%username%\AppData\Local\Google\Chrome\User Data\" --window-size=1280,1696 --screenshot=\"{$absolutePath}/index.png\" $forwardSlashUrl --virtual-time-budget=5000");

    chdir(__DIR__);
  }
  else if($downloadType == "PhantomJS PDF")
  {
    exec("..\phantomjs-2.1.1-windows\bin\phantomjs --ssl-protocol=any --ignore-ssl-errors=true ../js/fileGenerator.js \"$forwardSlashUrl\" \"$absolutePath\" pdf");
  }
  else if($downloadType == "PhantomJS PNG")
  {
    exec("..\phantomjs-2.1.1-windows\bin\phantomjs --ssl-protocol=any --ignore-ssl-errors=true ../js/fileGenerator.js \"$forwardSlashUrl\" \"$absolutePath\" png");
  }

  $absolutePath = changeBackSlash($absolutePath);

}

if($absolutePath != "")
{
  $sql = "SELECT * FROM `users` WHERE `username` = '{$username}'";
  $stmt = $db->connection->prepare($sql);
  $stmt->execute();
  $userId = $stmt->fetch()['id'];

  $sql = "INSERT INTO `archives` (`id`, `url`, `rank`, `date`, `type`, `destination`, `userId`) VALUES (NULL, '{$url}', '{$archiveRank}', '{$dateDatabase}', '{$downloadType}', '{$absolutePath}', '{$userId}');";
  $stmt = $db->connection->prepare($sql);
  $stmt->execute();

  $_SESSION['success'] = SUCCESS;

}
else
{
  $_SESSION['error'] = PATH_ERROR;
}

$_SESSION['createArchive'] = true;

header("Location: ../views/createArchive.php");

function cleanUrl($urlArray)
{
  if(substr($urlArray['host'], 0, 4) == "www.")
  {
    $urlArray['host'] = substr($urlArray['host'], 4);
  }

  if(!isset($urlArray['user']))
  {
    $urlArray['user'] = "";
  }
  else
  {
    $urlArray['user'] = "{$urlArray['user']}:";
  }
  if(!isset($urlArray['pass']))
  {
    $urlArray['pass'] = "";
  }
  else
  {
    $urlArray['pass'] = "{$urlArray['pass']}@";
  }
  if(!isset($urlArray['path']))
  {
    $urlArray['path'] = "";
  }
  if(!isset($urlArray['query']))
  {
    $urlArray['query'] = "";
  }
  else
  {
    $urlArray['query'] = "?{$urlArray['query']}";
  }
  if(!isset($urlArray['fragment']))
  {
    $urlArray['fragment'] = "";
  }
  else
  {
    $urlArray['fragment'] = "#{$urlArray['fragment']}";
  }

  return $urlArray;
}

function encodeUrl($str)
{
  $arr = str_split($str);
  for($i = 0; $i < count($arr); $i++)
  {
    if($arr[$i] == "\\") $arr[$i] = "/";
    if($arr[$i] == "?") $arr[$i] = "%3F";
    if($arr[$i] == ":") $arr[$i] = "%3A";
    if($arr[$i] == "*") $arr[$i] = "%2A";
    if($arr[$i] == "\"") $arr[$i] = "%22";
    if($arr[$i] == "<") $arr[$i] = "%3C";
    if($arr[$i] == ">") $arr[$i] = "%3E";
    if($arr[$i] == "|") $arr[$i] = "%7C";
    if($arr[$i] == "#") $arr[$i] = "%23";
  }

  $newStr = implode($arr);
  return $newStr;
}

function changeBackSlash($str)
{
  $arr = str_split($str);
  for($i = 0; $i < count($arr); $i++)
  {
    if($arr[$i] == "\\") $arr[$i] = "/";
  }
  $newStr = implode($arr);
  return $newStr;
}

function changeForwardSlash($str)
{
  $arr = str_split($str);
  for($i = 0; $i < count($arr); $i++)
  {
    if($arr[$i] == "/") $arr[$i] = "\\";
  }
  $newStr = implode($arr);
  return $newStr;
}

?>
