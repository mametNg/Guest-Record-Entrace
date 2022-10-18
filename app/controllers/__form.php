<?php

/**
* 
*/
use Controller\Controller;


class form extends Controller
{
	
	function __construct()
	{
		$this->DB = $this->model('db_models');
		$this->config();
		$this->Menu = $this->helper("menu");
	}

	public function index($param=false)
	{	
		$data = [
			"header" => $this->Menu->header(),
			"zone" => $this->DB->query("
				SELECT 
				access.id AS id,
				CONCAT(access.name, ' - ', area.name) AS name
				FROM zone_access AS access
				INNER JOIN zone_area AS area
				ON area.id = access.zone
				ORDER BY area.name, access.name DESC
			"),
			"guest" => [
				"zone" => $this->DB->query("
					SELECT * FROM guest_zone_record WHERE id = '".$this->balitbangDecode($this->e($param))  ."'", true),
				"user" => $this->DB->query("
					SELECT * FROM guest_user_record WHERE gz_id = '". $this->balitbangDecode($this->e($param)) ."'"),
			],
			"relation" => $this->DB->allTB("relation"),
		];

		if (!isset($data['guest']['zone']) || empty($data['guest']['zone']) && !isset($data['guest']['user']) || empty($data['guest']['user'])) header("location: ".$this->base_url());
        if (!isset($data['guest']['zone']) || empty($data['guest']['zone']) && !isset($data['guest']['user']) || empty($data['guest']['user'])) exit();

        $this->otherRealtion = false;
        $this->otherArea = false;

		$this->view('templates/home/header', $data);
		$this->view('templates/home/topbar', $data);
		$this->view('home/load-form', $data);
		$this->view('templates/home/footer', $data);
	}
}