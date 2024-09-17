<?php

session_start();

if(!isset($_POST['destination']) || $_POST['destination'] == "" || !isset($_POST['postDownloadType']) || $_POST['postDownloadType'] == "" )
{
    header("Location: ../views/archives.php");
    exit();
}
$destination = $_POST['destination'];
$archiveRank = $_POST['postArchiveRank'];
$downloadType = $_POST['postDownloadType'];
$searchBox = $_POST['postSearchBox'];
$delete = $_POST['postDelete'];

if(isset($searchBox) && !empty($searchBox) && isset($archiveRank) && !empty($archiveRank))
{

  header("Location: ../views/index.php");
  exit();
}

chdir($destination);

if($downloadType == "wget")
{
  exec("index.html");
}
else if($downloadType == "Headless Chrome PDF" || $downloadType == "PhantomJS PDF")
{
  exec("index.pdf");
}
else if($downloadType == "Headless Chrome PNG" || $downloadType == "PhantomJS PNG")
{
  exec("index.png");
}

chdir($_SERVER["DOCUMENT_ROOT"]);

if(isset($archiveRank) && !empty($archiveRank))
{

  $_SESSION['archiveRank'] = $archiveRank;
  header("Location: archives.php");
  exit();
}
else if(isset($searchBox) && !empty($searchBox))
{

  $_SESSION['searchBox'] = $searchBox;
  $_SESSION['loadArchive'] = true;
  header("Location: ../views/search.php");
  exit();
}
else if(isset($delete) && $delete == true)
{
  $_SESSION['delete'] = false;
  header("Location: ../views/deleteArchive.php");
  exit();
}
else
{
  header("Location: ../views/index.php");
}


 ?>
