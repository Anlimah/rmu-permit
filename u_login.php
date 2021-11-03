<?php
    session_start();

    require_once ('classes/admin_handler.php');
    $admin = new AdminHandler();

    if (isset($_POST["email"]) || !empty($_POST["email"])) {
        if (isset($_POST["password"]) || !empty($_POST["password"])) {
            $result = $admin->checkUser($_POST["email"], $_POST["password"]);

            if ($result == 0) {
                print_r($result);
            } else {
                if ($result[0]["type"] == 1) {
                    $_SESSION["login"] = true;
                    $_SESSION["admin"] = "admin";
                } elseif ($result[0]["type"] == 2) {
                    $_SESSION["login"] = true;
                    $_SESSION["student"] = $result[0]["id"];
                }
                print_r($result[0]["type"]);
            }
        }
    }
?>