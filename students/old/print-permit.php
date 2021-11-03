<?php
session_start();
require_once('../vendor/autoload.php');
if (!isset($_COOKIE["login"]) && !isset($_SESSION["student"])) {
    header("Location: ../");
}

require_once("../classes/student_handler.php");
$student = new StudentHandler();

try {
    // Require composer autoload
    // Create an instance of the class:
    $mpdf = new \Mpdf\Mpdf();
    $html = "";

    $result = $student->getStudentDataPermit($_SESSION["student"]);
    $semaca = $student->getSemAndAca();

    $html .= '
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
                <td style="background: #f1f1f1;border: 1px solid rgb(155, 155, 155);text-align: left; padding: 6px;min-width: 120px; font-size: 12px; font-weight: bold;">NAME:</td>
                <td colspan="2" style="text-align: left; padding: 6px;min-width: 120px; font-size: 12px;">' . $result[0]["fullname"] . '</td>
            </tr>
            <tr>
                <td style="background: #f1f1f1;border: 1px solid rgb(155, 155, 155);text-align: left; padding: 6px;min-width: 120px; font-size: 12px; font-weight: bold;">PROGRAM:</td>
                <td style="text-align: left; padding: 6px;min-width: 120px; font-size: 12px;">' . $result[0]["program"] . '</td>
                <td rowspan="3" style="text-align: right;padding:4px 5px">
                    <img src="https://chart.googleapis.com/chart?cht=qr&chs=80x80&chl=' . $result[0]["qr_code"] . '" alt="Error getting QR Code. Please connect to the internet"/>
                    <div style="font-size: 10px; ">YEAR: ' . $semaca[0]["academic_year"] . '</div>
                </td>
            </tr>
            <tr>
                <td style="background: #f1f1f1;border: 1px solid rgb(155, 155, 155);text-align: left; padding: 6px;min-width: 120px; font-size: 12px; font-weight: bold;">INDEX NO:</td>
                <td style="text-align: left; padding: 6px;min-width: 120px; font-size: 12px;">' . $result[0]["index"] . '</td>
            </tr>
            <tr>
                <td style="background: #f1f1f1;border: 1px solid rgb(155, 155, 155);text-align: left; padding: 6px;min-width: 120px; font-size: 12px; font-weight: bold;">SEMESTER:</td>
                <td style="text-align: left; padding: 6px;min-width: 120px; font-size: 12px;">' . $semaca[0]["semester"] . '</td>
            </tr>
        </table>';

    $mpdf->WriteHTML($html);
    // Output a PDF file directly to the browser
    /**/
    $mpdf->SetWatermarkImage("rmu.jpg", 0.2, [50, 50], [70, 18]);
    $mpdf->showWatermarkImage = true;
    $mpdf->Output("myfile.pdf", "D"); //NB: 'D' is for download, 'F' opens in browser
    $mpdf->SetDisplayMode("fullpage");
    $mpdf->list_indent_first_level = 0;
    $mpdf->Output();
} catch (\Exception $e) {
    echo "<script>console.log('" . $e->getMessage() . "');</script>";
}
