<?php
session_start();
if (isset($_GET["action"]) && $_GET["action"] == "logout") {
  unset($_COOKIE['student']);
  unset($_SESSION["student"]);
  header("Location:../");
} elseif (!isset($_SESSION["student"])) {
  if (!isset($_COOKIE["student"]) || empty($_COOKIE["student"])) {
    header("Location: ../");
  } else {
    $_SESSION["student"] = $_COOKIE["student"];
  }
}
require_once("../classes/student_handler.php");
$student = new StudentHandler();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once("include/header.php") ?>
  <title>Student Portal</title>
  <style>
    td {
      font-size: 8px;
    }
  </style>
</head>

<body>
  <div id="root-component">
    <div id="header-component">
      <img id="logo" src="rmu.jpg" alt="Regional Maritime University logo" />
      <h3 id="title-component">Permit Card</h3>
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
            <li class="active">Get permit</li>
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

      <div id="content-component" style="padding: 0px 20px;">
        <?php
        $result = $student->getStudentDataPermit($_SESSION["student"]);
        $threshold = $student->getThreshold();
        $semaca = $student->getSemAndAca();
        if ($threshold[0]["threshold"] < $result[0]["bal"])
          echo '<div id="err-msg">
            <h4 style="color: red; margin-top: 50%">Sorry, you have been tagged as owing and therefore not Eligible for a permit card</h4>
          </div>';
        else {
          echo '
          <table style="width:370px;border: 1px solid rgb(155, 155, 155);margin: 100px auto;border-collapse: collapse;">
            <tr style="background: #f1f1f1">
                <td colspan="2" style="padding: 2px;width: 50%; font-size: 12px;border: 1px solid rgb(155, 155, 155);font-weight: bold; text-align: center;">E-PERMIT CARD</td>
                <td style="padding: 2px;width: 50%; font-size: 12px; font-weight: bold; text-align: center;">PN:  ' . $result[0]["permit"] . '</td>
            </tr>    
            <tr style="border: 1px solid rgb(155, 155, 155)">
                <td style="text-align: left; padding: 0px 10px;width: 26%; font-size: 12px; border: 1px solid rgb(155, 155, 155); font-weight: bold;"><img style="width:40px;height:40px;" src="rmu.jpg" alt="" /></td>
                <td colspan="2" style="text-align: left; padding: 0px 10px;width: 74%; font-size: 12px;">RMU - CILT/DILT/ADILT</td>
            </tr>
            <tr>
                <td style="background: #f1f1f1;border: 1px solid rgb(155, 155, 155);text-align: left; padding: 10px;min-width: 120px; font-size: 12px; font-weight: bold;">NAME:</td>
                <td colspan="2" style="text-align: left; padding: 10px;min-width: 120px; font-size: 12px;">' . $result[0]["fullname"] . '</td>
            </tr>
            <tr>
                <td style="background: #f1f1f1;border: 1px solid rgb(155, 155, 155);text-align: left; padding: 10px;min-width: 120px; font-size: 12px; font-weight: bold;">PROGRAM:</td>
                <td style="text-align: left; padding: 10px;min-width: 120px; font-size: 12px;">' . $result[0]["program"] . '</td>
                <td rowspan="3" style="text-align: right;padding:5px 10px">
                    <img src="https://chart.googleapis.com/chart?cht=qr&chs=100x100&chl=' . $result[0]["qr_code"] . '" alt="Error getting QR Code. Please connect to the internet"/>
                    <div style="font-size: 10px; ">YEAR: ' . $semaca[0]["academic_year"] . '</div>
                </td>
            </tr>
            <tr>
                <td style="background: #f1f1f1;border: 1px solid rgb(155, 155, 155);text-align: left; padding: 10px;min-width: 120px; font-size: 12px; font-weight: bold;">INDEX NO:</td>
                <td style="text-align: left; padding: 10px;min-width: 120px; font-size: 12px;">' . $result[0]["index"] . '</td>
            </tr>
            <tr>
                <td style="background: #f1f1f1;border: 1px solid rgb(155, 155, 155);text-align: left; padding: 10px;min-width: 120px; font-size: 12px; font-weight: bold;">SEMESTER:</td>
                <td style="text-align: left; padding: 10px;min-width: 120px; font-size: 12px;">' . $semaca[0]["semester"] . '</td>
            </tr>
        </table>
          <a class="btn btn-primary" href="print-permit.php?student=' . $_SESSION["student"] . '&p=' . $result[0]["index"] . '" id="print-permit-card">Print Permit</a>
          ';
        }
        ?>
      </div>



    </div>
  </div>
</body>
<?php require_once("include/footer.php") ?>

</html>