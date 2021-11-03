<?php
session_start();
if (isset($_GET["action"]) && $_GET["action"] == "logout") {
  unset($_COOKIE['student']);
  unset($_SESSION["student"]);
  header("Location:../");
} elseif (!isset($_SESSION["student"])) {
  if (!isset($_COOKIE["student"]) && !empty($_COOKIE["student"])) {
    header("Location: ../");
  }
}

require_once("../classes/student_handler.php");
$student = new StudentHandler();
?>
<!DOCTYPE html>
<html>

<head>
  <?php require_once("include/header.php") ?>
  <title>Check Balance</title>
</head>

<body>
  <div id="root-component" class="check-bal-root">
    <div id="header-component">
      <img id="logo" src="rmu.jpg" alt="Regional Maritime University logo" />
      <h3 id="title-component">Balance Status</h3>
      <div id="user-profile-summary">
        <div>
          <h4 id="username">Francis</h4>
          <p></p>
        </div>
        <div id="user-logo">
          <h2></h2>
        </div>
      </div>
      <div id="menu-toggle">
        <a href="../qrcode_scanner">
          <i class="fas fa-qrcode" style="color: #000" id="tobble-btn"></i>
        </a>
      </div>
    </div>

    <div id="main-container-component">
      <div id="menu">
        <ul>
          <a href="index.php">
            <li>Get permit</li>
          </a>
          <a href="check_balance.php">
            <li>Check Balance</li>
          </a>
          <a href="profile.php">
            <li>Profile</li>
          </a>
          <a href="?action=logout">
            <li>Log out</li>
          </a>
        </ul>
      </div>

      <div id="side-nav-container">
        <ul id="side-nav">
          <a href="index.php">
            <li>Get permit</li>
          </a>
          <a href="check_balance.php">
            <li class="active">Check Balance</li>
          </a>
          <a href="profile.php">
            <li>Profile</li>
          </a>
          <a href="?action=logout">
            <li>Log out</li>
          </a>
        </ul>
      </div>

      <?php
      $result = $student->getStudentData($_SESSION["student"]);
      echo '
          <div id="content-component">
            <p>CURRENT BALANCE</p>
              <h2 id="current-balance">' . $result[0]["bal"] . '</h2>
              <ul>
                <li>Last payment <span id="last-payment">' . $result[0]["paid"] . '</span></li>
              </ul>
          </div>
        ';
      ?>

    </div>
  </div>
</body>
<?php require_once("include/footer.php") ?>

</html>