<?php

/**
* 
*/
use Controller\Controller;

class menu extends Controller
{
	
	function __construct()
	{	
		$this->config();
		$this->DB = (in_array("db_models", get_declared_classes()) ? new db_models():$this->model("db_models"));
	}

	public function header()
	{
		$header = $this->DB->selectTB("header", "id", "VHJAV", true);
		$result = [
			"title"	=> $header['title'],
			"img"		=> $this->base_url("/assets/img/brand/".$header['img']),
			"brand"			=> $header['brand'],
			"desc"			=> $header['description'],
		];

		return $result;
	}

	public function maintenance()
	{
		$data = [
			"header"	=> $this->header(),
		];

		$data['header']['title'] = "Maintenance";
		$data['header']['desc'] = "Website is under maintenance. Try again later.";

		$this->view("templates/login/home/header", $data);
		$this->view("addons/maintenance", $data);
		$this->view("templates/login/home/footer", $data);
		exit();
	}
}