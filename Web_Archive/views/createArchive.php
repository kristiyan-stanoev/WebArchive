<?php

session_start();

if(!isset($_SESSION['logged']) || $_SESSION['logged'] == false)
{
    header("Location: ../views/index.php");
    exit();
}

if(!isset($_SESSION['createArchive']) || $_SESSION['createArchive'] == "")
{
  $_SESSION['archiveRank'] = "";
}

if(!isset($_SESSION['downloadType']) || $_SESSION['downloadType'] == "")
{
  $_SESSION['downloadType'] = "";
}

?>
<!DOCTYPE html>
<html>
<head>
<title>Web Archive</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="../js/search.js"></script>
<script src="../js/createArchive.js"></script>
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

    <section>

      <h1>Archive a web page</h1>
      <form method="post" action="../controllers/createArchive.php" onsubmit="functionValidation(); return false;">
          <fieldset>
              <article>
                <label for="url">URL:</label>
                <input type="text" name="url" id="url" placeholder="Enter a URL"
                title="A valid URL is needed.">
                <label class="error" id="errorUrl"></label>
              </article>
              <article>
                <label for="archiveRank">Archive rank:</label>
                <select id="archiveRank" name="archiveRank">
                   <option value="Visible">Visible</option>
                   <option value="Premium">Premium</option>
                   <option value="Personal">Personal</option>
                </select>

                <script type="text/javascript">
                  document.getElementById('archiveRank').value = "<?php echo $_SESSION['archiveRank'];  ?>";
                </script>
                <label class="error" id="errorRank"></label>
              </article>
              <article>
                <label for="downloadType">Download type:</label>
                <select id="downloadType" name="downloadType">
                  <option value="wget">wget</option>
                  <option value="PhantomJS PDF">PhantomJS PDF</option>
                  <option value="PhantomJS PNG">PhantomJS PNG</option>
                  <option value="Headless Chrome PDF">Headless Chrome PDF</option>
                  <option value="Headless Chrome PNG">Headless Chrome PNG</option>
                </select>

                <script type="text/javascript">
                  document.getElementById('downloadType').value = "<?php echo $_SESSION['downloadType'];  ?>";
                </script>
                <label class="error" id="errorDownload"></label>
              </article>
              <article>
                <input type="submit" id="register-btn" value="CREATE">
              </article>
              <article>
                <?php
                if(isset($_SESSION["createArchive"]) && $_SESSION["createArchive"] == true && isset($_SESSION["error"]) && $_SESSION["error"] != "")
                { ?>

                <label class="error" id="error">
                  <?php
                  echo $_SESSION["error"];
                  ?>
                  </label>
                  <?php
                }
                  ?>
              </article>
              <label class="error" id="ajaxError"></label>
              <?php
                if(isset($_SESSION['success']) && $_SESSION['success'] != "")
                {
               ?>
              <label class="success" id="success">
                <?php echo $_SESSION['success'] ?>
              </label>
            <?php
                }
                $_SESSION['archiveRank'] = "";
                $_SESSION['downloadType'] = "";
                $_SESSION['success'] = "";
                $_SESSION["error"] = "";
                $_SESSION["createArchive"] = false;
              ?>
          </fieldset>
      </form>

    </section>
    <footer>
  <p>Приложението е направено от: Кристиян Станоев и Алекс Терзийски<br></p>
</footer>
</body>
</html>
