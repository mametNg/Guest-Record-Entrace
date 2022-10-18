<?php

/**
* 
*/
use Controller\Controller;


class dashboard extends Controller
{
	
	function __construct()
	{
		$this->DB = $this->model('db_models');
		$this->config();
		$this->Menu = $this->helper("menu");
		$this->header = $this->DB->selectTB("header", "id", "VHJAV", true);
	}

	public function index()
	{
		if (!isset($_SESSION['email']) || empty($_SESSION['email'])) header("location: ".$this->base_url('/dashboard/login'));
        if (!isset($_SESSION['email']) || empty($_SESSION['email'])) exit();

        $data = [
            "header" => [
                "title" => "Dashboard",
                "desc" => "Dashboard Home",
                "img" => $this->base_url("/assets/img/brand/".$this->e($this->header['img'])),
            ],
            "users" => [
                "profile" => $this->DB->selectTB("db_users", "email", $this->e($_SESSION['email']), true),
            ],
        ];

        $this->view("templates/dashboard/header", $data);
        $this->view("templates/dashboard/sidebar", $data);
        $this->view("templates/dashboard/topbar", $data);
        $this->view("dashboard/body", $data);
        $this->view("templates/dashboard/footer", $data);
	}

	public function profile()
    {
        if (!isset($_SESSION['email']) || empty($_SESSION['email'])) header("location: ".$this->base_url('/dashboard/login'));
        if (!isset($_SESSION['email']) || empty($_SESSION['email'])) exit();

        $data = [
            "header" => [
                "title" => "Dashboard - profile",
                "desc" => "Dashboard Profile",
                "img" => $this->base_url("/assets/img/brand/".$this->e($this->header['img'])),
            ],
            "users" => [
                "profile" => $this->DB->selectTB("db_users", "email", $this->e($_SESSION['email']), true),
            ],
        ];

        $this->view("templates/dashboard/header", $data);
        $this->view("templates/dashboard/sidebar", $data);
        $this->view("templates/dashboard/topbar", $data);
        $this->view("dashboard/profile", $data);
        $this->view("templates/dashboard/footer", $data);
    }

    public function users_management()
    {
        if (!isset($_SESSION['email']) || empty($_SESSION['email'])) header("location: ".$this->base_url('/dashboard/login'));
        if (!isset($_SESSION['email']) || empty($_SESSION['email'])) exit();

        $data = [
            "header" => [
                "title" => "Dashboard - Users Management",
                "desc" => "Dashboard Users Management",
                "img" => $this->base_url("/assets/img/brand/".$this->e($this->header['img'])),
            ],
            "users" => [
                "profile" => $this->DB->selectTB("db_users", "email", $this->e($_SESSION['email']), true),
                "all" => $this->DB->query("
                    SELECT
                    *
                    FROM db_users WHERE NOT email='". $this->e($_SESSION['email']) ."'
                "),
            ],
        ];

        $this->view("templates/dashboard/header", $data);
        $this->view("templates/dashboard/sidebar", $data);
        $this->view("templates/dashboard/topbar", $data);
        $this->view("dashboard/user-management", $data);
        $this->view("templates/dashboard/footer", $data);
    }

    public function web_settings()
    {
        if (!isset($_SESSION['email']) || empty($_SESSION['email'])) header("location: ".$this->base_url('/dashboard/login'));
        if (!isset($_SESSION['email']) || empty($_SESSION['email'])) exit();

        $data = [
            "header" => [
                "title" => "Dashboard - Web Settings",
                "desc" => "Dashboard Web Settings",
                "img" => $this->base_url("/assets/img/brand/".$this->e($this->header['img'])),
            ],
            "sub-header" => $this->header,
            "users" => [
                "profile" => $this->DB->selectTB("db_users", "email", $this->e($_SESSION['email']), true),
            ],
        ];

        $this->view("templates/dashboard/header", $data);
        $this->view("templates/dashboard/sidebar", $data);
        $this->view("templates/dashboard/topbar", $data);
        $this->view("dashboard/web-settings", $data);
        $this->view("templates/dashboard/footer", $data);
    }

    public function add_guest()
    {
    	if (!isset($_SESSION['email']) || empty($_SESSION['email'])) header("location: ".$this->base_url('/dashboard/login'));
        if (!isset($_SESSION['email']) || empty($_SESSION['email'])) exit();

        $data = [
            "header" => [
                "title" => "Guest Record - Summary",
                "desc" => "Guest Record Summary",
                "img" => $this->base_url("/assets/img/brand/".$this->e($this->header['img'])),
            ],
            "users" => [
                "profile" => $this->DB->selectTB("db_users", "email", $this->e($_SESSION['email']), true),
            ],
            "zone" => $this->DB->query("
                SELECT 
                access.id AS id,
                CONCAT(access.name, ' - ', area.name) AS name
                FROM zone_access AS access
                INNER JOIN zone_area AS area
                ON area.id = access.zone
                ORDER BY area.name, access.name DESC
            "),
            "relation" => $this->DB->allTB("relation"),
        ];

        

    	$this->view("templates/dashboard/header", $data);
        $this->view("templates/dashboard/sidebar", $data);
        $this->view("templates/dashboard/topbar", $data);
        $this->view("dashboard/open-form", $data);
        $this->view("templates/dashboard/footer", $data);
    }

    public function form($param=false)
    {
        if (!isset($_SESSION['email']) || empty($_SESSION['email'])) header("location: ".$this->base_url('/dashboard/login'));
        if (!isset($_SESSION['email']) || empty($_SESSION['email'])) exit();

        $data = [
            "header" => [
                "title" => "Guest Record - Summary",
                "desc" => "Guest Record Summary",
                "img" => $this->base_url("/assets/img/brand/".$this->e($this->header['img'])),
            ],
            "users" => [
                "profile" => $this->DB->selectTB("db_users", "email", $this->e($_SESSION['email']), true),
            ],
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
                    SELECT 
                    zone.id AS id,
                    zone.company AS company,
                    zone.relation AS relation,
                    zone.other_relation AS other_relation,
                    zone.bussines AS bussines,
                    zone.area AS area,
                    zone.other_area AS other_area,
                    zone.total_guest AS total_guest,
                    zone.date_in AS date_in,
                    zone.date_out AS date_out,
                    zone.date_created AS date_created,
                    zone.pic_name AS pic_name,
                    zone.pic_dept AS pic_dept,
                    zone.pic_agree AS pic_agree,
                    zone.pic_note AS pic_note,
                    userin.name AS in_by,
                    zone.out_by AS out_by
                    FROM guest_zone_record AS zone
                    INNER JOIN db_users AS userin
                    ON userin.id = zone.in_by OR userin.id = zone.out_by
                    WHERE zone.id = '".$this->balitbangDecode($this->e($param))  ."'
                    ", true),
                "user" => $this->DB->query("
                    SELECT * FROM guest_user_record WHERE gz_id = '". $this->balitbangDecode($this->e($param)) ."'"),
            ],
            "relation" => $this->DB->allTB("relation"),
        ];

        // $this->printJson($data['guest']['zone']);

        if (!isset($data['guest']['zone']) || empty($data['guest']['zone']) && !isset($data['guest']['user']) || empty($data['guest']['user'])) header("location: ".$this->base_url());
        if (!isset($data['guest']['zone']) || empty($data['guest']['zone']) && !isset($data['guest']['user']) || empty($data['guest']['user'])) exit();

        $loadusers = $this->DB->selectTB("db_users", "id", $this->e($data['guest']['zone']['out_by']), true);

        $data['guest']['zone']['out_by'] = ($loadusers ? $loadusers['name'] : "");

        $this->otherRealtion = false;
        $this->otherArea = false;

        $this->view("templates/dashboard/header", $data);
        $this->view("templates/dashboard/sidebar", $data);
        $this->view("templates/dashboard/topbar", $data);
        $this->view("dashboard/load-form", $data);
        $this->view("templates/dashboard/footer", $data);
    }

    public function summary()
	{
		if (!isset($_SESSION['email']) || empty($_SESSION['email'])) header("location: ".$this->base_url('/dashboard/login'));
        if (!isset($_SESSION['email']) || empty($_SESSION['email'])) exit();

        $data = [
            "header" => [
                "title" => "Guest Record - Summary",
                "desc" => "Guest Record Summary",
                "img" => $this->base_url("/assets/img/brand/".$this->e($this->header['img'])),
            ],
            "users" => [
                "profile" => $this->DB->selectTB("db_users", "email", $this->e($_SESSION['email']), true),
            ],
            "guest" => $this->DB->query("
            	SELECT
            	zone.id AS id,
            	zone.company AS company,
                IF(zone.relation = 'OTHER', zone.other_relation, relation.name) AS relation,
            	zone.pic_name AS pic_name,
            	user.name AS name,
            	user.id AS guid,
            	zone.bussines AS bussines,
                IF(zone.area = 'OTHER', zone.other_area, access.name) AS area,
            	user.card_numb AS card_numb,
            	user.temp AS temp,
            	user.vaksin AS vaksin,
            	zone.date_created AS date,
            	zone.date_in AS date_in,
            	zone.date_out AS date_out
            	FROM guest_zone_record AS zone
            	INNER JOIN guest_user_record AS user
            	ON zone.id = user.gz_id
            	INNER JOIN zone_access AS access
            	ON access.id = zone.area
            	INNER JOIN relation AS relation
            	ON relation.id = zone.relation
                ORDER BY zone.id DESC
                LIMIT 1000
            "),
            "gz" => [],
        ];

        foreach ($data['guest'] as $guest) {
            $data['gz'][$guest['id']]['id'] = $guest['id'];
            $data['gz'][$guest['id']]['company'] = $guest['company'];
            $data['gz'][$guest['id']]['relation'] = $guest['relation'];
            $data['gz'][$guest['id']]['pic_name'] = $guest['pic_name'];
            $data['gz'][$guest['id']]['name'] = $guest['name'];
            $data['gz'][$guest['id']]['guid'] = $guest['guid'];
            $data['gz'][$guest['id']]['bussines'] = $guest['bussines'];
            $data['gz'][$guest['id']]['area'] = $guest['area'];
            $data['gz'][$guest['id']]['card_numb'] = $guest['card_numb'];
            $data['gz'][$guest['id']]['temp'] = $guest['temp'];
            $data['gz'][$guest['id']]['vaksin'] = $guest['vaksin'];
            $data['gz'][$guest['id']]['date'] = $guest['date'];
            $data['gz'][$guest['id']]['date_in'] = $guest['date_in'];
            $data['gz'][$guest['id']]['date_out'] = $guest['date_out'];
        }

        $this->view("templates/dashboard/header", $data);
        $this->view("templates/dashboard/sidebar", $data);
        $this->view("templates/dashboard/topbar", $data);
        $this->view("dashboard/summary", $data);
        $this->view("templates/dashboard/footer", $data);
	}

    public function report_summary()
    {
        if (!isset($_SESSION['email']) || empty($_SESSION['email'])) header("location: ".$this->base_url('/dashboard/login'));
        if (!isset($_SESSION['email']) || empty($_SESSION['email'])) exit();

        $data = [
            "header" => [
                "title" => "Guest Record - Summary",
                "desc" => "Guest Record Summary",
                "img" => $this->base_url("/assets/img/brand/".$this->e($this->header['img'])),
            ],
            "users" => [
                "profile" => $this->DB->selectTB("db_users", "email", $this->e($_SESSION['email']), true),
            ],
            "guest" => $this->DB->query("
                SELECT
                zone.company AS company,
                CONCAT(IF(zone.area = 'OTHER', zone.other_area, access.name), '-', area.name) AS area,
                COUNT(user.id) AS guest_total,
                zone.date_out AS date_out,
                zone.date_created AS date_created
                FROM guest_zone_record AS zone
                INNER JOIN guest_user_record AS user
                ON user.gz_id = zone.id
                INNER JOIN zone_access AS access
                ON access.id = zone.area
                INNER JOIN zone_area AS area
                ON area.id = access.zone
                WHERE DATE_FORMAT(CAST(FROM_UNIXTIME(zone.date_created) AS DATE), '%Y') = '". date("Y") ."'
                GROUP BY zone.company
                ORDER BY date_created DESC
            "),
            "report" => $this->DB->query("
                SELECT
                COUNT(date_created) AS total,
                date_created AS date
                FROM guest_zone_record
                GROUP BY DATE_FORMAT(CAST(FROM_UNIXTIME(date_created) AS DATE), '%m-%Y')
                ORDER BY date_created ASC
            "),
            "chart-year" => $this->DB->query("
                SELECT
                date_created AS date
                FROM guest_zone_record
                GROUP BY DATE_FORMAT(CAST(FROM_UNIXTIME(date_created) AS DATE), '%Y')
                ORDER BY date_created DESC
            "),
            "chart-diagram" => $this->DB->query("
                SELECT
                COUNT(date_created) AS total,
                date_created AS date
                FROM guest_zone_record
                WHERE DATE_FORMAT(CAST(FROM_UNIXTIME(date_created) AS DATE), '%Y') = '". date("Y") ."'
                GROUP BY DATE_FORMAT(CAST(FROM_UNIXTIME(date_created) AS DATE), '%m-%Y')
                ORDER BY date_created ASC
            "),
        ];

        // $this->printJson($data['guest']);

        $this->view("templates/dashboard/header", $data);
        $this->view("templates/dashboard/sidebar", $data);
        $this->view("templates/dashboard/topbar", $data);
        $this->view("dashboard/report-summary", $data);
        $this->view("templates/dashboard/footer", $data);
    }


    public function form_summary($param=false)
    {
        if (!isset($_SESSION['email']) || empty($_SESSION['email'])) header("location: ".$this->base_url('/dashboard/login'));
        if (!isset($_SESSION['email']) || empty($_SESSION['email'])) exit();

        $data = [
            "header" => [
                "title" => "Guest Record - Summary",
                "desc" => "Guest Record Summary",
                "img" => $this->base_url("/assets/img/brand/".$this->e($this->header['img'])),
            ],
            "users" => [
                "profile" => $this->DB->selectTB("db_users", "email", $this->e($_SESSION['email']), true),
            ],
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
                    SELECT 
                    zone.id AS id,
                    zone.company AS company,
                    zone.relation AS relation,
                    zone.other_relation AS other_relation,
                    zone.bussines AS bussines,
                    zone.area AS area,
                    zone.other_area AS other_area,
                    zone.total_guest AS total_guest,
                    zone.date_in AS date_in,
                    zone.date_out AS date_out,
                    zone.date_created AS date_created,
                    zone.pic_name AS pic_name,
                    zone.pic_dept AS pic_dept,
                    userin.name AS in_by,
                    zone.out_by AS out_by
                    FROM guest_zone_record AS zone
                    INNER JOIN db_users AS userin
                    ON userin.id = zone.in_by OR userin.id = zone.out_by
                    WHERE zone.id = '".$this->balitbangDecode($this->e($param))  ."'
                    ", true),
                "user" => $this->DB->query("
                    SELECT * FROM guest_user_record WHERE gz_id = '". $this->balitbangDecode($this->e($param)) ."'"),
            ],
            "relation" => $this->DB->allTB("relation"),
        ];

        // $this->printJson($data['guest']['zone']);

        if (!isset($data['guest']['zone']) || empty($data['guest']['zone']) && !isset($data['guest']['user']) || empty($data['guest']['user'])) header("location: ".$this->base_url());
        if (!isset($data['guest']['zone']) || empty($data['guest']['zone']) && !isset($data['guest']['user']) || empty($data['guest']['user'])) exit();

        $loadusers = $this->DB->selectTB("db_users", "id", $this->e($data['guest']['zone']['out_by']), true);

        $data['guest']['zone']['out_by'] = ($loadusers ? $loadusers['name'] : "");

        $this->otherRealtion = false;
        $this->otherArea = false;

        $this->view("templates/dashboard/header", $data);
        $this->view("templates/dashboard/sidebar", $data);
        $this->view("templates/dashboard/topbar", $data);
        $this->view("dashboard/form-summary", $data);
        $this->view("templates/dashboard/footer", $data);
    }

    public function history_login()
    {
        if (!isset($_SESSION['email']) || empty($_SESSION['email'])) header("location: ".$this->base_url('/dashboard/login'));
        if (!isset($_SESSION['email']) || empty($_SESSION['email'])) exit();

        $data = [
            "header" => [
                "title" => "History - History login",
                "desc" => "History Login",
                "img" => $this->base_url("/assets/img/brand/".$this->e($this->header['img'])),
            ],
            "users" => [
                "profile" => $this->DB->selectTB("db_users", "email", $this->e($_SESSION['email']), true),
            ],
            "history" => $this->DB->query("SELECT * FROM history_login ORDER BY id DESC LIMIT 1000"),
        ];

        $this->view("templates/dashboard/header", $data);
        $this->view("templates/dashboard/sidebar", $data);
        $this->view("templates/dashboard/topbar", $data);
        $this->view("dashboard/history-login", $data);
        $this->view("templates/dashboard/footer", $data);
    }

	public function login($email=false)
	{
		if (isset($_SESSION['email']) && !empty($_SESSION['email'])) header("location: ".$this->base_url('/dashboard'));


		$data = [
			"header"	=> $this->Menu->header(),
			"user"		=> $this->e($email),
		];

		$data['header']['title'] = "Login - dashboard";
		$data['header']['desc'] = "Login To dashboard Dashboard";

		$this->view("templates/login-dashboard/header", $data);
		$this->view("dashboard/login", $data);
		$this->view("templates/login-dashboard/footer", $data);
	}

	public function logout()
	{	
		if (isset($_SESSION['email']) && !empty($_SESSION['email'])) unset($_SESSION['email']);
		header("location: ".$this->base_url('/dashboard/login'));
	}
}