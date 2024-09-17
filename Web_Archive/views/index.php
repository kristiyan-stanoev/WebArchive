<?php

session_start();

?>
<!DOCTYPE html>
<html>
<head>
<title>Web Archive</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="../js/search.js"></script>
<link rel="stylesheet" href="../css/style.css">
</head>
<body id="myPage">
    <header>
        <h1>Welcome to our web archive!</h1>
    </header>
    <nav>
        <button type="button" onclick="window.location.href='index.php'" >Home</button>
        <button type="button" onclick="window.location.href='archives.php'">Archives</button>
        <?php if(!isset($_SESSION['logged']) || $_SESSION['logged'] == false) {?>
          <button type="button" onclick="window.location.href='register.php'">Register</button>
          <button type="button" onclick="window.location.href='login.php'">Login</button>
        <?php } ?>
          <?php if(isset($_SESSION['logged']) && $_SESSION['logged'] == true) {?>
            <button type="button" onclick="window.location.href='createArchive.php'">Create archive</button>
            <button type="button" onclick="window.location.href='deleteArchive.php'">Delete archive</button>
            <span style="float:right; color:white;  margin-top: 1%; padding-right: 0.5%; text-align: center;"><?php echo nl2br("Username: {$_SESSION['user']}\n"); echo "Role: {$_SESSION['role']}"; ?></span>
          <?php } ?>

          <?php if(isset($_SESSION['logged']) && $_SESSION['logged'] == true && isset($_SESSION['role']) && $_SESSION['role'] == "ADMIN") {?>
            <button type="button" onclick="window.location.href='changeUserRole.php'">Change user role</button>
          <?php } ?>
          <?php if(isset($_SESSION['logged']) && $_SESSION['logged'] == true) {?>
            <button type="button" onclick="window.location.href='../controllers/logout.php'">Logout</button>
          <?php } ?>

          <form method="post" action="../controllers/search.php" class="searchForm" onsubmit="searchValidation(); return false;">
            <input type="text" id="searchBox" placeholder="Search.." name="searchBox" class="searchInput">
            <button type="submit" class="searchButton"><img src="../images/search.png" class="icon" ></button>
          </form>

    </nav>

    <?php if(isset($_SESSION['unauthorized']) && $_SESSION['unauthorized'] != "")
    {
      ?>
        <h2 class="error"><?php echo $_SESSION['unauthorized']; ?></h2>
      <?php
      $_SESSION['unauthorized'] ="";
    }
    if(isset($_SESSION['error']) && $_SESSION['error'] != "")
    {
      ?>
        <h2 class="error"><?php echo $_SESSION['error']; ?></h2>
      <?php
      $_SESSION['error'] ="";
    }
    ?>

<section class="info">

  <h3>Information section</h3>
  <p>Hello and welcome to our web archive. <br>
  Here you can find old versions of different web pages,<br>
   make your archives, and delete them if they are useless to you. <br>
   For example, try clicking on one of the logos, <br>
   which will open an archive.<br>
  </p>
</section>
  <div id="slider">
    <ul id="slideWrap">
      <li>
        <form class="s_img" id="form1" action="../controllers/loadArchive.php" method="post">
                      <a href="javascript:;" onclick="document.getElementById('input').value = '../data/facebook.com'; document.getElementById('postDownloadType').value = 'wget'; document.getElementById('form1').submit();"><img src="../images/1.jpg" alt=""></a>
                      <input id="input" type="hidden" name="destination" value="alabala"/>
                      <input id="postDownloadType" type="hidden" name="postDownloadType" value="alabala"/>
          </form>
      </li>
      <li>
      <form class="s_img" id="form1" action="../controllers/loadArchive.php" method="post">
                      <a href="javascript:;" onclick="document.getElementById('input').value = '../data/youtube.com'; document.getElementById('postDownloadType').value = 'wget'; document.getElementById('form1').submit();"><img src="../images/2.webp" alt=""></a>
                      <input id="input" type="hidden" name="destination" value="alabala"/>
                      <input id="postDownloadType" type="hidden" name="postDownloadType" value="alabala"/>
          </form>
      </li>
      <li>
      <form  class="s_img" id="form1" action="../controllers/loadArchive.php" method="post">
                      <a href="javascript:;" onclick="document.getElementById('input').value = '../data/netflix.com/browse'; document.getElementById('postDownloadType').value = 'wget'; document.getElementById('form1').submit();"><img src="../images/3.png" alt=""></a>
                      <input id="input" type="hidden" name="destination" value="alabala"/>
                      <input id="postDownloadType" type="hidden" name="postDownloadType" value="alabala"/>
          </form>
      </li>
      <!-- <li><a href="../data/facebook.com/index.html" target="_blank"><img src="../images/1.jpg" alt=""></a></li> -->
      <!-- <li><a href="../data/youtube.com/index.html" target="_blank"><img src="../images/2.webp" alt=""></a></li> -->
      <!-- <li><a href="../data/instagram.com/index.html" target="_blank"><img src="../images/3.webp" alt="" ></a></li> -->
    </ul>
    <a id="prev"onclick="return false"; href="#">&#8810;</a>
    <a id="next"onclick="return false"; href="#">&#8811;</a>
  </div>

    <footer>
      <p>Приложението е направено от: Кристиян Станоев и Алекс Терзийски<br></p>
    </footer>

<script src="../js/slider.js"></script>
  
</body>
</html>
