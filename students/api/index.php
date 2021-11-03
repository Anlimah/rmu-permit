<?php
require_once('../../classes/student_handler.php');
$student = new StudentHandler();

//For all GET request from a page
if ($_SERVER['REQUEST_METHOD'] == "GET") {
	if ($_GET['url'] == "test") {
		if (isset($_GET["user"]) && !empty($_GET["user"])) {
			print_r(json_encode($student->getStudentData($_GET["user"])));
		}
	}
}

// For all POST requests
elseif ($_SERVER['REQUEST_METHOD'] == "POST") {
	if ($_GET['url'] == "loginUser") {
		if (isset($_GET["email"]) && !empty($_GET["email"]) && isset($_GET["password"]) && !empty($_GET["password"])) {
			//print_r($student->checkUser($_GET["email"], $_GET["password"]));
		}
	}
} else {
	http_response_code(405);
}
