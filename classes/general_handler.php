<?php
	class GeneralHandler {

		private $db;
		
		function __construct()
		{
			require_once ('db.php');
			$this->db= new DbConnect();
		}

		//Get raw data from db
		public function getID($str, $params = array())
		{
			try {
				$result = $this->db->query($str, $params);
				if (!empty($result)) {
					return $result[0]["id"];
				} else {
					return 0;
				}
			} catch (Exception $e) {
				echo $e->getMessage();
			}
		}

		//Get raw data from db
		public function getData($str, $params = array())
		{
			try {
				$result = $this->db->query($str, $params);
				if (!empty($result)) {
					return $result;
				} else {
					return 0;
				}
			} catch (Exception $e) {
				echo $e->getMessage();
			}
		}
		//Get raw data from db
		public function getTotalData($str, $params = array())
		{
			try {
				return $this->db->getTotalData($str, $params);
			} catch (Exception $e) {
				echo $e->getMessage();
			}
		}

		//Insert, Upadate or Delete Data
		public function inputData($str, $params = array())
		{
			try {
	    		$result = $this->db->query($str, $params);
				if (!empty($result)) {
					return $result;
				} else {
					return 0;
				}
			} catch (Exception $e) {
				echo $e->getMessage();
			}
		}

	}
?>
































