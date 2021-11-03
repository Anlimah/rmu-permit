<?php
    require_once('../vendor/autoload.php');
    require_once("../classes/admin_handler.php");
    $admin = new AdminHandler();

    try {
        if (isset($_GET["p"])) {
            if (isset($_GET["a"]) && !empty($_GET["a"])) {
                if (isset($_GET["s"]) && !empty($_GET["s"])) {
                    if (isset($_GET["b"]) && !empty($_GET["b"])) {
                        // Require composer autoload
                        // Create an instance of the class:
                        $mpdf = new \Mpdf\Mpdf();
                        $program = "";
                        $data = "";
                        $pdfheader = '<thead>
                                        <tr style="width:100%;background-color:#ccc">
                                            <th style="text-align:left;width:5%;padding:10px 10px;">SNo.</th>
                                            <th style="text-align:left;width:20%;padding:10px 10px">INDEX No.</th>
                                            <th style="text-align:left;width:20%;padding:10px 10px;">PERMIT No.</th>
                                            <th style="text-align:left;width:45%;padding:10px 10px">NAME</th>
                                            <th style="text-align:left;width:10%;padding:10px 10px">BALANCE</th>
                                        </tr>
                                    </thead>';
                        
                        $result = $admin->getReportData($_GET["p"], $_GET["a"], $_GET["s"], $_GET["b"]);
                        $i = 1;
                        foreach ($result as $key => $value) {
                            if (($i % 2) == 1) {
                                $data .= '<tr style="width:100%;background-color:#fff">
                                <td style="padding:5px 10px">'.$i.'</td>
                                <td style="padding:5px 10px">'.$value["index"].'</td>
                                <td style="padding:5px 10px">'.$value["permit"].'</td>
                                <td style="padding:5px 10px">'.$value["fullname"].'</td>
                                <td style="padding:5px 10px">'.$value["bal"].'</td>
                                </tr>';
                            } else {
                                $data .= '<tr style="width:100%;background-color:#eee;">
                                <td style="padding:5px 10px">'.$i.'</td>
                                <td style="padding:5px 10px">'.$value["index"].'</td>
                                <td style="padding:5px 10px">'.$value["permit"].'</td>
                                <td style="padding:5px 10px">'.$value["fullname"].'</td>
                                <td style="padding:5px 10px">'.$value["bal"].'</td>
                                </tr>';
                            }
                            $i += 1;
                        }
                        if ($_GET["p"] == 0) {
                            $program = "CILT/DILT/ADILT";
                        } else {
                            $program = $result[0]["program"];
                        }
                        
                        // Define the Header/Footer before writing anything so they appear on the first page
                        $html = '<h3 align="center">'.$_GET["b"].' '.$program.' Students</h3>
                                <div text-align="left"><span style="font-weight:bold;font-size:14px">Academic Year: </span>'.$result[0]["academic_year"].'</div>
                                <div text-align="left"><span style="font-weight:bold;font-size:14px">Semester: </span>'.$result[0]["semester"].'</div>
                                <table style="width:100%;margin-top:20px;border-collapse: collapse">
                                '.$pdfheader.'
                                <tbody style="font-fammily: arial, sans-serif;">
                                '.$data.'
                                </tbody></table>';
                        
                        $mpdf->WriteHTML($html);

                        $mpdf->SetHTMLFooter('
                        <table width="100%">
                            <tr>
                                <td style="text-align:left;">{DATE j-m-Y}</td>
                                <td style="text-align:right;">{PAGENO}/{nbpg}</td>
                            </tr>
                        </table>');
                        // Output a PDF file directly to the browser
                        /**/$mpdf->SetWatermarkImage("images/rmu logo.jpg", 0.1);
                        $mpdf->showWatermarkImage = true;
                        $mpdf->Output("myfile.pdf", "D"); //NB: 'D' is for download, 'F' opens in browser
                        $mpdf->SetDisplayMode("fullpage");
                        $mpdf->list_indent_first_level = 0;
                        $mpdf->Output();
                    } else {
                        print_r('[{"error":"Invalid input [level - 4]!"}]');
                    }
                } else {
                    print_r('[{"error":"Invalid input [level - 3]!"}]');
                }
            } else {
                print_r('[{"error":"Invalid input [level - 2]!"}]');
            }
        } else {
            print_r('[{"error":"Invalid input [level - 1]!"}]');
        }
    } catch (\Exception $e) {
        echo "<script>console.log('".$e->getMessage()."');</script>";
    }
?>