<?php
    session_start();
    if (isset($_GET["action"]) && $_GET["action"] == "logout") {
        unset($_COOKIE['admin']);
        unset($_SESSION["admin"]);
        header("Location:../");
    } elseif (!isset($_SESSION["admin"])) {
        if (!isset($_COOKIE["admin"]) && !empty($_COOKIE["admin"])) {
            header("Location: ../");
        } else {
            $_SESSION["admin"] = "admin";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once("include/header.php"); ?>
</head>
<body>
    <!--Navigation bar-->
    <?php require_once("include/navbar.php"); ?>

    <!--Main content Area-->
    <div class="container">
        <div class="flex-container" style="margin-top:150px">
            <div class="flex-items" style="height: 140px; border: 1px solid #999; border-radius: 10px">
                <a href="students.php">
                    <i class="fas fa-users" style="font-size: 60px; margin-left: 40%;"></i>
                    <h5 class="text-center">Students</h5>
                </a>
            </div>
            <div class="flex-items" style="height: 140px; border: 1px solid #999; border-radius: 10px">
                <a href="reports.php">
                    <i class="fas fa-file-alt" style="font-size: 60px; margin-left: 40%;"></i>
                    <h5 class="text-center">Reports</h5>
                </a>
            </div>
            <div class="flex-items" style="height: 140px; border: 1px solid #999; border-radius: 10px">
                <a href="file-upload.php">
                    <i class="fas fa-upload" style="font-size: 60px;  margin-left: 40%;"></i>
                    <h5 class="text-center">File Uploads</h5>
                </a>
            </div>
            <div class="flex-items" style="height: 140px; border: 1px solid #999; border-radius: 10px">
                <a href="settings.php">
                    <i class="fas fa-cogs" style="font-size: 60px;  margin-left: 40%;"></i>
                    <h5 class="text-center">Settings</h5>
                </a>
            </div>
        </div>
    </div>

    <?php require_once("include/footer.php"); ?>
</body>
</html>