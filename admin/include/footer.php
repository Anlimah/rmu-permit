<!--Make Payment modal-->
<div class="modal" id="semset" tabindex="-2"  data-backdrop="static" data-keyboard="false"  aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Setup semester</h6>
            </div>
            <div class="modal-body">
                <p>Please, it is required you set up a semester before can use some advanced features of this application.</p>
            </div>
            <div class="modal-footer">
                <button type="button" id="set-later" class="btn btn-secondary btn-sm closeModal" data-dismiss="modal">Later</button>
                <a href="settings.php?action=true" class="btn btn-success btn-sm">Go to settings</a>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
<script type="text/javascript" src="../js/d3/d3.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    
    //get variable(parameters) from url
    function getUrlVars() {
        var vars = {};
        var parts = window.location.href.replace(
            /[?&]+([^=&]+)=([^&]*)/gi,
            function(m, key, value) {
                vars[key] = value;
            }
        );
        return vars;
    }

    //when the parameter is missing from the URL the value will be undefined so we set a value, used with getUrlVars.
    function getUrlParam(parameter, defaultvalue) {
        var urlparameter = defaultvalue;
        if (window.location.href.indexOf(parameter) > -1) {
            urlparameter = getUrlVars()[parameter];
        }
        return urlparameter;
    }

    //Creates a new cookie
    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
        var expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=index.php";
    }

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });

    /*$("#tester").click(function () {
        $.ajax({
            type : "GET",
            url  : "api/test?k="+1,
            data : "",
            success: function (result) {
                console.log(result);
                var r = JSON.parse(result);
                console.log(r);
            },
            error: function (result) {
                console.log(result);
            }
        });
    });*/

    function getSettingsStatus() {
        $.ajax({
            type : "GET",
            url  : "api/semset",
            data : "",
            success: function (result) {
                console.log(result);
                if (result <= 0) {
                    $("#semset").modal("toggle");
                    $("#set-indicator").attr("class", "badge badge-danger");
                } else {
                    $("#set-indicator").attr("class", "badge badge-success");
                }
            },
            error: function (result) {
                console.log(result);
            }
        });
    }
    
    if (location.pathname != "/BCS21finalyearproject/admin/settings.php") {
        getSettingsStatus();
    }

    //Active Tab
    if (location.pathname == "/BCS21finalyearproject/admin/index.php" || location.pathname == "/BCS21finalyearproject/admin/") {
        $("#home").attr("class", "nav-item link active-i");
    } else if (location.pathname == "/BCS21finalyearproject/admin/students.php") {
        $("#students").attr("class", "nav-item link active-i");
    } else if (location.pathname == "/BCS21finalyearproject/admin/reports.php") {
        $("#reports").attr("class", "nav-item link active-i");
    } else if (location.pathname == "/BCS21finalyearproject/admin/file-upload.php") {
        $("#uploads").attr("class", "nav-item link active-i");
    } else if (location.pathname == "/BCS21finalyearproject/admin/settings.php") {
        $("#settings").attr("class", "nav-item link active-i");
    }

    var editStdData = false;

    $("#loginBtn1").click(function () {
        let email = $("#email").val();
        let password = $("#password").val();

        if (email == "" || email == undefined) {
            alert("Email or password is required!");
        } else if (password == "" || password == undefined) {
            alert("Email or password is required!");
        } else {
            $.ajax({
                type : "POST",
                url  : "api/loginUser?email="+email+"&password="+password,
                data : "",
                success: function (result) {
                    console.log(result);
                    if (result != 0) {
                        setCookie("user", "user", 0.00067);
                        if (result == 1) {
                            $(".output").html("<div class='alert alert-success'>"+
                                "<button class='close' data-dismiss='alert'><span>×</span></button>"+
                                "<strong>Login successfull!</strong></div>").fadeIn("slow", function () {
                                $(".output").fadeOut(3000);
                                window.location.href = "index.php";
                            });
                        } else if (result == 2) {
                            $(".output").html("<div class='alert alert-success'>"+
                                "<button class='close' data-dismiss='alert'><span>×</span></button>"+
                                "<strong>Login successfull!</strong></div>").fadeIn("slow", function () {
                                $(".output").fadeOut(3000);
                                window.location.href = "../students/index.php";
                            });
                        }
                    }else{
                        $(".output").html("<div class='alert alert-danger'>"+
                            "<button class='close' data-dismiss='alert'><span>×</span></button>"+
                            "<strong>User not found!</strong></div>").fadeIn("slow", function () {
                            $(".output").fadeOut(5000);
                        });
                    }
                },
                error: function (result) {
                    console.log(result);
                }
            });
        }
    });

    var reloader = "";

    $("#fetch").click(function () {
        window.location.href = "students.php?a="+$("#stdAcad").val()+"&s="+$("#stdSem").val()+"&p="+$("#stdProg").val();
    });

    if (getUrlParam("a", 0) != undefined && getUrlParam("s", 0) != undefined && getUrlParam("p", 0) != undefined) {
        $("#stdAcad").val(getUrlParam("a", 0));
        $("#stdSem").val(getUrlParam("s", 0));
        $("#stdProg").val(getUrlParam("p", 0));
    }

    $(".editStd").click(function () {
        var user = $(this).attr("id");
        $("#addOrEditStudent").modal()
        $("#addOrEditStudentLabel").text("Edit Student Details");
        $.ajax({
            type : "POST",
            url  : "api/getStudent?user="+user,
            data : "",
            success: function (result) {
                console.log(result);
                var r = JSON.parse(result);
                console.log(r);
                
                $("#inputStdIndex").attr("value", r[0]["index"]);
                $("#inputStdFname").attr("value", r[0]["fname"]);
                $("#inputStdMname").attr("value", r[0]["mname"]);
                $("#inputStdLname").attr("value", r[0]["lname"]);
                $("#inputStdBill").attr("value", r[0]["bill"]);
                $("#inputStdBalBF").attr("value", r[0]["balBF"]);
                $("#inputStdBal").attr("value", r[0]["bal"]);
                $("#inputStdPaid").attr("value", r[0]["paid"]);
                $("#inputStdProgram").val(r[0]["pid"]);

                editStdData = true;
                $("#user").attr("value", user);
                $("#std-personal").attr("class", "col-md-5");
                $("#std-finance").show();
            },
            error: function (result) {
                console.log(result);
            }
        });
    });

    $(".deleteStd").click(function () {
        var answer = confirm("Are you sure you want to delete this student's data?")
        if (answer) {
            var user = $(this).attr("id");
            $.ajax({
                type : "POST",
                url  : "api/deleteStudent?user="+user,
                data : "",
                success: function (result) {
                    console.log(result);
                    var r = JSON.parse(result);
                    console.log(r);

                    if (r[0]["success"]) {
                        alert(r[0]["success"]);
                        location.reload();
                    } else {
                        alert(r[0]["error"]);
                    }

                },
                error: function (result) {
                    console.log(result);
                }
            });
        }
    });

    $(".restoreStd").click(function () {
        let i = $(this).attr("id");
        $.ajax({
            type : "POST",
            url  : "api/restoreStudent?user="+i,
            data : "",
            success: function (result) {
                console.log(result);
                var r = JSON.parse(result);
                console.log(r);

                if (r[0]["error"]) {
                    alert(r[0]["error"]);
                } else {
                    $("#"+i).hide();
                    $("#u"+i).show();
                }
            },
            error: function (result) {
                console.log(result);
            }
        });
    });

    $(".undo-restoreStd").click(function () {
        let user = $(this).attr("id").substr(1);
        $.ajax({
            type : "POST",
            url  : "api/deleteStudent?user="+user,
            data : "",
            success: function (result) {
                console.log(result);
                var r = JSON.parse(result);
                console.log(r);

                if (r[0]["success"]) {
                    $("#u"+user).hide();
                    $("#"+user).show();
                } else {
                    alert(r[0]["error"]);
                }
            },
            error: function (result) {
                console.log(result);
            }
        });
    });

    $("#saveOrUpdateStdBtn").click(function () {
            
        var i = $("#inputStdIndex").val();
        var f = $("#inputStdFname").val();
        var m = $("#inputStdMname").val();
        var l = $("#inputStdLname").val();
        var p = $("#inputStdProgram").val();
        
        if (i == "" || f == "" || l == "" || p == "") {
            alert("Some required fields are left out! Please them.");
        } else {

            if (editStdData) {
                var user = $("#user").val();
                $.ajax({
                    type : "POST",
                    url  : "api/editStudent?i="+i+"&f="+f+"&m="+m+"&l="+l+"&p="+p+"&u="+user,
                    data : "",
                    success: function (result) {
                        console.log(result);
                        var r = JSON.parse(result);
                        console.log(r);
                        if (r[0]["success"]) {
                            alert(r[0]["success"]);
                            $("#addOrEditStudent").modal("toggle")
                            location.reload();
                        } else {
                            alert(r[0]["error"]);
                        }  
                    },
                    error: function (result) {
                        console.log(result);
                    }
                });

            } else {
                $.ajax({
                    type : "POST",
                    url  : "api/addNewStudent?i="+i+"&f="+f+"&m="+m+"&l="+l+"&p="+p,
                    data : "",
                    success: function (result) {
                        console.log(result);
                        var r = JSON.parse(result);
                        console.log(r);
                        if (r[0]["success"]) {
                            alert(r[0]["success"]);
                            $("#addOrEditStudent").modal("toggle")
                            location.reload();
                        } else {
                            alert(r[0]["error"]);
                        }
                    },
                    error: function (result) {
                        console.log(result);
                    }
                });
            }
        }
    });

    $(".closeModal").click(function () {
        if ($(this).attr("id") == "set-later") {
            $.ajax({
                type : "POST",
                url  : "api/setsemlater",
                data : "",
                success: function (result) {
                    console.log(result);
                    var r = JSON.parse(result);
                    
                    if (r[0]["success"]) {
                    } else {
                        alert(r[0]["error"])
                    }
                },
                error: function (result) {
                    console.log(result);
                }
            });
            return;
        } else {
            location.reload();
        }
    });

    $('#file').change(function() {
        var i = $(this).prev('label').clone();
        var file = $('#file')[0].files[0].name;
        $(this).prev('label').text("Ready to upload " + file);
        $("#extractFile").show();
    });

    $("excel-form").on("submit", (function(e){
        e.preventDefault(); //prevent default form submition
        var FormData = $('#excel-form').serialize();
        $.post($(this).attr("action"), $(this).serialize());
        return false;
    }));

    $("#searchStdIndex").on("keyup", function () {
        if ($(this).val().length > 1) {
            var value = $(this).val().toLowerCase();
            $("#tableContent tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        }
    });

    //Settings Page

    $("#to-reset-password").click(function () {
        $("#reset-passoword").show();
        $("#sem-setup").hide();
        $("#variables").hide();
        $(this).attr("class", "nav-link active");
        $("#to-sem-setup").attr("class", "nav-link");
        $("#to-variables").attr("class", "nav-link");
    });

    $("#to-variables").click(function () {
        $("#variables").show();
        $("#reset-passoword").hide();
        $("#sem-setup").hide();
        $(this).attr("class", "nav-link active");
        $("#to-sem-setup").attr("class", "nav-link");
        $("#to-reset-password").attr("class", "nav-link");
    });

    $("#to-sem-setup").click(function () {
        $("#reset-passoword").hide();
        $("#variables").hide();
        $("#sem-setup").show();
        $(this).attr("class", "nav-link active");
        $("#to-reset-password").attr("class", "nav-link");
        $("#to-variables").attr("class", "nav-link");
    });

    $("#re-new-pw").on("blur", function () {
        if ($("#new-pw").length > 0) {
            if ($("#new-pw").val().length != $(this).val().length && $("#new-pw").val() != $(this).val()) {
                $("#passwordHelp").show();
            } else {
                $("#passwordHelp").hide();
                $("#reset-password-btn").attr("disabled", false);
            }
        }
    });

    $("#reset-password-btn").click(function () {
        if ($("#current-pw").val() != "") {
            $.ajax({
                type : "POST",
                url  : "api/restUserPass?u=1"+"&c="+$("#current-pw").val()+"&n="+$("#new-pw").val(),
                data : "",
                success: function (result) {
                    console.log(result);
                    var r = JSON.parse(result);
                    console.log(r);
                    alert(r[0]["success"]);
                },
                error: function (result) {
                    console.log(result);
                }
            });
        }
    });

    $("#reset-threshold-btn").click(function () {
        if ($("#thresh-amount").val() != "") {
            $.ajax({
                type : "POST",
                url  : "api/restUserPass?u=1"+"&c="+$("#current-pw").val()+"&n="+$("#new-pw").val(),
                data : "",
                success: function (result) {
                    console.log(result);
                    var r = JSON.parse(result);
                    console.log(r);
                    alert(r[0]["success"]);
                },
                error: function (result) {
                    console.log(result);
                }
            });
        }
    });

    function setUpSemesterSettings(a, se, st, e, t, ow) {
        $.ajax({
            type : "POST",
            url  : "api/setUpSemesterSettings?a="+a+"&se="+se+"&st="+st+"&e="+e+"&t="+t+"&ow="+ow,
            data : "",
            success: function (result) {
                console.log(result);
                var r = JSON.parse(result);
                console.log(r);

                if (r[0]["success"]) {
                    alert(r[0]["success"]);
                    $("#set-indicator").attr("class", "badge badge-success");
                } else if (r[0]["error"]) {
                    alert(r[0]["error"]);
                    $("#set-indicator").attr("class", "badge badge-danger");
                } else if (r[0]["continue"]) {
                    var msg = confirm("CAUTION! A semester is already set. Do you want to overwrite it? click OK to Overwrite.");
                    if (msg == true) {
                        setUpSemesterSettings(a, se, st, e, t, 2);
                    }
                }

            },
            error: function (result) {
                console.log(result);
            }
        });
    }

    $("#set-semester-btn").click(function () {
        var a = $("#aca").val();
        var se = $("#sem").val();
        var st = $("#start-date").val();
        var e = $("#end-date").val();
        var t = $("#thresh").val();

        if (a == "" || se == "" || st == "" || e == "" || t == "") {
            alert("All the fields are required!");
        } else {
            setUpSemesterSettings(a, se, st, e, t, 1);
        }
    });

    $("#save-acad").click(function () {
        var start = $("#set-start-year").val();
        var end = $("#set-end-year").val();

        if (start == "" || end == "") {
            alert("Inputs required!");
        } else {

            $.ajax({
                type : "POST",
                url  : "api/addAcadYr?s="+start+"&e="+end,
                data : "",
                success: function (result) {
                    console.log(result);
                    var r = JSON.parse(result);
                    console.log(r);

                    if (r[0]["success"]) {
                        alert(r[0]["success"])
                        location.reload();
                    } else if (r[0]["error"]) {
                        alert(r[0]["error"])
                    }

                },
                error: function (result) {
                    console.log(result);
                }
            });
        }
    });

    $("#save-program").click(function () {
        var program = $("#set-program-name").val();

        if (program == "") {
            alert("Inputs required!");
        } else {

            $.ajax({
                type : "POST",
                url  : "api/addProgram?p="+program,
                data : "",
                success: function (result) {
                    console.log(result);
                    var r = JSON.parse(result);
                    console.log(r);

                    if (r[0]["success"]) {
                        alert(r[0]["success"])
                    } else if (r[0]["error"]) {
                        alert(r[0]["error"])
                    }

                },
                error: function (result) {
                    console.log(result);
                }
            });
        }
    });

    var fetchedData = false;

    $("#queryReport").click(function () {
        var program = $("#repInputProgram").val();
        var acadYr = $("#repInputAcadYr").val();
        var semester = $("#repInputSemester").val();
        var bal_status = $("#repInputBalStatus").val();

        $.ajax({
            type : "POST",
            url  : "api/applyReportQuery?p="+program+"&a="+acadYr+"&s="+semester+"&b="+bal_status,
            data : "",
            success: function (result) {
                console.log(result);
                var r = JSON.parse(result);
                console.log(r);

                if (r[0]["error"]) {
                    alert(r[0]["error"]);
                    fetchedData = false;
                } else {
                    $("#data-title").show();
                    $("#data-table").show();
                    $("tbody").html("");
                    for (let i = 0; i < r.length; i++) {
                        var bal = '';
                        var mname = "";
                        if (r[i]["mname"] == "") {
                            mname = "";
                        }
                        fmt = 0 - (r[i]["bal"])
                        if (fmt > 0) {
                            bal = '('+ fmt + ')';
                        } else {
                            bal = fmt * -1;
                        }
                        d3.select("tbody")
                            .append("tr").html(
                            "<th scope='row'>"+(i+1)+"</th>" +
                            "<td id='index"+(i+1)+"'>"+r[i]["index"]+"</td>" +
                            "<td>"+r[i]["fullname"]+"</td>" +
                            "<td>"+bal+"</td>" +
                            "</tr>");
                    }
                    fetchedData = true;
                }

            },
            error: function (result) {
                console.log(result);
            }
        });
    });

    $("#print-pdf").click(function () {
        if (fetchedData == true) {
            var program = $("#repInputProgram").val();
            var acadYr = $("#repInputAcadYr").val();
            var semester = $("#repInputSemester").val();
            var bal_status = $("#repInputBalStatus").val();
            window.open("createPDF.php?p="+program+"&a="+acadYr+"&s="+semester+"&b="+bal_status, "_blank");
        }
    });

});
</script>





























