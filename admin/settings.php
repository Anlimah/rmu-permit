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
        #variables {
            background-color: #fff;
            width: 100% !important;
            justify-content: center;
            background-color: #fff !important;
        }
        #variables>div {
            display: flex !important;
            justify-content: space-between;
        }

        #addAcaYr,#addProg {
            border: 1px solid grey;
            width: 100% !important;
            text-align: center;
            padding: 20px;
            background-color: #f1f1f1;
        }

        #addAcaYr {
            margin-right: 20px;
        }

    </style>
</head>
<body>
    <!--Navigation bar-->
    <?php require_once("include/navbar.php"); ?>

    <!--Main content Area-->
    <div class="container">

        <div class="alert alert-light" role="alert" style="height:20px;">
            <!--<span style="float: right;">
                <img src="images/icons8-delete-database-64.png" style="width: 40px; height: 40px; cursor: pointer" name="reset-db" id="reset-db" alt="Reset Database">
            </span>-->
        </div>

        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" id="to-reset-password" href="#password-rest">Password Reset</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="to-variables" href="#variables">Variables</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="to-sem-setup" href="#sem-setup">Semester Setup</a>
            </li>
        </ul>

        <div class="flex-container">

            <div id="reset-passoword" class="bg-light" style="padding:0px 50px; margin:50px 0px;">
                <form action="#" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <h2 style="color: #999; text-align: center">Reset Password</h2>
                        <div class="output"></div>
                    </div>
                    <div class="form-group">
                        <input type="password" name="current-pw" id="current-pw" class="form-control" placeholder="Enter current password">
                    </div>
                    <div class="form-group">
                        <input type="password" name="new-pw" id="new-pw" class="form-control" placeholder="Enter new password...">
                    </div>
                    <div class="form-group">
                        <input type="password" name="re-new-pw" id="re-new-pw" class="form-control" placeholder="Repeat New Password..." aria-describedby="passwordHelp">
                        <small id="passwordHelp" style="font-size: 14px; color: red; display:none; margin:0;padding:0">
                            Password doesn't match!
                        </small> 
                    </div>
                    <button type="button" name="reset-password-btn" id="reset-password-btn" class="btn btn-primary" style="width:100%" disabled>
                        Reset my password <i class="fa fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        
            <div id="variables"  class="bg-light row" style="display:none; padding:0px 50px; margin:50px 0px;">
                <!--<ul class="unstyled-list">
                    <li id="acad" class="open">Academic Year</li>
                    <li id="prog" class="open">Programs</li>
                </ul>-->
                <div>
                    <div id="addAcaYr">
                        <form action="#" method="post" enctype="multipart/form-data" style="margin-right: 10px">
                            <fieldset>
                                <legend>Add Academic Year</legend>
                                <div class="form-group col">
                                    <input type="text" class="form-control" id="set-start-year" placeholder="Start Year">
                                </div>
                                <div class="form-group col">
                                    <input type="text" class="form-control" id="set-end-year" placeholder="End Year">
                                </div>
                                <div class="form-group col">
                                    <button type="button" class="btn btn-primary btn-block" id="save-acad" name="save-acad">Save</button>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                    <div id="addProg">
                        <form action="#" method="post" enctype="multipart/form-data" style="margin-left: 20px">
                            <fieldset>
                                <legend>Add New Program</legend>
                                <div class="form-group col">
                                    <input type="text" class="form-control" id="set-program-name" placeholder="Name">
                                </div>
                                <div class="form-group col">
                                    <textarea name="" id="" rows="3" class="form-control" placeholder="Description"></textarea>
                                </div>
                                <div class="form-group col">
                                    <input type="number" class="form-control" id="set-program-semester" placeholder="Number of semesters">
                                </div>
                                <div class="form-group col">
                                    <button type="button" class="btn btn-primary btn-block" id="save-program" name="save-program">Save</button>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
                
            </div>
        
            <div id="sem-setup" class="bg-light" style="display:none; padding:0px 50px; margin:50px 0px;">
                <form action="" method="post">
                    <div class="row">
                        <div class="col">
                            <label for="start-date"  style="font-size: 16px">Start Date</label>
                            <input type="date" class="form-control" name="start-date" id="start-date">
                        </div>
                        <div class="col">
                            <label for="end-date" style="font-size: 16px">End Date</label>
                            <input type="date" class="form-control" name="end-date" id="end-date">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="academic-year" style="font-size: 16px">Academic Year</label>
                            <select class="form-control select" name="aca" id="aca">
                                <?php
                                    $result = $admin->getAcademicYears();
                                    foreach ($result as $key => $value) {
                                        echo '<option value="'.$value["id"].'">'.$value["academic_year"].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col">
                            <label for="end-date" style="font-size: 16px">Semester</label>
                            <select class="form-control select" name="sem" id="sem">
                                <?php
                                    $result = $admin->getSemesters();
                                    foreach ($result as $key => $value) {
                                        echo '<option value="'.$value["id"].'">'.$value["semester"].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col">
                            <label for="end-date" style="font-size: 16px">Threshold</label>
                            <input type="text" name="thresh" id="thresh" class="form-control" value="0.00">
                        </div>
                    </div>
                    <div class="form-group m-5">
                        <button type="button" class="btn btn-primary btn-block" id="set-semester-btn" name="set-semester-btn">Save</button>
                    </div>
                </form> 
            </div>
            
        </div>

    </div>

    <!--<div class="modal" id="confirm-db-delete" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Existing Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>By clicking 'Continue', existing data in the system will be wipped away completely and cannot be reversed.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" id="continue" class="btn btn-danger">Continue</button>
            </div>
            </div>
        </div>
    </div>-->


    <?php require_once("include/footer.php"); ?>
</body>
</html>