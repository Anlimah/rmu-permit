<?php
session_start();
ob_start();
if (isset($_GET["error"])) {
    echo '<script>alert("Oops! Index number and password doesn\'t match!/")</script>';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RMU PERMIT GENERATOR</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/b6cbecd930.js" crossorigin="anonymous"></script>
    <style>
        .flex-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 300px;
        }

        .flex-container>div {
            color: white;
            width: 400px;
            height: 400px;
        }
    </style>
</head>

<body class="flex-container">
    <div style="margin-top:450px;">
        <!--Sign up form-->
        <form id="loginForm" action="u_login.php" method="post" enctype="multipart/form-data" style="padding: 0px 20px">
            <div class="form-group">
                <h5 style="color: #606060;">Log in to your acccount</h5>
                <div class="output"></div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend" name="country" id="country">
                        <div class="input-group-text">
                            <i class="fa fa-at" style="font-size: 14px"></i>
                        </div>
                    </div>
                    <input type="text" name="email" id="email" class="form-control form-control-sm" placeholder="Index Number/Email...">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend" name="passw" id="passw">
                        <div class="input-group-text">
                            <i class="fa fa-lock" style="font-size: 14px"></i>
                        </div>
                    </div>
                    <input type="password" name="password" id="password" class="form-control form-control-sm" placeholder="Password...">
                </div>
            </div>
            <button name="loginBtn" id="loginBtn" class="btn btn-primary" type="submit" style="width:100%">
                Log In <i class="fa fa-paper-plane"></i>
            </button>

            <div style="margin-top: 20px">
                <a href="qrcode_scanner/" style="text-decoration: underline;">Use QR Image scanner</a>
            </div>
        </form>
    </div>
    <?php require_once("include/footer.php"); ?>
</body>

</html>