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

    require_once("../classes/admin_handler.php");
    $admin = new AdminHandler();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once("include/header.php"); ?>
    <style>
        .arc text {
            font: 10px sans-serif;
            text-anchor: middle; 
        }
        .arc path {
            stroke: #fff;
        }
        .title {
            color: teal;
            font-weight: bold;
            text-align: center;
            width: 100%;
        }
        .flex-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 300px;
        }

        .flex-container>div {
            color: white;
        }

        #dataDisplay {
            width: 300px;
            height: 400px;
        }

        .segments {
            font-size: 12px;
            font-weight: bold;
            fill: #fff;
        }
        svg {
            margin-top: 20px;
        }

        /* Style the sidebar - fixed full height */
        .sidebar {
            height: 430px;
            position: relative;
            overflow-x: hidden;
            padding-top: 16px;
            margin-left: 15px;
            border-top-right-radius: 20px;
            border-bottom-right-radius: 20px;
        }
    </style>
</head>
<body>
    <!--Navigation bar-->
    <?php require_once("include/navbar.php"); ?>
    
    <!--Main content Area-->
    <div class="container" id="main">
        <div class="alert alert-info" role="alert" style="height:50px;">
            <span style="float: right;">
                <ul class="list-inline">
                    <li class="list-inline-item" style="font: 18px bold">Export: </li>
                    <li class="list-inline-item">
                        <form action="createPDF.php" method="post">
                            <label for="print-excel">
                                <img src="images/icons8-microsoft-excel-2019-48.png" style="width: 25px; height: 25px; cursor:pointer" data-toggle="tooltip" data-placement="top" title="Export to Excel" alt="Export to Excel"/>
                            </label>
                            <input type="submit" id="print-excel" name="print-excel" style="display:none">
                        </form>
                    </li>
                    <li class="list-inline-item" style="margin-left: 10px; margin-right: 10px">|</li>
                    <li class="list-inline-item">
                        <form action="createPDF.php" method="post">
                            <label for="print-pdf">
                                <img id="print-pdf" src="images/icons8-pdf-48.png" style="width: 25px; height: 25px; cursor:pointer" data-toggle="tooltip" data-placement="top" title="Export to PDF" alt="Export to PDF"/>
                            </label>
                            <!--<input type="submit" name="print-pdf" style="display:none">-->
                        </form>
                    </li>
                </ul>
            </span>
        </div>

        <div class="row">
            <!-- The sidebar -->
            <div class="sidebar bg-light container col-md-3">
                <form action="" method="" enctype="">
                    <div class="form-group row">
                        <label for="repInputProgram" class="col-sm-5 col-form-label">Program</label>
                        <div class="col-sm-7">
                            <select class="form-control form-control-sm" name="repInputProgram" id="repInputProgram">
                                <option value="0">All</option>
                                <?php 
                                    $result = $admin->getPrograms();
                                    foreach ($result as $key => $value) {
                                        echo '<option value="'.$value["id"].'">'.$value["program"].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="repInputAcadYr" class="col-sm-5 col-form-label">Academic Year</label>
                        <div class="col-sm-7">
                            <select class="form-control form-control-sm" name="repInputAcadYr" id="repInputAcadYr">
                                <option value="0">Select</option>
                                <?php 
                                    $result = $admin->getAcademicYears();
                                    foreach ($result as $key => $value) {
                                        echo '<option value="'.$value["id"].'">'.$value["academic_year"].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="repInputSemester" class="col-sm-5 col-form-label">Semester</label>
                        <div class="col-sm-7">
                            <select class="form-control form-control-sm" name="repInputSemester" id="repInputSemester">
                                <option value="0">Select</option>
                                <?php 
                                    $result = $admin->getSemesters();
                                    foreach ($result as $key => $value) {
                                        echo '<option value="'.$value["id"].'">'.$value["semester"].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="repInputBalStatus" class="col-sm-5 col-form-label">Bal Status</label>
                        <div class="col-sm-7">
                            <select class="form-control form-control-sm" name="repInputBalStatus" id="repInputBalStatus">
                                <option value="0">Select</option>
                                <option value="Eligible">Eligible</option>
                                <option value="Owing">Owing</option>
                                <option value="Owed">Owed</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-5 col-form-label"></label>
                        <div class="col-sm-7">
                            <button type="button" class="btn btn-primary btn-sm" style="width: 100%" id="queryReport" name="queryReport">Apply</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-md-8 bg-light">
                <div id="data-content" style="height:430px">
                    <!--<p style="text-align:center;">Data Display Board</p>-->
                    <table class="table table-striped" id="data-table" style="display: none">
                        <!--<div id="data-title" style="display:none">
                            <h6>Program: <span id="p"></span></h6>
                            <h6>Academic Year: <span id="a"></span></h6>
                            <h6>Semester: <span id="s"></span></h6>
                            <h6>Status: <span id="b"></span></h6>
                        </div>-->
                        <thead class="thead-light" id="data-table-header">
                            <tr>
                                <th scope="col">SNo.</th>
                                <th scope="col">INDEX NUMBER</th>
                                <th scope="col">NAME</th>
                                <th scope="col">BALANCE []</th>
                            </tr>
                        </thead>
                        <tbody id="data-table-body"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="flex-container" id="info1" style="display: none;">
        <div class="alert alert-info">No students data available!</div>
    </div>

    <?php require_once("include/footer.php"); ?>

    <script></script>
</body>
</html>