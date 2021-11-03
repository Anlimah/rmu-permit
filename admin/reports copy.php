<?php
    session_start();
    if (!isset($_SESSION["login"]) && !isset($_SESSION["admin"])) {
        header("Location: ../");
    } elseif (isset($_GET["action"]) && $_GET["action"] == "logout") {
        unset($_SESSION["login"]);
        unset($_SESSION["admin"]);
        header("Location:../");
    }
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
    </style>
</head>
<body>
    <!--Navigation bar-->
    <?php require_once("include/navbar.php"); ?>
    
    <!--Main content Area-->
    <div class="container" id="main">
        <div class="alert alert-primary" role="alert" style="height:60px;">
            <span style="float: right;">
                <ul class="list-inline">
                    <li class="list-inline-item" style="font: 18px bold">Export: </li>
                    <li class="list-inline-item">
                        <form action="createPDF.php" method="post">
                            <label for="print-excel">
                                <img src="images/icons8-microsoft-excel-2019-48.png" style="width: 40px; height: 30px; cursor:pointer" alt="Export to Excel"/>
                            </label>
                            <input type="submit" id="print-excel" name="print-excel" style="display:none">
                        </form>
                    </li>
                    <li class="list-inline-item" style="font: 18px bold">|</li>
                    <li class="list-inline-item">
                        <form action="createPDF.php" method="post">
                            <label for="print-pdf">
                                <img src="images/icons8-pdf-48.png" style="width: 40px; height: 30px; cursor:pointer" alt="Export to PDF"/>
                            </label>
                            <input type="submit" id="print-pdf" name="print-pdf" style="display:none">
                        </form>
                    </li>
                </ul>
            </span>
        </div>

        <div class="row">
            <div class="col-md-5">
                <div id="dataDisplay">
                    <h6 class="title center"></h6>
                    <svg width="300" height="300"></svg>
                </div>
                <div style="margin-left: 1%">
                    <button type="button" class="btn btn-success btn-sm stats-data" id="Students"></button>
                    <button type="button" class="btn btn-primary btn-sm stats-data" id="Eligible"></button>
                    <button type="button" class="btn btn-warning btn-sm stats-data" id="Owing"></button>
                </div>
            </div>
            <div class="col-md-7">
                <div id="data-content" style="width:100%;height:400px">
                    <table class="table table-striped" id="data-table" style="display:none">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">SNo.</th>
                                <th scope="col">INDEX NUMBER</th>
                                <th scope="col">NAME</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <div class="flex-container" id="info1" style="display: none;">
        <div class="alert alert-info">No students data available!</div>
    </div>


    <?php require_once("include/footer.php"); ?>

    <script>

        $.ajax({
            type : "GET",
            url  : "api/reportD",
            data : "",
            success: function (result) {
                console.log(result);
                if (result == 0) {
                    $("#main").hide();
                    $("#info1").show();
                    return;
                } 
                var details = JSON.parse(result);
                var total_students = function () {
                    var tot = 0
                    for (let i = 0; i < details.length; i++) {
                        tot += parseInt(details[i]["total"]);                        
                    }
                    return tot;
                }

                var svg = d3.select("svg"),
                    width = svg.attr("width"),
                    height = svg.attr("height"),
                    radius = Math.min(width, height) / 2;

                var color = d3.scaleOrdinal(['#007bff','#ffc107','#20c997','#17a2b8']);

                // Generate the pie
                var data = d3.pie().sort(null).value(function (d) {
                    return d.total;
                })(details);

                // Generate the arcs
                var arc = d3.arc()
                            .innerRadius(50)
                            .outerRadius(radius);
 
                var g = svg.append("g")
                            .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")")
                            .selectAll("path").data(data)
                g.enter().append("path").attr("d", arc).attr("fill", function (d, i) {
                    return color(i);
                });

                var content = d3.select("g")
                                .selectAll("text")
                                .data(data)
                content.enter()
                        .append("text")
                        .each(function (d) {
                            var center = arc.centroid(d);
                            d3.select(this).attr("x", center[0])
                                            .attr("y", center[1])
                                            .attr("class", "segments")
                                            .text(((d.data.total / total_students()) * 100).toFixed(2) + "%")
                        });

                d3.select(".title").text("Students Eligibility Statistics - Semester 2, 2021")

                d3.select("#Students")
                    .html('Total Students <span class="badge badge-light">'+total_students()+'</span>')
                            
                d3.select("#Eligible")
                    .html(details[0].status + 
                            ' <span class="badge badge-light">'+details[0].total+'</span>')

                d3.select("#Owing")
                    .html(details[1].status + 
                            ' <span class="badge badge-light">'+details[1].total+'</span>')

            },
            error: function (result) {
                console.log(result);
            }
        });

        $(".stats-data").click(function () {
            $.ajax({
                type : "POST",
                url  : "api/statsData?status="+$(this).attr("id"),
                data : "",
                success: function (result) {
                    console.log(result);
                    var data = JSON.parse(result);
                    console.log(data);

                    if (data == 0) {
                        $("table").hide();
                        d3.select("#data-table").html("<div class='alert alert-info'>No content to display!</div>")
                    } else {
                        $("#print-btn").show();
                        $("table").show(); 
                        $("tbody").html("");
                        for (let i = 0; i < data.length; i++) {
                            var mname = "";
                            if (data[i]["mname"] == "") {
                                mname = "";
                            }
                            d3.select("tbody").append("tr").html(
                                "<th scope='row'>"+(i+1)+"</th>" +
                                "<td>"+data[i]["index"]+"</td>" +
                                "<td>"+data[i]["fname"] + " " + mname + " " + data[i]["lname"]+"</td>" +
                                "</tr>");
                        }
                        
                    }
                    
                },
                error: function (result) {
                    console.log(result);
                }
            });
        });

        const options = {
            body: "Hello BCS21",
            icon: "",
            vibrate: [200, 100, 200],
            tag: "OK",
            image: "",

        }

        navigator.serviceWorker.ready.then(function (serviceWorker) {
            serviceWorker.showNotification("Hello");
        })

    </script>
</body>
</html>