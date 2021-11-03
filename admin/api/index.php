<?php
	require_once ('../../classes/admin_handler.php');
	require_once ('../../classes/general_handler.php');
	$admin = new AdminHandler();
	$gen = new GeneralHandler();

	//For all GET request to API
	if ($_SERVER['REQUEST_METHOD'] == "GET") {
		if ($_GET['url'] == "test") {
			print_r(json_encode($admin->getSettingsID()));
		}

		if ($_GET['url'] == "aca") {
			print_r(json_encode($admin->getAcademicYears()));
		}

		if ($_GET['url'] == "sem") {
			print_r(json_encode($admin->getSemesters()));
		}

		if ($_GET['url'] == "prog") {
			print_r(json_encode($admin->getPrograms()));
		}

		if ($_GET['url'] == "getDeletedStudents") {
			print_r(json_encode($admin->getDeletedStudents()));
		}

		if ($_GET['url'] == "semset") {
			print_r(json_encode($admin->getSettingsStatus()));
		}

		if ($_GET['url'] == "getSems") {
			print_r($admin->getSemesters());
		}
    }
    
	// For all POST requests to API
	elseif ($_SERVER['REQUEST_METHOD'] == "POST") {

		// 
		if ($_GET['url'] == "loginUser") {
			if (isset($_GET["email"]) && !empty($_GET["email"]) && isset($_GET["password"]) && !empty($_GET["password"])) {
				print_r(json_encode($admin->checkUser($_GET["email"], $_GET["password"])));
			}
		}

		if ($_GET['url'] == "getStudent") {
			if (isset($_GET["user"]) && !empty($_GET["user"])) {
				print_r(json_encode($admin->getStudentData($_GET["user"])));
			}
		}

		if ($_GET['url'] == "deleteStudent") {
			if (isset($_GET["user"]) && !empty($_GET["user"])) {
				print_r($admin->deleteStudentData($_GET["user"]));
			}
		}

		if ($_GET['url'] == "editStudent") {
			if (isset($_GET["i"]) && !empty($_GET["i"]) && isset($_GET["f"]) && !empty($_GET["f"])) {
				if (isset($_GET["m"]) && isset($_GET["l"]) && !empty($_GET["l"])) {
					if (isset($_GET["p"]) && !empty($_GET["p"]) && isset($_GET["u"]) && !empty($_GET["u"])) {
						print_r($admin->editStudentData($_GET["i"], $_GET["f"], $_GET["m"], $_GET["l"], $_GET["p"], $_GET["u"]));
					}
				}
			}
		}

		// for adding a new student
		if ($_GET['url'] == "addNewStudent") {
			if (isset($_GET["i"]) && !empty($_GET["i"]) && isset($_GET["f"]) && !empty($_GET["f"])) {
				if (isset($_GET["m"]) && isset($_GET["l"]) && !empty($_GET["l"])) {
					if (isset($_GET["p"]) && !empty($_GET["p"])) {
						print_r($admin->addNewStudentData($_GET["i"], $_GET["f"], $_GET["m"], $_GET["l"], $_GET["p"]));
					}
				}
			}
		}

		// For searching for a student
		if ($_GET['url'] == "searchStdIndex") {
			if (isset($_GET["key"]) && !empty($_GET["key"])) {
				print_r($admin->searchForStudent($_GET["key"]));
			}
		}

		//To display student statistics data
		if ($_GET['url'] == "statsData") {
			if (isset($_GET["status"]) && !empty($_GET["status"])) {
				print_r(json_encode($admin->getDataStats($_GET["status"])));
			}
		}

		// To reset password
		if ($_GET["url"] == "restUserPass") {
			if (isset($_GET["u"]) && !empty($_GET["u"])) {
				if (isset($_GET["c"]) && !empty($_GET["c"])) {
					if (isset($_GET["n"]) && !empty($_GET["n"])) {
						print_r($admin->resetUserPassw($_GET["u"], $_GET["c"], $_GET["n"]));
					}
				}
			}
		}

		// for setting semester later
		if ($_GET["url"] == "setsemlater") {
			print_r($admin->setLater());
		}

		// to setup a new semester
		if ($_GET["url"] == "setUpSemesterSettings") {
			if (isset($_GET["a"]) && !empty($_GET["a"])) {
				if (isset($_GET["se"]) && !empty($_GET["se"])) {
					if (isset($_GET["st"]) && !empty($_GET["st"])) {
						if (isset($_GET["e"]) && !empty($_GET["e"])) {
							if (isset($_GET["t"]) && !empty($_GET["t"])) {
								if (isset($_GET["ow"]) && !empty($_GET["ow"])) {
									print_r($admin->setupSemester($_GET["a"], $_GET["se"], $_GET["st"], $_GET["e"], $_GET["t"], $_GET["ow"], 1));
								} else {
									print_r('[{"error":"Invalid input [level - 6]!"}]');
								}
							} else {
								print_r('[{"error":"Invalid input [level - 5]!"}]');
							}
						} else {
							print_r('[{"error":"Invalid input [level - 4]!"}]');
						}
					} else {
						print_r('[{"error":"Invalid input [level - 3]!"}]');
					}
				} else {
					print_r('[{"error":"Invalid input [level - 2]!"}]');
				}
			} else {
				print_r('[{"error":"Invalid input [level - 1]!"}]');
			}
		}

		// to add an academic year
		if ($_GET['url'] == "addAcadYr") {
			if (isset($_GET["s"]) && !empty($_GET["s"])) {
				if (isset($_GET["e"]) && !empty($_GET["e"])) {
					print_r($admin->addAcademicYear($_GET["s"], $_GET["e"]));
				}
			}
		}

		// to add a new program
		if ($_GET['url'] == "addProgram") {
			if (isset($_GET["p"]) && !empty($_GET["p"])) {
				print_r($admin->addAProgram($_GET["p"]));
			}
		}

		// to get report query depending on the program, academic year, semester and balance
		if ($_GET['url'] == "applyReportQuery") {
			if (isset($_GET["p"])) {
				if (isset($_GET["a"]) && !empty($_GET["a"])) {
					if (isset($_GET["s"]) && !empty($_GET["s"])) {
						if (isset($_GET["b"]) && !empty($_GET["b"])) {
							$result = $admin->getReportData($_GET["p"], $_GET["a"], $_GET["s"], $_GET["b"]);
							if ($result != 0) {
								print_r(json_encode($result));
							} else {
								print_r('[{"error":"No match found for query criteria"}]');
							}
						} else {
							print_r('[{"error":"Invalid input [level - 4]!"}]');
						}
					} else {
						print_r('[{"error":"Invalid input [level - 3]!"}]');
					}
				} else {
					print_r('[{"error":"Invalid input [level - 2]!"}]');
				}
			} else {
				print_r('[{"error":"Invalid input [level - 1]!"}]');
			}
		}

		// to restore a deleted student data
		if ($_GET['url'] == "restoreStudent") {
			if (isset($_GET["user"]) && !empty($_GET["user"])) {
				print_r($admin->restoreStudentData($_GET["user"]));
			}
		}

		// to get student details
		if ($_GET['url'] == "getStudentByDetails") {
			if (isset($_GET["y"]) && !empty($_GET["y"])) {
				if (isset($_GET["s"]) && !empty($_GET["s"])) {
					if (isset($_GET["p"])) {
						print_r(json_encode($admin->getStudentBySettings($_GET["y"], $_GET["s"], $_GET["p"])));
					}
				}
			}
		}

	} else {
		http_response_code(405);
	}
?>