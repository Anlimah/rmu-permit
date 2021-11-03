<?php
session_start();
if (isset($_GET["action"]) && $_GET["action"] == "logout") {
  unset($_COOKIE['student']);
  unset($_SESSION["student"]);
  header("Location:../");
} elseif (!isset($_SESSION["admin"])) {
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
  <title>Profile</title>
</head>

<body>
  <div id="root-component" class="profile-root">
    <div id="header-component">
      <img id="logo" src="rmu.jpg" alt="RMU logo" />
      <h3 id="title-component">Student Profile</h3>
      <div id="user-profile-summary">
        <div>
          <h4 id="username"></h4>
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
      <div id="menu" class="sidebar">
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
          <li><a href="index.php">Get permit</a></li>
          <li><a href="check_balance.php">Check Balance</a></li>
          <li class="active"><a href="profile.php">Profile</a></li>
          <li><a href="?action=logout">Log out</a></li>
        </ul>
      </div>

      <div id="content-component">
        <div id="profile-component">
          <i class="fas fa-user-circle"></i>

          <?php
          $result = $student->getStudentDataPermit($_SESSION["student"]);
          echo '<table id="user-details">
              <tr>
                <td>Name:</td> 
                <td><span id="name">' . $result[0]["fullname"] . '</span></td>
              <tr>
              <tr>
                <td>Course:</td> 
                <td><span id="course">' . $result[0]["program"] . '</span></td>
              </tr>
              <tr>
                <td>Index No. :</td> 
                <td><span id="index-number">' . $result[0]["index"] . '</span></td>
              </tr>
          </table>'
          ?>
        </div>
      </div>
    </div>
  </div>
</body>

<?php require_once("include/footer.php") ?>

</html>