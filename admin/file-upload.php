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
    <style>
        .flex-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 300px;
        }

        .flex-container>div {
            color: white;
            width: 800px;
            height: 300px;
        }
        .no-js #loader { display: none;  }
        .js #loader { display: block; position: absolute; left: 100px; top: 0; }
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
</head>
<body>
    
    <!--Navigation bar-->
    <?php require_once("include/navbar.php"); ?>

    <!--Main content Area-->
    <div class="container">
        <div class="flex-container">
            <div style="margin-top:10%; border: 2px dotted DodgerBlue;">
                <div class="alert alert-info" id="output" style="display:none; font-size: 18px;margin:110px 200px;">OK</div>
                <form style="margin: 0 auto;width: 100%; height:100%;" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data" id="excel-form">
                    <div class="alert alert-primary specifier" style="margin:0;padding:0;display:none">
                        <div class="row">
                            <input id="start-row" name="start-row" type="text" style="max-width:120px;margin-left: 35% !important" class="form-control form-control-sm col m-1" placeholder="Start Row: ">
                            <input id="end-row" name="end-row" type="text" style="max-width:120px" class="form-control form-control-sm col m-1" placeholder="End Row: ">
                        </div>
                    </div>
                    <label for="file" id="forFile" style="color: #999;text-align: center;font-size: 20px; cursor: pointer; margin:0 auto;padding:0;width:100%; height: 100%">
                        <i class="far fa-user" style="z-index: 999;color:#000;display:none"></i>Click here to upload your file.
                    </label>
                    <input type="file" id="file" name="file" style="display:none" accept=".xls,.xlsx" />
                    <button type="submit" id="extractFile" name="extractFile" class="btn btn-primary" style="float:right;display: none">Extract File Data</button>  
                </form>
            </div>
        </div>
    </div>

    <?php require_once("include/footer.php"); ?>
    <script>
        $(document).on({
            ajaxStart: function(){
                $("body").addClass("loading"); 
            },
            ajaxStop: function(){ 
                $("body").removeClass("loading"); 
            }    
        });

		//function to display selected image
		function readURL(input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();
				reader.onload = function (e) {
					$('#image_upload_preview').attr('src', e.target.result);
				}
				reader.readAsDataURL(input.files[0]);
			}
		}

        $("#file").change(function () {
			$(".specifier").fadeIn("slow");
            $("#forFile").text($("#file").val());
            $(".fa-user").slideToggle();
        });

        $(window).load(function() {
		// Animate loader off screen
            $(".se-pre-con").fadeOut("slow");
        });
    </script>
</body>
</html>

    <?php
		require_once ('../classes/admin_handler.php');
		$admin = new AdminHandler();

        if (isset($_POST["extractFile"])) {

            if ($admin->getSettingDueStatus() == 0) {
                echo '<script>alert("No semester has been set! To set a semester, go to Settings > Semester Setup");</script>';
            } else {

                $allowedFileType = [
                    'application/vnd.ms-excel',
                    'text/xls',
                    'text/xlsx',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                ];
                
                $start = 1;
                $end = 0;
                if (!empty($_POST["start-row"]) && $_POST["start-row"] > 1) {
                    $start = $_POST["start-row"];
                }
                if (!empty($_POST["end-row"]) && $_POST["end-row"] > 0) {
                    $end = $_POST["end-row"];
                }

                if ($end > 0 && $start > $end) {
                    echo '<script>alert("End row number can not be smaller than start row number!");</script>';
                } else {
        
                    if (in_array($_FILES["file"]["type"], $allowedFileType)) {
                        $targetPath = 'uploads/' . $_FILES['file']['name'];
                        if(file_exists($targetPath)) {
                            unlink($targetPath);
                        }
                        if (move_uploaded_file($_FILES['file']['tmp_name'], $targetPath)) {
                            echo "<script>alert('The file ".$_FILES["file"]["name"]. " has been uploaded.')</script>";                         
                            if ($admin->getExcelDataIntoDB($targetPath, $start, $end) < 1) {
                                echo '<script>alert("End row number can not be smaller than start row number!");</script>';
                            }
                        
                        } else {
                            echo "<script>alert('The file upload failed.')</script>"; 
                        }
                    }
                }
            }            
        }
    ?>