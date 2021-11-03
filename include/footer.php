<script type="text/javascript" src="js/jquery-2.2.3.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    //Creates a new cookie
    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
        var expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=index.php";
    }

    $("#loginForm").on("submit", function (e) {
        e.preventDefault();
        let email = $("#email").val();
        let password = $("#password").val();

        if (email == "" || email == undefined || password == "" || password == undefined) {
            alert("Email or password is required!");

        } else {
            $.ajax({
                type : "POST",
                url  : "u_login.php",
                data : new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                success: function (result) {
                    console.log(result);
                    if (result != 0) {
                        setCookie("login", true, 1);
                        if (result == 1) {
                            setCookie("admin", "admin", 1);
                            $(".output").html("<div class='alert alert-success'>"+
                                "<button class='close' data-dismiss='alert'><span>×</span></button>"+
                                "<strong>Login successfull!</strong></div>").fadeIn("slow", function () {
                                $(".output").fadeOut(3000);
                                window.location.href = "admin/";
                            });
                        } else if (result == 2) {
                            setCookie("student", result, 1);
                            $(".output").html("<div class='alert alert-success'>"+
                                "<button class='close' data-dismiss='alert'><span>×</span></button>"+
                                "<strong>Login successfull!</strong></div>").fadeIn("slow", function () {
                                $(".output").fadeOut(3000);
                                window.location.href = "students/";
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

});
</script>