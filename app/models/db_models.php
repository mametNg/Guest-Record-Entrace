<?php
/**
* 
*/
class db_models
{
	private $table = "db_users";
	private $db;

	public function __construct()
	{
		$this->db = new Database;
	}

	public function query($value=false, $method=false)
	{
		$this->db->query($value);
		if (!$method) return $this->db->resultSet(); 
		return $this->db->single(); 
	}

	public function allTB($value=false)
	{
		$this->db->query("SELECT * FROM $value");
		return $this->db->resultSet();
	}

	public function selectTB($tb=false,$key=false,$value=false, $method=false)
	{
		$this->db->query("SELECT * FROM ".$tb." WHERE ".$key."='".$value."'");
		if (!$method) return $this->db->resultSet();
		return $this->db->single();
	}

	public function updateTB($tb=false,$params=false,$key=false,$value=false)
	{

		$query = '';

		foreach ($params as $set => $resultSet) {
			$query .= $set."='".$resultSet."', ";
		}

		$query = rtrim($query,", ");

		$this->db->query("UPDATE ".$tb." SET ".$query." WHERE ".$key."='".$value."'");
		return $this->db->execute();

	}

	public function insertTB($tb=false,$params=false, $multiple=false)
	{	
		if (!$multiple) {
			$set = '';
			$value = '';
			foreach ($params as $key => $resultSet) {
				$set .= $key.", ";
				$value .= "'".$resultSet."', ";
			}

			$set = rtrim($set,", ");
			$value = "(".rtrim($value,", ").")";
		}

		if ($multiple == true) {
			$set = '';
			$value = '';
			$subValue = '';

			foreach ($params[0] as $key => $values) $set .= $key.", ";

			foreach ($params as $keys => $subResult) {
				foreach ($subResult as $key => $resultSet) {
					$subValue .= "'".$resultSet."', ";
				}
				$value .= "(". rtrim($subValue, ", ") ."), ";
				$subValue = '';
			}

			$set = rtrim($set,", ");
			$value = rtrim($value,", ");
		}
		$query = "INSERT INTO $tb ($set) VALUES $value";

		$this->db->query($query);
		return $this->db->execute();
	}
	
	public function deltTB($tb=false,$key=false,$value=false)
	{
		$this->db->query("DELETE FROM $tb where $key='$value'");
		return $this->db->execute();
	}

	public function resetTB($value=false)
	{
		$this->db->query("TRUNCATE TABLE $value");
		return $this->db->execute();
	}

	public function dropTB($value=false)
	{
		$this->db->query("DROP TABLE $value");
		return $this->db->execute();
	}

	public function renameTB($tb1=false, $tb2=false)
	{
		if (!$this->getAllTB($tb1) && $this->getAllTB($tb2)) return false;
		$this->db->query("ALTER TABLE $tb1 RENAME TO $tb2");
		return $this->db->execute();
	}

	public function createTB($tb='')
	{
		// $this->db->query("DROP TABLE $value");
		// return $this->db->execute();
	}

}