<!--Navigation bar-->
<div class="container">
    <nav class="navbar navbar-expand-lg sticky-top navbar-light bg-light">
        <a href="index.php" class="navbar-brand">
            <img src="../images/rmu logo.jpg" alt="RMU Logo" width="50" height="50">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li id="home" class="nav-item link" data-toggle="tooltip" data-placement="top" title="Home">
                    <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li id="uploads" class="nav-item link" data-toggle="tooltip" data-placement="top" title="Uploads">
                    <a class="nav-link" href="finances.php">Finances</a>
                </li>
                <li id="settings" class="nav-item link" data-toggle="tooltip" data-placement="top" title="Settings">
                    <a class="nav-link" href="profile.php">Profile</a>
                </li>
            </ul>
            <span style="width:70%"></span>
            <a class="btn btn-sm btn-danger" id="tester" name="tester" href="#">Tester</a>
            <a class="btn btn-sm btn-outline-primary" id="logout" name="logout" href="?action=logout">Logout</a>
        
        </div>
    </nav>
</div>