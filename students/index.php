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
    <title>E-Pecs | Home</title>
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

        $result = $student->getStudentDataPermit($_SESSION["student"]);
        $threshold = $student->getThreshold();
        $semaca = $student->getSemAndAca();

        if ($threshold[0]["threshold"] < $result[0]["bal"])
            echo '
                <div class="info-board ineligible">
                    Ineligible for permit card!
                </div>
                <div class="content-area">
                    <p class="in-msg">Hello ' . $result[0]["fullname"] . ', you\'ve been tagged as owing. Therefore, you\'re not eligible for a permit card. <br>Please visit account office for more information.</p>
                </div>
                ';
        else {
            echo '
                <div class="info-board eligible">
                    Eligible for permit card!
                </div>
                <div class="content-area">
                    <img class="qr-code-image" src="https://chart.googleapis.com/chart?cht=qr&chs=250x250&chl=' . $result[0]["qr_code"] . '" alt="Error getting QR Code. Please connect to the internet" />

                    <table style="width:100%;border: 1px solid rgb(155, 155, 155); border-collapse: collapse;">
                        <tr style="background: #f1f1f1">
                            <td colspan="2" style="padding: 2px;width: 50%; font-size: 12px;border: 1px solid rgb(155, 155, 155);font-weight: bold; text-align: center;">E-PERMIT CARD</td>
                            <td style="padding: 2px;width: 50%; font-size: 12px; font-weight: bold; text-align: center;">PN: ' . $result[0]["permit"] . '</td>
                        </tr>
                        <tr style="border: 1px solid rgb(155, 155, 155)">
                            <td style="text-align: left; padding: 0px 10px;width: 26%; font-size: 12px; border: 1px solid rgb(155, 155, 155); font-weight: bold;"><img style="width:40px;height:40px;" src="rmu.jpg" alt="" /></td>
                            <td colspan="2" style="text-align: left; padding: 0px 10px;width: 74%; font-size: 12px;">RMU - CILT/DILT/ADILT</td>
                        </tr>
                        <tr>
                            <td style="background: #f1f1f1;border: 1px solid rgb(155, 155, 155);text-align: left; padding: 5px; font-size: 12px; font-weight: bold;">NAME:</td>
                            <td colspan="2" style="text-align: left; padding: 5px; font-size: 12px;">' . $result[0]["fullname"] . '</td>
                        </tr>
                        <tr>
                            <td style="background: #f1f1f1;border: 1px solid rgb(155, 155, 155);text-align: left; padding: 5px; font-size: 12px; font-weight: bold;">PROGRAM:</td>
                            <td style="text-align: left; padding: 5px; font-size: 12px;">' . $result[0]["program"] . '</td>
                            <td rowspan="3" style="text-align: right;padding:5px 10px">
                                <img src="https://chart.googleapis.com/chart?cht=qr&chs=100x100&chl=' . $result[0]["qr_code"] . '" alt="Error getting QR Code. Please connect to the internet"/>
                                    <div style="font-size: 10px; ">YEAR: ' . $semaca[0]["academic_year"] . '</div>
                                </td>
                            </tr>
                            <tr>
                                <td style="background: #f1f1f1;border: 1px solid rgb(155, 155, 155);text-align: left; padding: 5px; font-size: 12px; font-weight: bold;">INDEX NO:</td>
                                <td style="text-align: left; padding: 5px; font-size: 12px;">' . $result[0]["index"] . '</td>
                            </tr>
                            <tr>
                                <td style="background: #f1f1f1;border: 1px solid rgb(155, 155, 155);text-align: left; padding: 5px; font-size: 12px; font-weight: bold;">SEMESTER:</td>
                                <td style="text-align: left; padding: 5px; font-size: 12px;">' . $semaca[0]["semester"] . '</td>
                            </tr>
                        </table>

                        <br><a class="btn btn-primary" href="print-permit.php" id="print-permit-card">Print Permit</a>
                    </div>
                </div>
            ';
        }
        ?>

        <div class="icon-bar">
            <a href="index.php" class="active">
                <i class="bi-house"></i>
            </a>
            <a href="check_balance.php">
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