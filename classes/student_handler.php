<?php
	class StudentHandler {
		private $gh;
		
		public function __construct()
		{
			require_once ('general_handler.php');
			$this->gh = new GeneralHandler();
		}

		private function getSettingsID()
		{
			return $this->gh->getID("SELECT `id` FROM `settings` WHERE `using` = 1 AND `due_days` > 0");
		}

		public function getThreshold()
		{
			$sql = "SELECT `threshold` FROM `settings` 
					WHERE `using` = 1 AND `due_days` > 0";
			return $this->gh->getData($sql);
		}

		//get one student data(uses student db id)
		public function getStudentData($user)
		{
			$sql = "SELECT s.`index`, s.`fullname`, f.`bal`, f.`paid` 
					FROM `students` AS s, `finance` AS f 
					WHERE s.`id` = f.`sid` AND s.`id` = :u 
					AND s.`type` = 2";
			$params = array(':u' => $user);
			return $this->gh->getData($sql, $params);
		}

		public function getStudentDataPermit($user)
		{
			$sql = "SELECT s.`index`, s.`fullname`, p.`program`, 
					p.`program`, f.`bal`, f.`paid` , c.`permit`, c.`qr_code` 
					FROM `students` AS s, `finance` AS f, program AS p, 
					secret_codes AS c, settings AS t 
					WHERE s.`id` = f.`sid` AND s.`type` = 2 
					AND p.`id` = s.`pid` AND c.`sid` = s.`id` 
					AND t.`id` = c.`set` AND t.`id` = :t 
					AND s.`id` = :u";
			$params = array(':u' => $user, ':t' => $this->getSettingsID());
			return $this->gh->getData($sql, $params);
		}
		
		public function getSemAndAca()
		{
			$sql = "SELECT s.`semester`, a.`academic_year` 
					FROM `semester` AS s, `academic_year` AS a, `settings` AS t 
					WHERE t.`acaid` = a.`id` AND t.`semid` = s.`id` 
					AND t.`using` = 1 AND t.`due_days` > 0";
			return $this->gh->getData($sql);
		}


	}
?>
































