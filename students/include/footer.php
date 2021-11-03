<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
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

    });
</script>