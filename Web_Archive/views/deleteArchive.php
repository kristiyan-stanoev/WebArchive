<?php

session_start();
if(!isset($_SESSION['deleteArchive']) || $_SESSION['deleteArchive'] == false)
{
  header("Location: ../controllers/deleteArchive.php");
}

?>
<!DOCTYPE html>
<html>
<head>
<title>Web Archive</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="../js/archives.js"></script>
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

    <section><h1>Delete one of your archives</h1></section>
    <section class="_archive">

        <?php
        if(isset($_SESSION['archivesToDelete']) && count($_SESSION['archivesToDelete']) > 0)
        {
          $archives = $_SESSION['archivesToDelete'];

          ?>
              <table>
              <tr>
                <th>Date</th>
                <th>URL</th>
                <th>Archive Rank</th>
                <th>Download Type</th>
                <th>Button</th>
              </tr>
              <tr>
          <?php
          for($i = 0; $i < count($archives); $i++)
          {
          ?>
            <article >

              <td> <h3 class="date_archive"><?php echo $archives[$i]['date']; ?></h3></td>

              <form class="form_archive" id="form1" action="../controllers/loadArchive.php" method="post">
                <td>  <a href="javascript:;" onclick="document.getElementById('input').value = '<?php echo $archives[$i]['destination']; ?>'; document.getElementById('postDownloadType').value = '<?php echo $archives[$i]['type']; ?>'; document.getElementById('postDelete').value=true; document.getElementById('form1').submit();"><?php echo  "{$archives[$i]['url']}"; ?></a></td> <span><td><?php  echo "{$archives[$i]['rank']}"?></td>  <td> <?php  echo  "\"{$archives[$i]['type']}\"" ?></td></span>
                  <input id="input" type="hidden" name="destination" value="alabala"/>
                  <input id="postDelete" type="hidden" name="postDelete" value="alabala"/>
                 <input id="postDownloadType" type="hidden" name="postDownloadType" value="alabala"/>
              </form>

              <td> <form class="btn_del" action="../controllers/deleteArchive.php" method="post">
                <input id="input" type="hidden" name="archiveId" value="<?php echo $archives[$i]['id'] ?>"/>
                <input  type="submit" id="register-btn" value="DELETE">
              </form></td>
            <?php
            ?>
            </tr>

            </article>
            <?php
          }
        }
         ?>
         </table>
    </section>
        <?php

        $_SESSION['success'] = "";
        $_SESSION['error'] = "";
        $_SESSION['deleteArchive'] = null;
        $_SESSION['archivesToDelete'] = null;
        ?>
<footer>
  <p>Приложението е направено от: Кристиян Станоев и Алекс Терзийски<br></p>
</footer>
</body>
</html>
