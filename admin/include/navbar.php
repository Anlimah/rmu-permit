<!--Navigation bar-->
<div class="container">
    <nav class="navbar navbar-expand-lg sticky-top navbar-light bg-light">
        <a href="index.php" class="navbar-brand">
            <img src="images/rmu logo.jpg" alt="RMU Logo" width="50" height="50">
        </a>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li id="home" class="nav-item link" data-toggle="tooltip" data-placement="top" title="Home">
                    <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li id="students" class="nav-item link" data-toggle="tooltip" data-placement="top" title="Students">
                    <a class="nav-link" href="students.php">Students</a>
                </li>
                <li id="reports" class="nav-item link" data-toggle="tooltip" data-placement="top" title="Reports">
                    <a class="nav-link" href="reports.php">Reports</a>
                </li>
                <li id="uploads" class="nav-item link" data-toggle="tooltip" data-placement="top" title="Uploads">
                    <a class="nav-link" href="file-upload.php">Uploads</a>
                </li>
                <li id="settings" class="nav-item link" data-toggle="tooltip" data-placement="top" title="Settings">
                    <a class="nav-link" href="settings.php">Settings</a>
                </li>
            </ul>
        </div>
        <span style="width:50%"></span>
        <span class="badge badge-danger" id="set-indicator" style="width:10px; height:10px; margin-right:10px; border-radius: 20px"> </span>
        <!--<a class="btn btn-sm btn-danger" id="tester" name="tester" href="#">Tester</a>-->
        <a class="btn btn-sm btn-outline-primary" id="logout" name="logout" href="?action=logout">Logout</a>
    </nav>
</div>