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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Pecs | Balance</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="new.css">
</head>

<body>
    <nav class="navbar">
        <!-- LOGO -->
        <div class="logo">E-PECS</div>
        <!-- NAVIGATION MENU -->
        <ul class="nav-links">
            <!-- USING CHECKBOX HACK -->
            <input type="checkbox" id="checkbox_toggle" />
            <a for="checkbox_toggle" style="font-size: 16px;" href="?action=logout">Logout</a>
        </ul>
    </nav>

    <main>
        <?php

        require_once("../classes/student_handler.php");
        $student = new StudentHandler();

        $std_info = $student->getStudentDataPermit($_SESSION["student"]);
        $threshold = $student->getThreshold();
        $result = $student->getStudentData($_SESSION["student"]);

        if ($threshold[0]["threshold"] < $result[0]["bal"])
            echo '
                <div class="info-board ineligible">
                    Ineligible for permit card!
                </div>
            ';
        else {
            echo '
                <div class="info-board eligible">
                    Eligible for permit card!
                </div>
            ';
        }
        echo '
            <div class="content-area">
                <div class="user-name">' . $std_info[0]["fullname"] . '</div>
                <div class="balance-card card">
                    <div class="card-hearder">
                        <span class="card-title">My Account</span>
                        <span class="user-number">' . $std_info[0]["index"] . '</span>
                    </div>
                    <hr>
                    <div class="card-body">
                        <div class="available-balance">
                            <span class="available-amount">GHC ' . $result[0]["bal"] . '</span>
                            <span class="av-bal-title">Available Balance</span>
                        </div>
                        <div class="recent-payment">
                            <span class="recent-amount">GHC ' . $result[0]["paid"] . '</span>
                            <span class="rec-pay-title">Recent Payment</span>
                        </div>
                    </div>
                </div>
            </div>
        ';
        ?>

        <div class="icon-bar">
            <a href="index.php">
                <i class="bi-house"></i>
            </a>
            <a href="check_balance.php" class="active">
                <i class="bi-cash-coin"></i>
            </a>
            <a href="profile.php">
                <i class="bi-person"></i>
            </a>
            <a href="../qrcode_scanner/">
                <i class="bi-upc-scan"></i>
            </a>
        </div>

    </main>

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    <script type="text/javascript" src="script.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var id = 1;
            $("#to-finances").click(function() {
                window.location.href = "finances.php?studdent=" + id;
            });

            $("#to-profile").click(function() {
                window.location.href = "profile.php?studdent=" + id;
            });

            $.ajax({
                type: "GET",
                url: "api/test?user=" + 56,
                data: "",
                success: function(result) {
                    console.log(result);
                    var r = JSON.parse(result);
                    console.log(r);
                },
                error: function(result) {
                    console.log(result);
                }
            });

            $("#print-pdf").click(function() {
                if (fetchedData == true) {
                    var program = $("#repInputProgram").val();
                    var acadYr = $("#repInputAcadYr").val();
                    var semester = $("#repInputSemester").val();
                    var bal_status = $("#repInputBalStatus").val();
                    window.location.href = "createPDF.php?p=" + program + "&a=" + acadYr + "&s=" + semester + "&b=" + bal_status;
                }
            });

            if (location.pathname == "/rmu-permit/students/check-balance.php") {
                d3.select("tbody").selectAll("tr").classed("select-student editStd", true)
            }

        });
    </script>
</body>

</html>