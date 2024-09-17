<?php
session_start();
 ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Archive</title>
    <script src="../js/login.js"></script>
    <script src="../js/search.js"></script>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

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


        <?php
          if(isset($_SESSION['logged']) && $_SESSION['logged'] == true)
          {?>
            <h1>You are already logged in.</h1>
          <?php
          }
          else
          {
        ?>
    <form method="post" action="../controllers/login.php" onsubmit="functionValidation(); return false;">
        <fieldset>
            <legend><h1>Login</h1></legend>
                <section>
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" placeholder="Enter a username"
                        title="Input your username">
                    <label class="error" id="errorUsername"></label>
                </section>

                <section>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" placeholder="Enter a password"
                        title="Input your password">
                    <label class="error" id="errorPassword"></label>
                </section>

                <section>
                  <input type="submit" id="register-btn" value="LOGIN">
                </section>
                <section>
                  <label class="error" id="error">
                    <?php

                    if(isset($_SESSION["login"]) && $_SESSION["login"] == true)
                    {
                      echo $_SESSION['error'];
                      $_SESSION["login"] = false;
                      $_SESSION['error'] = "";
                    }
                      ?>
                  </label>
                </section>
                <label class="error" id="ajaxError"></label>
                <label id="success"></label>
        </fieldset>
    </form>
  <?php }

  ?>
  <footer>
  <p>Приложението е направено от: Кристиян Станоев и Алекс Терзийски<br></p>
</footer>
</body>
</html>
