<?php

session_start();

if(!isset($_SESSION['archive']) || $_SESSION['archive'] == false)
{
  header("Location: ../controllers/archives.php");
}
else
{
  $_SESSION['archive'] = false;
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
            <span style="float:right; color:white;   margin-top: 1%; padding-right: 0.5%; text-align: center;"><?php echo nl2br("Username: {$_SESSION['user']}\n"); echo "Role: {$_SESSION['role']}"; ?></span>
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

    <section >
      <h1>Archived pages</h1>
      <form method="post" action="../controllers/archives.php" onsubmit="functionValidation(); return false;">
        <fieldset>
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
            <input type="submit" id="register-btn" value="SEARCH">
          </article>
          <article>
            <label class="error" id="error"><?php

            if(isset($_SESSION["archivePost"]) && $_SESSION["archivePost"] == true)
            {
              echo $_SESSION["error"];
              $_SESSION["error"] = "";
              $_SESSION["archivePost"] = false;
            }
              ?>
            </label>
          </article>
        </fieldset>
      </form>
    </section>
    <section class="info">

        <h3>Information section</h3>
        <p>Types of archive:<br>
        Visible - this type is visible to everyone.<br>
        Premium - this type is visible to all premium members.<br>
        Personal - this type is visible only to the owner of the archive.<br>
        </p>
    </section>
    <section class="_archive">

        <?php
        if(isset($_SESSION['archives']) && count($_SESSION['archives']) > 0 && isset($_SESSION['archiveRank']) && !empty($_SESSION['archiveRank']) && isset($_SESSION['users']) && count($_SESSION['users']) > 0)
        {
          ?>
          <table>
              <tr>
                <th>Date</th>
                <th>URL</th>
                <th>Download Type</th>
                <th>User</th>
              </tr>
              <tr>
          <?php
          $archives = $_SESSION['archives'];
          $users = $_SESSION['users'];
          ?>
          <?php
          for($i = 0; $i < count($archives); $i++)
          {
          ?>
            <article class="arc">

            <td> <h3 class="date_archive"><?php echo $archives[$i]['date']; ?></h3> </td>

              <form class= "form_archive" id="form1" action="../controllers/loadArchive.php" method="post">
                  <td> <a href="javascript:;" onclick="document.getElementById('input').value = '<?php echo $archives[$i]['destination']; ?>'; document.getElementById('postDownloadType').value = '<?php echo $archives[$i]['type']; ?>'; document.getElementById('postArchiveRank').value='<?php echo $_SESSION['archiveRank']; ?>'; document.getElementById('form1').submit();"><?php echo  "{$archives[$i]['url']}"; ?></a> </td> <td> <span><?php  echo "\"{$archives[$i]['type']}\""?></td>  <td><?php  echo "\"{$users[$archives[$i]['userId']]}\"" ?></td></span>
                  <input id="input" type="hidden" name="destination" value="alabala"/>
                  <input id="postArchiveRank" type="hidden" name="postArchiveRank" value="alabala"/>
                  <input id="postDownloadType" type="hidden" name="postDownloadType" value="alabala"/>
              </form>
            <?php
            ?></tr>
            </article>
            <?php
          }
        }
         ?>

         </table>
    </section>
        <?php

        $_SESSION['archiveRank'] = "";
        $_SESSION['archives'] = null;
        $_SESSION['users'] = null;
        ?>

<footer>
  <p>Приложението е направено от: Кристиян Станоев и Алекс Терзийски<br></p>
</footer>
</body>
</html>
