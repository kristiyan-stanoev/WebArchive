<?php

session_start();

if(!isset($_SESSION['logged']) || $_SESSION['logged'] == false || !isset($_SESSION['role']) || $_SESSION['role'] != "ADMIN")
{
  $_SESSION['unauthorized'] = "You are not authorized to change user roles!";
  header("Location: index.php");
}
if(!isset($_SESSION['userRole']) || $_SESSION['userRole'] == "")
{
  $_SESSION['userRole'] = "";
}

?>
<!DOCTYPE html>
<html>
<head>
<title>Web Archive</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="../js/search.js"></script>
<script src="../js/changeUserRole.js"></script>
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
      <h1>Change a user's role</h1>
      <form method="post" action="../controllers/changeUserRole.php" onsubmit="functionValidation(); return false;">
        <fieldset>
          <article>
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" placeholder="User to change role"
            title="A valid user is required">
            <label class="error" id="errorUsername"></label>
          </article>
          <article>
            <label for="userRole">User role:</label>
            <select id="userRole" name="userRole">
              <option value="USER">USER</option>
              <option value="PREMIUM_USER">PREMIUM_USER</option>
              <option value="ADMIN">ADMIN</option>
            </select>

            <script type="text/javascript">
            document.getElementById('userRole').value = "<?php echo $_SESSION['userRole'];  ?>";
            </script>
            <label class="error" id="errorUserRole"></label>
          </article>
          <article>
            <input type="submit" id="register-btn" value="CHANGE">
          </article>
          <article>
            <?php
            if(isset($_SESSION["changeUserRole"]) && $_SESSION["changeUserRole"] == true && isset($_SESSION["error"]) && $_SESSION["error"] != "")
            {
              ?>
            <label class="error" id="error">
              <?php
              echo $_SESSION["error"];
              ?></label>
              <?php
            }

              if(isset($_SESSION['success']) && $_SESSION['success'] != "")
              {
             ?>
            <label class="success" id="success">
            <?php echo $_SESSION['success'] ?>
          </label>
        </article>
        </fieldset>
        <?php
      }
      $_SESSION['success'] = "";
      $_SESSION["error"] = "";
      $_SESSION["changeUserRole"] = false;
      ?>
      </form>
    </section>
    <footer>
  <p>Приложението е направено от: Кристиян Станоев и Алекс Терзийски<br></p>
</footer>
</body>
</html>
