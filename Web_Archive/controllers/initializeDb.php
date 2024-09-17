<?php
  require('database.php');
try {

  $db->createDatabase();
  $db->samplePopulate();
} catch (\Exception $e) {

  echo $e->getMessage();
  exit();
}

  header("Location: ../views");
 ?>
