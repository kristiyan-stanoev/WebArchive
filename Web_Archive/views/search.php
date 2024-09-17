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

    <?php if(isset($_SESSION['searchBox']) && !empty($_SESSION['searchBox']) && isset($_SESSION['loadArchive']) && $_SESSION['loadArchive'])
    {
      $_SESSION['loadArchive'] = null;
      $_POST['searchBox'] = $_SESSION['searchBox'];
      ?>
    <form id="myForm" action="../controllers/search.php" method="post">
    <?php
        foreach ($_POST as $a => $b) {
            echo '<input type="hidden" name="'.htmlentities($a).'" value="'.htmlentities($b).'">';
        }
    ?>
    </form>
    <script type="text/javascript">
        document.getElementById('myForm').submit();
    </script>
     <?php
    }
      ?>

    <section>
      <h1>Archived pages visible to you:</h1>
      <section class="_archive">
          <?php
          if(isset($_SESSION['results']) && count($_SESSION['results']) > 0 && isset($_SESSION['users']) && count($_SESSION['users']) > 0)
          {
            $archives = $_SESSION['results'];
            $users = $_SESSION['users'];
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
            for($i = 0; $i < count($archives); $i++)
            {
            ?>
              <article>

             <td> <h3 class="date_archive"><?php echo $archives[$i]['date']; ?></h3></td>

                <form class="form_archive"id="form1" action="../controllers/loadArchive.php" method="post">
                   <td> <a href="javascript:;" onclick="document.getElementById('input').value = '<?php echo $archives[$i]['destination']; ?>'; document.getElementById('postDownloadType').value = '<?php echo $archives[$i]['type']; ?>'; document.getElementById('postSearchBox').value='<?php echo $_SESSION['searchBox']; ?>'; document.getElementById('form1').submit();"><?php echo "{$archives[$i]['url']}"; ?></a></td>  <td><span><?php  echo "\"{$archives[$i]['type']}\"" ?></td> <td><?php  echo "\"{$users[$archives[$i]['userId']]}\"" ?> </td></span>
                    <input id="input" type="hidden" name="destination" value="alabala"/>
                    <input id="postSearchBox" type="hidden" name="postSearchBox" value="alabala"/>
                    <input id="postDownloadType" type="hidden" name="postDownloadType" value="alabala"/>
                </form>
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
      $_SESSION['searchBox'] = "";
      $_SESSION['results'] = null;
       ?>
       <footer>
  <p>Приложението е направено от: Кристиян Станоев и Алекс Терзийски<br></p>
</footer>
</body>
</html>
