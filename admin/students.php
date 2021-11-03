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
        .btn-xs {
            padding: 1px 5px !important;
            font-size: 12px !important;
            line-height: 1.5 !important;
            border-radius: 3px !important;
        }

        .select-student:hover {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 4px 15px 0 rgba(0, 0, 0, 0.5);
            cursor: pointer;
        }

        .no-js #loader {
            display: none;
        }

        .js #loader {
            display: block;
            position: absolute;
            left: 100px;
            top: 0;
        }

        .se-pre-con {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url(https://smallenvelop.com/wp-content/uploads/2014/08/Preloader_11.gif) center no-repeat #fff;
        }
    </style>
    <script>
        $(window).load(function() {
            // Animate loader off screen
            $(".se-pre-con").fadeOut("slow");;
        });
    </script>
</head>

<body>
    <!--Navigation bar-->
    <?php require_once("include/navbar.php"); ?>

    <!--Main content Area-->
    <div class="container">
        <!--SECOND NAV-->
        <div class="alert alert-light" role="alert">
            <span id="addNewStudent" data-toggle="modal" data-target="#addOrEditStudent">
                <img src="images/icons8-add-user-male-skin-type-7-96.png" style="width:25px; height:25px; cursor:pointer;" data-toggle="tooltip" data-placement="top" title="Add new student" alt="Add a student">
            </span>
            <!--<span style="margin-left: 10px; margin-right: 10px">|</span>
            <span id="deleteStudentIcon">
                <img src="images/icons8-denied-96.png" style="width:25px; height:25px; cursor:pointer;" data-toggle="tooltip" data-placement="top" title="Delete student" alt="Delete student(s)">
            </span>-->
            <span style="margin-left: 10px; margin-right: 10px">|</span>
            <span id="restoreStudentIcon" data-toggle="modal" data-target="#restoreStudentModal">
                <img src="images/icons8-database-restore-96.png" style="width:25px; height:25px; cursor:pointer;" data-toggle="tooltip" data-placement="top" title="List of deleted students" alt="List of deleted students">
            </span>
        </div>

        <!--THIRD NAV-->
        <div class="alert alert-info" role="alert" style="height:60px">
            <span style="float: left">
                <form method="post" action="#">
                    <div class="form-row">
                        <div class="col">
                            <input type="search" id="searchStdIndex" name="searchStdIndex" class="form-control form-control-sm" placeholder="Search">
                        </div>
                        <!--<button type="button" class="btn btn-sm btn-primary">Search</button>-->
                    </div>
                </form>
            </span>

            <form method="post" action="#">
                <span style="float: right">
                    <div class="form-row">
                        <div class="col" style="margin-left: 5px">
                            <button class="btn btn-primary btn-sm" type="button" name="fetch" id="fetch">Fetch</button>
                        </div>
                    </div>
                </span>
                <span style="float: right">
                    <div class="form-row">
                        <div class="col">
                            <select name="stdProg" id="stdProg" class="form-control form-control-sm">
                                <option value="0">Program</option>
                                <?php
                                $result = $admin->getPrograms();
                                foreach ($result as $key => $value) {
                                    echo '<option value="' . $value["id"] . '">' . $value["program"] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </span>
                <span style="float: right;margin:0px 5px">
                    <div class="form-row">
                        <div class="col">
                            <select name="stdSem" id="stdSem" class="form-control form-control-sm">
                                <option value="0">Semester</option>
                                <?php
                                $result = $admin->getSemesters();
                                foreach ($result as $key => $value) {
                                    echo '<option value="' . $value["id"] . '">' . $value["semester"] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </span>
                <span style="float: right">
                    <div class="form-row" style="width:150px">
                        <div class="col">
                            <select name="stdAcad" id="stdAcad" class="form-control form-control-sm">
                                <option value="0">Select year</option>
                                <?php
                                $result = $admin->getAcademicYears();
                                foreach ($result as $key => $value) {
                                    echo '<option value="' . $value["id"] . '">' . $value["academic_year"] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </span>
            </form>
        </div>

        <table class="table table-striped">

            <?php

            require_once('../classes/admin_handler.php');
            $admin = new AdminHandler();

            if (isset($_GET["a"]) && isset($_GET["s"]) && isset($_GET["p"])) {
                $data = $admin->getStudentBySettings($_GET["a"], $_GET["s"], $_GET["p"]);
                if ($data == 0) {
                    echo '<div class="alert" style="text-align:center; min-height:350px;background:#f9f9f9">
                            <p style="margin-top: 12%; color: red; font-wieght: 300; font-size:20px">No student data found!</p>
                        </div>';
                } else {
                    echo '
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col" style="width: 5%">SNo.</th>
                                    <th scope="col" style="width: 20%">INDEX NUMBER</th>
                                    <th scope="col" style="width: 15%">PROGRAM</th>
                                    <th scope="col" style="width: 35%">NAME</th>
                                    <th scope="col" style="width: 20%">BALANCE</th>
                                    <th scope="col" style="width: 5%">ACTION</th>
                                </tr>
                            </thead>
                            <tbody id="tableContent" name="tableContent" style="font-weight:bold">';
                    $i = 1;
                    foreach ($data as $key => $student) {
                        $bal = "";
                        if ($student["bal"] < 0) {
                            $bal = "(" . ($student["bal"] * -1) . ")";
                        } else {
                            $bal = $student["bal"];
                        }
                        echo '<tr id="' . $student["id"] . '" >
                                    <th scope="row">' . $i . '</th>
                                    <td id="in' . $student["id"] . '">' . $student["index"] . '</td>
                                    <td id="P' . $student["id"] . '">' . $student["program"] . '</td>
                                    <td id="fn' . $student["id"] . '">' . $student["fname"] . ' ' . $student["mname"] . ' ' . $student["lname"] . '</td>
                                    <td id="b' . $student["id"] . '">' . $bal . '</td>
                                    <td style="float: right">
                                        <button class="btn btn-primary btn-xs editStd" id="' . $student["id"] . '"><i class="far fa-eye"></i></button>
                                        <button class="btn btn-danger btn-xs deleteStd" id="' . $student["id"] . '">x</button>
                                    </td>
                                </tr>';
                        $i += 1;
                    }
                }
            } else {
                echo '<div class="alert" style="text-align:center; min-height:350px;background:#f9f9f9">
                            <p style="margin-top: 12%">Display students here!</p>
                        </div>';
            }
            ?>
            </tbody>
        </table>

        <!--List of deleted students Modal -->
        <div class="modal fade" id="restoreStudentModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="restoreStudentModalLabel" aria-hidden="true">
            <div id="restoreStudentModalModal" class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="restoreStudentModalLabel">LIST OF ALL DELETED STUDENTS</h5>
                        <button type="button" class="close closeModal" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped" id="deleted-data-table">
                            <?php

                            require_once('../classes/admin_handler.php');
                            $admin = new AdminHandler();

                            $data = $admin->getAllStudent(2);
                            if ($data == 0) {
                                echo '<div class="alert alert-secondary">No student data found!</div>';
                            } else {
                                echo '
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col" style="width: 5%">SNo.</th>
                                            <th scope="col" style="width: 20%">INDEX NUMBER</th>
                                            <th scope="col" style="width: 15%">PROGRAM</th>
                                            <th scope="col" style="width: 40%">NAME</th>
                                            <th scope="col" style="width: 30%"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableContent" name="tableContent" style="font-weight:bold">';
                                $i = 1;
                                foreach ($data as $key => $student) {
                                    echo '<tr id="s' . $student["id"] . '">
                                            <th scope="row">' . $i . '</th>
                                            <td id="in' . $student["id"] . '">' . $student["index"] . '</td>
                                            <td id="P' . $student["id"] . '">' . $student["program"] . '</td>
                                            <td id="fn' . $student["id"] . '">' . $student["fname"] . ' ' . $student["mname"] . ' ' . $student["lname"] . '</td>
                                            <td style="float: right;">
                                                <button id="' . $student["id"] . '"class="btn btn-primary btn-xs restoreStd">Restore</button>
                                                <button id="u' . $student["id"] . '" style="display: none;" class="btn btn-secondary btn-xs undo-restoreStd">Undo</button>
                                            </td>
                                        </tr>';
                                    $i += 1;
                                }
                            }
                            ?>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-danger closeModal" data-dismiss="modal">Close/Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addOrEditStudent" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="addOrEditStudentLabel" aria-hidden="true">
            <div id="addOrEditStudentModal" class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addOrEditStudentLabel">Add a New Student</h5>
                        <button type="button" class="close closeModal" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post">
                            <div class="row">
                                <div id="std-personal" style="margin-left: 25px">
                                    <fieldset>
                                        <legend>Personal Data</legend>
                                        <div class="form-group row">
                                            <label for="inputStdProgram" class="col-sm-4">Program</label>
                                            <div class="col-sm-8">
                                                <select class="form-control" name="inputStdProgram" id="inputStdProgram">
                                                    <option value="0">All</option>
                                                    <?php
                                                    $result = $admin->getPrograms();
                                                    foreach ($result as $key => $value) {
                                                        echo '<option value="' . $value["id"] . '">' . $value["program"] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputStdIndex" class="col-sm-4">Index Number</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="inputStdIndex">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputStdFname" class="col-sm-4">First Name</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="inputStdFname">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputStdMname" class="col-sm-4">Mid. Name</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="inputStdMname">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputStdLname" class="col-sm-4">Last Name</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="inputStdLname">
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-5" id="std-finance" style="display:none">
                                    <fieldset>
                                        <legend>Finance Record</legend>
                                        <div class="form-group row">
                                            <label for="inputStdBill" class="col-sm-4">Semester Bill</label>
                                            <div class="col-sm-8">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text w3-small">
                                                            <span>GHS</span>
                                                        </div>
                                                    </div>
                                                    <input type="text" class="form-control" id="inputStdBill" value="0.00" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputStdBalBF" class="col-sm-4">Balance B/F</label>
                                            <div class="col-sm-8">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text w3-small">
                                                            <span>GHS</span>
                                                        </div>
                                                    </div>
                                                    <input type="text" class="form-control" id="inputStdBalBF" value="0.00" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputStdPaid" class="col-sm-4">Recent Amt Paid</label>
                                            <div class="col-sm-8">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text w3-small">
                                                            <span>GHS</span>
                                                        </div>
                                                    </div>
                                                    <input type="text" class="form-control" id="inputStdPaid" value="0.00" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputStdBal" class="col-sm-4">Balance</label>
                                            <div class="col-sm-8">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text w3-small">
                                                            <span>GHS</span>
                                                        </div>
                                                    </div>
                                                    <input type="text" class="form-control" id="inputStdBal" value="0.00" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <input type="hidden" name="user" id="user">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-danger closeModal" data-dismiss="modal">Close/Cancel</button>
                        <button type="button" class="btn btn-success" id="saveOrUpdateStdBtn">Save</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <?php require_once("include/footer.php"); ?>
</body>

</html>