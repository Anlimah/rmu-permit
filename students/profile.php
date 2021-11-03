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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Pecs | Profile</title>
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
        ?>
        <div class="content-area">
            <?php
            echo '
                <div class="profile-card card">
                    <div class="profile-image">
                        <i class="user-image bi-person"></i>
                    </div>
                    <div class="profile-info">
                        <div class="profile-item">
                            <span>NAME: </span>
                            <span class="u-name">' . $std_info[0]["fullname"] . '</span>
                        </div>
                        <div class="profile-item">
                            <span>INDEX: </span>
                            <span class="u-index">' . $std_info[0]["index"] . '</span>
                        </div>
                        <div class="profile-item">
                            <span>COURSE: </span>
                            <span class="u-course">' . $std_info[0]["program"] . '</span>
                        </div>
                    </div>
                </div>

                <a class="btn btn-primary" style="padding: 5px" href="javascript:void(0);" id="password-card">Change password</a>
            ';
            ?>
        </div>

        <div class="icon-bar">
            <a href="index.php">
                <i class="bi-house"></i>
            </a>
            <a href="check_balance.php">
                <i class="bi-cash-coin"></i>
            </a>
            <a href="profile.php" class="active">
                <i class="bi-person"></i>
            </a>
            <a href="../qrcode_scanner/">
                <i class="bi-upc-scan"></i>
            </a>
        </div>

        <div class="modal fade" id="change-password">
            <div id="change-passwordModal" class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="change-passwordLabel">Change password</h5>
                        <button type="button" class="close closeModal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post">

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-danger closeModal" data-dismiss="modal">Close/Cancel</button>
                        <button type="button" class="btn btn-success" id="saveOrUpdateStdBtn">Save</button>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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

            $("#password-card").click(function() {
                $("#change-password").toggle("modal");
            });

        });
    </script>
</body>

</html>