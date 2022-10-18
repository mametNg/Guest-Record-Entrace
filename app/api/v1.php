<?php

/**
 * 
 */
use Controller\Controller;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class v1 extends Controller
{
	
	function __construct()
	{
		$this->DB = (in_array("db_models", get_declared_classes()) ? new db_models():$this->model('db_models'));
		$this->config();
		$this->Request = $this->helper("Request"); 
		$this->PHPMailer = new PHPMailer;
	}

	public function login()
	{
		// Check session login
		if (isset($_SESSION['email']) && !empty($_SESSION['email'])) $this->printJson($this->invalid(false, 403, "This session already exist!", ["url" => $this->base_url().""]));

		// get request
		$params = $this->Request->get();

		// Filter Email
		if (!isset($params['email']) || empty($params['email'])) $this->printJson($this->invalid(false, 403, "This email cannot be empty!"));

		// Filter Password
		if (!isset($params['password']) || empty($params['password'])) $this->printJson($this->invalid(false, 403, "This password cannot be empty!"));

		// filter valid mail
		if (!$this->filterMail($params['email'])) $this->printJson($this->invalid(false, 403, "Email Isn't valid!"));

		// Get User
		$user = $this->DB->selectTB("db_users", "email", $this->e($params['email']), true);

		$history = [
			"email" => $this->e($params['email']),
			"status" => 2, // NUmber 2 email isn't registered
			"device" => $this->e($this->ua),
			"created" => time(),
		];

		// Login Failed
		if (!$user) $this->DB->insertTB("history_login", $history);
		if (!$user) $this->printJson($this->invalid(false, 403, "This email isn't registered"));

		// Valid password
		$history['status'] = 0; // NUmber 0 wrong password
		if (!password_verify($this->e($params['password']), $user['password'])) $this->DB->insertTB("history_login", $history);
		if (!password_verify($this->e($params['password']), $user['password'])) $this->printJson($this->invalid(false, 403, "Wrong Password"));

		if ($user['status'] !== "1") $this->printJson($this->invalid(false, 403, "This account isn't active!"));

		$history['status'] = 1; // NUmber 1 login success
		$this->DB->insertTB("history_login", $history);

		// Create session login
		$_SESSION['email'] = $this->e($user['email']);

		// Login success
		$response = $this->invalid(true, 200, "Login Success");
		$this->printJson($response);
	}

	public function setprofile()
	{
		// Check session login
		if (!isset($_SESSION['email']) || empty($_SESSION['email'])) $this->printJson($this->invalid());

		// get request
		$params = $this->Request->get();

		// Filter name
		if (!isset($params['name']) || empty($params['name'])) $this->printJson($this->invalid(false, 403, "This name cannot be empty!"));

		// load user
		$user = $this->DB->selectTB("db_users", "email", $this->e($_SESSION['email']), true);

		if (!$user) $this->printJson($this->invalid(false, 403, "This user cannot be empty!"));

		$dataTable = [
			"name" => $this->e(ucwords(strtolower($params['name']))),
		];		

		// Password filtering
		if (isset($params['on-password']) && !empty($params['on-password'])) {
			// Filter old password
			if (!isset($params['old-password']) || empty($params['old-password'])) $this->printJson($this->invalid(false, 403, "This old password cannot be empty!"));

			// Filter new passowrd
			if (!isset($params['new-password']) || empty($params['new-password'])) $this->printJson($this->invalid(false, 403, "This new password cannot be empty!"));

			// Filter confirm new passowrd
			if (!isset($params['confirm-new-password']) || empty($params['confirm-new-password'])) $this->printJson($this->invalid(false, 403, "This confirm new password cannot be empty!"));

			// Valid password
			if (!password_verify($this->e($params['old-password']), $user['password'])) $this->printJson($this->invalid(false, 403, "Wrong Password!"));

			// sync pass
			if ($this->e($params['new-password']) !== $this->e($params['confirm-new-password'])) $this->printJson($this->invalid(false, 403, "New password isn't sync!"));

			// sync pass
			if ($this->e($params['new-password']) == $this->e($params['old-password'])) $this->printJson($this->invalid(false, 403, "You have used this password!"));
			
			$dataTable['password'] = password_hash($this->e($params['new-password']), PASSWORD_DEFAULT);
		}

		// Change avatar True or false
		if (isset($params['on-image']) && $params['on-image'] == true) {
			// Filter image original avatar user
			if (!isset($_FILES['original-avatar']) || empty($_FILES['original-avatar'])) $this->printJson($this->invalid(false, 403, "This original avatar cannot be empty!"));

			// Filter image avatar user
			if (!isset($_FILES['avatar']) || empty($_FILES['avatar'])) $this->printJson($this->invalid(false, 403, "This avatar cannot be empty!"));

			// Valid original avatar user
			$filterImg = $this->filterImg($_FILES['original-avatar']);
			if ($filterImg['status'] !== true) $this->printJson($this->invalid(false, 403, $filterImg['msg']));

			// Valid avatar user
			$filterImg = $this->filterImg($_FILES['avatar']);
			if ($filterImg['status'] !== true) $this->printJson($this->invalid(false, 403, $filterImg['msg']));

			// Random file name
			$randFilename = $this->randString(50);

			// extract avatar file
			$thumbnail = [
				'size'		=> trim($_FILES['avatar']['size']),
				'tmp'		=> trim($_FILES['avatar']['tmp_name']),
				'pixel'		=> @getimagesize($_FILES['avatar']['tmp_name']),
				'error'		=> trim($_FILES['avatar']['error']),
				'extension'	=> explode(".", trim($_FILES['avatar']['name'])),
			];

			// extract original avatar file
			$original = [
				'size'		=> trim($_FILES['original-avatar']['size']),
				'tmp'		=> trim($_FILES['original-avatar']['tmp_name']),
				'pixel'		=> @getimagesize($_FILES['original-avatar']['tmp_name']),
				'error'		=> trim($_FILES['original-avatar']['error']),
				'extension'	=> explode(".", trim($_FILES['original-avatar']['name'])),
			];

			// image params
			$img = [
				'filename'	=> $randFilename.".".end($original['extension']),
				'pathThumb'	=> "assets/img/account/",
				'pathOri'	=> "assets/img/account/original/",
			];

			// valid extension
			if (end($thumbnail['extension']) == 'svg' || end($original['extension']) == 'svg') $this->printJson($this->invalid(false, 403, "The file must be an image!"));

			// valid size
			if ($thumbnail['size'] > 6000000 || $original['size'] > 6000000) $this->printJson($this->invalid(false, 403, "Max size 6MB!"));

			// valid pixel
			if ($thumbnail['pixel'][0] > 5000 && $thumbnail['pixel'][1] > 5000 || $original['pixel'][0] > 5000 && $original['pixel'][1] > 5000) $this->printJson($this->invalid(false, 403, "Upload JPG or PNG image. 5000 x 5000 required!"));

			// Upload Image
			$upThumb = move_uploaded_file($thumbnail['tmp'], $img['pathThumb'] . $img['filename']);
			$upOri = move_uploaded_file($original['tmp'], $img['pathOri'] . $img['filename']);

			// valid upload image
			if (!$upThumb || !$upOri) {
				// remove thumbnail
				if (file_exists($img['pathThumb'] . $img['filename'])) unlink($img['pathThumb'] . $img['filename']);
				// remove image original
				if (file_exists($img['pathOri'] . $img['filename'])) unlink($img['pathOri'] . $img['filename']);
			}

			// Remove thumbnail avatar
			if (file_exists($img['pathThumb'] . $user['img'])) unlink($img['pathThumb'] . $user['img']);
			// Remove original avatar
			if (file_exists($img['pathOri'] . $user['img'])) unlink($img['pathOri'] . $user['img']);

			$dataTable['img'] = $img['filename'];
		}

		$insert = $this->DB->updateTB("db_users", $dataTable, "email", $this->e($_SESSION['email']));

		if (!$insert) $this->printJson($this->invalid(false, 403, "Edit profile failed!"));
		$this->printJson($this->invalid(true, 200, "Edit profile success."));
	}

	public function newuser()
	{
		// Check session login
		if (!isset($_SESSION['email']) || empty($_SESSION['email'])) $this->printJson($this->invalid());

		// get request
		$params = $this->Request->get();

		// Filter name
		if (!isset($params['name']) || empty($params['name'])) $this->printJson($this->invalid(false, 403, "This name cannot be empty!"));

		// Filter email
		if (!isset($params['email']) || empty($params['email'])) $this->printJson($this->invalid(false, 403, "This email cannot be empty!"));

		// Filter password
		if (!isset($params['password']) || empty($params['password'])) $this->printJson($this->invalid(false, 403, "This password cannot be empty!"));

		// Filter confirm-password
		if (!isset($params['confirm-password']) || empty($params['confirm-password'])) $this->printJson($this->invalid(false, 403, "This confirm-password cannot be empty!"));

		// filter valid mail
		if (!$this->filterMail($params['email'])) $this->printJson($this->invalid(false, 403, "Email Isn't valid!"));

		// sync pass
		if ($this->e($params['password']) !== $this->e($params['confirm-password'])) $this->printJson($this->invalid(false, 403, "This password isn't sync!"));
		
		// Get User
		$user = $this->DB->selectTB("db_users", "email", $this->e($params['email']), true);

		// valid user
		if ($user) $this->printJson($this->invalid(false, 403, "This email already exist!"));
		
		$dataTable = [
			"id" => $this->e(strtoupper($this->randString(5))),
			"name" => $this->e(ucwords(strtolower($params['name']))), 
			"email" => $this->e(strtolower($params['email'])), 
			"password" => password_hash($this->e($params['password']), PASSWORD_DEFAULT),
			"img" => "default.jpg",
			"status" => "1",
			"created" => time(),
		];

		$insert = $this->DB->insertTB("db_users", $dataTable);

		if (!$insert) $this->printJson($this->invalid(false, 403, "Add new user failed!"));
		$this->printJson($this->invalid(true, 200, "Add new user success."));
	}

	public function enableuser()
	{
		// Check session login
		if (!isset($_SESSION['email']) || empty($_SESSION['email'])) $this->printJson($this->invalid());

		// get request
		$params = $this->Request->get();

		// Filter Email
		if (!isset($params['info']) || empty($params['info'])) $this->printJson($this->invalid(false, 403, "This info id cannot be empty!"));

		// get user
		$user = $this->DB->selectTB("db_users", "id", $this->e(strtoupper($params['info'])), true);

		// valid user
		if (!$user) $this->printJson($this->invalid(false, 403, "This user isn't registered!"));
		if ($user['status']) $this->printJson($this->invalid(false, 403, "This user can't to enabled!"));

		$dataTable = [
			"status" => 1
		];

		$update = $this->DB->updateTB("db_users", $dataTable, "id", $this->e(strtoupper($params['info'])));

		if (!$update) $this->printJson($this->invalid(false, 403, "Enable user failed!"));
		$this->printJson($this->invalid(true, 200, "Enable user success!"));
	}

	public function disableuser()
	{
		// Check session login
		if (!isset($_SESSION['email']) || empty($_SESSION['email'])) $this->printJson($this->invalid());

		// get request
		$params = $this->Request->get();

		// Filter Email
		if (!isset($params['info']) || empty($params['info'])) $this->printJson($this->invalid(false, 403, "This info id cannot be empty!"));

		// get user
		$user = $this->DB->selectTB("db_users", "id", $this->e(strtoupper($params['info'])), true);

		// valid user
		if (!$user) $this->printJson($this->invalid(false, 403, "This user isn't registered!"));
		if (!$user['status']) $this->printJson($this->invalid(false, 403, "This user can't to disabled!"));

		$dataTable = [
			"status" => 0
		];

		$update = $this->DB->updateTB("db_users", $dataTable, "id", $this->e(strtoupper($params['info'])));

		if (!$update) $this->printJson($this->invalid(false, 403, "Disable user failed!"));
		$this->printJson($this->invalid(true, 200, "Disable user success!"));
	}

	public function deleteuser()
	{
		// Check session login
		if (!isset($_SESSION['email']) || empty($_SESSION['email'])) $this->printJson($this->invalid());

		// get request
		$params = $this->Request->get();

		// Filter Email
		if (!isset($params['info']) || empty($params['info'])) $this->printJson($this->invalid(false, 403, "This user info cannot be empty!"));

		// DISABLED FEATURE
		$this->printJson($this->invalid(false, 403, "Disable Feature"));

		// get user
		$user = $this->DB->selectTB("db_users", "id", $this->e($params['info']), true);

		// valid user
		if (!$user) $this->printJson($this->invalid(false, 403, "This user isn't registered!"));

		$excecute = $this->DB->deltTB("db_users", "id", $this->e($params['info']));

		if (!$excecute) $this->printJson($this->invalid(false, 403, "Delete user failed!"));

		$this->printJson($this->invalid(true, 200, "Delete user success"));
	}

	public function setHeader()
	{
		// Check session login
		if (!isset($_SESSION['email']) || empty($_SESSION['email'])) $this->printJson($this->invalid());

		// get request
		$params = $this->Request->get();

		// Filter title
		if (!isset($params['title']) || empty($params['title'])) $this->printJson($this->invalid(false, 403, "This title cannot be empty!"));

		// Filter brand
		if (!isset($params['brand']) || empty($params['brand'])) $this->printJson($this->invalid(false, 403, "This brand cannot be empty!"));

		// Filter desc
		if (!isset($params['desc']) || empty($params['desc'])) $this->printJson($this->invalid(false, 403, "This description cannot be empty!"));

		$header = $this->DB->selectTB("header", "id", "VHJAV", true);
		
		$dataTable = [
			"title" => $this->e($params['title']),
			"brand" => $this->e($params['brand']),
			"description" => $this->e($params['desc']),
		];

		// Change avatar True or false
		if (isset($params['on-image']) && $params['on-image'] == true) {
			// Filter image original avatar user
			if (!isset($_FILES['original-logo']) || empty($_FILES['original-logo'])) $this->printJson($this->invalid(false, 403, "This original avatar cannot be empty!"));

			// Filter image avatar user
			if (!isset($_FILES['avatar']) || empty($_FILES['avatar'])) $this->printJson($this->invalid(false, 403, "This avatar cannot be empty!"));

			// Valid original avatar user
			$filterImg = $this->filterImg($_FILES['original-logo']);
			if ($filterImg['status'] !== true) $this->printJson($this->invalid(false, 403, $filterImg['msg']));

			// Valid avatar user
			$filterImg = $this->filterImg($_FILES['avatar']);
			if ($filterImg['status'] !== true) $this->printJson($this->invalid(false, 403, $filterImg['msg']));

			// Random file name
			$randFilename = $this->randString(50);

			// extract avatar file
			$thumbnail = [
				'size'		=> trim($_FILES['avatar']['size']),
				'tmp'		=> trim($_FILES['avatar']['tmp_name']),
				'pixel'		=> @getimagesize($_FILES['avatar']['tmp_name']),
				'error'		=> trim($_FILES['avatar']['error']),
				'extension'	=> explode(".", trim($_FILES['avatar']['name'])),
			];

			// extract original avatar file
			$original = [
				'size'		=> trim($_FILES['original-logo']['size']),
				'tmp'		=> trim($_FILES['original-logo']['tmp_name']),
				'pixel'		=> @getimagesize($_FILES['original-logo']['tmp_name']),
				'error'		=> trim($_FILES['original-logo']['error']),
				'extension'	=> explode(".", trim($_FILES['original-logo']['name'])),
			];

			// image params
			$img = [
				'filename'	=> $randFilename.".".end($original['extension']),
				'pathThumb'	=> "assets/img/brand/",
				// 'pathOri'	=> "assets/img/account/original/",
			];

			// valid extension
			if (end($thumbnail['extension']) == 'svg' || end($original['extension']) == 'svg') $this->printJson($this->invalid(false, 403, "The file must be an image!"));

			// valid size
			if ($thumbnail['size'] > 6000000 || $original['size'] > 6000000) $this->printJson($this->invalid(false, 403, "Max size 6MB!"));

			// valid pixel
			if ($thumbnail['pixel'][0] > 5000 && $thumbnail['pixel'][1] > 5000 || $original['pixel'][0] > 5000 && $original['pixel'][1] > 5000) $this->printJson($this->invalid(false, 403, "Upload JPG or PNG image. 5000 x 5000 required!"));

			// Upload Image
			$upThumb = move_uploaded_file($thumbnail['tmp'], $img['pathThumb'] . $img['filename']);
			// $upOri = move_uploaded_file($original['tmp'], $img['pathOri'] . $img['filename']);

			// valid upload image
			if (!$upThumb) {
				// remove thumbnail
				if (file_exists($img['pathThumb'] . $img['filename'])) unlink($img['pathThumb'] . $img['filename']);
				// remove image original
				// if (file_exists($img['pathOri'] . $img['filename'])) unlink($img['pathOri'] . $img['filename']);
			}

			// Remove thumbnail avatar
			if (file_exists($img['pathThumb'] . $header['img'])) unlink($img['pathThumb'] . $header['img']);
			// Remove original avatar
			// if (file_exists($img['pathOri'] . $user['img'])) unlink($img['pathOri'] . $user['img']);

			$dataTable['img'] = $img['filename'];
		}

		$update = $this->DB->updateTB("header", $dataTable, "id", "VHJAV");

		if (!$update) $this->printJson($this->invalid(false, 403, "Update header failed!"));
		$this->printJson($this->invalid(true, 200, "Update header success!"));
	}

	public function record()
	{
		// Check session login
		if (!isset($_SESSION['email']) || empty($_SESSION['email'])) $this->printJson($this->invalid());

		// get request
		$params = $this->Request->get();

		// GUEST USER
		if (!isset($_POST['guest']) || empty($_POST['guest'])) $this->printJson($this->invalid(false, 403, "Guest data cannot be empty!"));

		$arrayPost = @json_decode($_POST['guest'], true);
		if ($arrayPost === null && json_last_error() !== JSON_ERROR_NONE) $this->printJson($this->invalid(false, 403, "Guest data invalid!"));
		// END GUEST USER

		// GUEST ZONE
		if (!isset($params['company']) || empty($params['company'])) $this->printJson($this->invalid(false, 403, "This company cannot be empty!"));

		if (!isset($params['relation']) || empty($params['relation'])) $this->printJson($this->invalid(false, 403, "This relation cannot be empty!"));
		if (!isset($params['relation-other']) || empty($params['relation-other'])) $this->printJson($this->invalid(false, 403, "This relation other cannot be empty!"));

		if (!isset($params['bussines']) || empty($params['bussines'])) $this->printJson($this->invalid(false, 403, "This bussines cannot be empty!"));

		if (!isset($params['area']) || empty($params['area'])) $this->printJson($this->invalid(false, 403, "This area cannot be empty!"));
		if (!isset($params['area-other']) || empty($params['area-other'])) $this->printJson($this->invalid(false, 403, "This area other cannot be empty!"));

		if (!isset($params['guest-total']) || empty($params['guest-total'])) $this->printJson($this->invalid(false, 403, "This guest total cannot be empty!"));

		if (!isset($params['pic-name']) || empty($params['pic-name'])) $this->printJson($this->invalid(false, 403, "This pic name cannot be empty!"));
		if (!isset($params['pic-dept']) || empty($params['pic-dept'])) $this->printJson($this->invalid(false, 403, "This pic dept cannot be empty!"));

		if (!is_numeric($params['guest-total']) || !intval($params['guest-total']) || !$this->filterNumb($params['guest-total'])) $this->printJson($this->invalid(false, 403, "Guest total isn't valid!"));

		if (!$this->filterString($params['pic-name'])) $this->printJson($this->invalid(false, 403, "Pic name isn't valid!"));

		if (isset($params['pic-agre']) && $params['pic-agre'] == true) if (!isset($params['pic-note']) || empty($params['pic-note'])) $this->printJson($this->invalid(false, 403, "This note cannot be empty!"));
		// END GUEST ZONE

		$gzone = $this->DB->query("SELECT id FROM guest_zone_record ORDER BY id DESC", true);
		$guser = $this->DB->query("SELECT id FROM guest_user_record ORDER BY id DESC", true);
		$users = $this->DB->selectTB("db_users", "email", $this->e($_SESSION['email']), true);

		$gzid = 000000000001;
		$guid = 000000000001;
		$idSample = "000000000000";

		$GZ = [
			"id" => ($gzone ? "GZ-". substr($idSample, 0, (strlen($idSample) - strlen((explode("GZ-", $gzone['id'])[1] + 1)))) .(explode("GZ-", $gzone['id'])[1] + 1) : "GZ-". substr($idSample, 0, (strlen($idSample) - strlen($gzid))) .$gzid),
			"company" => $this->e($params['company']),
			"relation" => $this->e($params['relation']),
			"other_relation" => ($this->e($params['relation-other']) == "off" ? "":$this->e($params['relation-other'])),
			"bussines" => $this->e($params['bussines']),
			"area" => $this->e($params['area']),
			"other_area" => ($this->e($params['area-other']) == "off" ? "":$this->e($params['area-other'])),
			"total_guest" => $this->e($params['guest-total']),
			"date_in" => time(),
			"date_out" => 0,
			"date_created" => time(),
			"pic_name" => $this->e($params['pic-name']),
			"pic_dept" => $this->e($params['pic-dept']),
			"pic_agree" => $this->e((isset($params['pic-agre']) && $params['pic-agre'] == true ? 1:0)),
			"pic_note" => ($this->e($params['pic-note']) == "off" ? "":$this->e($params['pic-note'])),
			"in_by" => $this->e($users['id']),
			"out_by" => '',
		];

		$GU = [];

		// GUEST USER ARRAY
		foreach ($arrayPost as $g_u) {
			if (isset($guser['id'])) $guser['id']++;
			$guest['id'] = ($guser ? "GU-". substr($idSample, 0, (strlen($idSample) - strlen((explode("GU-", $guser['id'])[1])))) .(explode("GU-", $guser['id'])[1]) : "GU-". substr($idSample, 0, (strlen($idSample) - strlen($guid))) .$guid);
			$guest['gz_id'] = $GZ['id'];

			// Guest User Name
			if (!$this->filterString($g_u['guName'])) $this->printJson($this->invalid(false, 403, "Guest user name isn't valid!"));
			$guest['name'] = $this->e(ucwords(strtolower($g_u['guName'])));

			// Guest User Identity
			if (!is_numeric($g_u['guIdentity']) || !intval($g_u['guIdentity']) || !$this->filterNumb($g_u['guIdentity']) && strlen($this->e($g_u['guIdentity'])) !== 16) $this->printJson($this->invalid(false, 403, "guest user identity isn't valid!"));
			$guest['identity'] = $this->e($g_u['guIdentity']);

			// Guest User Vaksin
			if (!isset($g_u['guVaksin']) || empty($g_u['guVaksin'])) $this->printJson($this->invalid(false, 403, "This Vaksin cannot be empty!"));
			$guest['vaksin'] = $this->e($g_u['guVaksin']);

			// Guest User Temperatur
			if (!isset($g_u['guTemp']) || empty($g_u['guTemp']) && strlen($this->e($g_u['guTemp'])) !== 2) $this->printJson($this->invalid(false, 403, "guest user temperature isn't valid!"));
			$guest['temp'] = $this->e($g_u['guTemp']);

			// Guest User ID Card
			if (!isset($g_u['guCard']) || empty($g_u['guCard']) && strlen($this->e($g_u['guCard'])) !== 3) $this->printJson($this->invalid(false, 403, "guest user card number isn't valid!"));
			$guest['card_numb'] = $this->e($g_u['guCard']);

			$guid++;
			array_push($GU, $guest);
		}
		// END GUEST USER ARRAY

		$guest_zone = $this->DB->insertTB("guest_zone_record", $GZ);
		$guest_user = $this->DB->insertTB("guest_user_record", $GU, true);

		if (!$guest_zone) $this->printJson($this->invalid(false, 403, "insert guest zone failed"));
		if (!$guest_user) $this->printJson($this->invalid(false, 403, "insert guest user failed"));

		$result = [
			// "id" => $GZ['id'],
			// "date_created" => date("Y-m-d", $GZ['date_created']),
			// "date_in" => date("Y-m-d\TH:i", $GZ['date_in']),
			// "title" => "Guest Record Out",
			"url" => $this->base_url("/dashboard/form/".$this->balitbangEncode($GZ['id'])),
		];

		$this->printJson($this->invalid(true, 200, "Success input to guest record entrace.", $result));
	}

	public function editrecord()
	{
		// Check session login
		if (!isset($_SESSION['email']) || empty($_SESSION['email'])) $this->printJson($this->invalid());

		// get request
		$params = $this->Request->get();

		// GUEST USER
		if (!isset($_POST['guest']) || empty($_POST['guest'])) $this->printJson($this->invalid(false, 403, "Guest data cannot be empty!"));

		$arrayPost = @json_decode($_POST['guest'], true);
		if ($arrayPost === null && json_last_error() !== JSON_ERROR_NONE) $this->printJson($this->invalid(false, 403, "Guest data invalid!"));
		// END GUEST USER

		// GUEST ZONE
		if (!isset($params['id']) || empty($params['id'])) $this->printJson($this->invalid(false, 403, "This id cannot be empty!"));

		if (!isset($params['company']) || empty($params['company'])) $this->printJson($this->invalid(false, 403, "This company cannot be empty!"));

		if (!isset($params['relation']) || empty($params['relation'])) $this->printJson($this->invalid(false, 403, "This relation cannot be empty!"));

		if (!isset($params['relation-other']) || empty($params['relation-other'])) $this->printJson($this->invalid(false, 403, "This relation other cannot be empty!"));

		if (!isset($params['bussines']) || empty($params['bussines'])) $this->printJson($this->invalid(false, 403, "This bussines cannot be empty!"));

		if (!isset($params['area']) || empty($params['area'])) $this->printJson($this->invalid(false, 403, "This area cannot be empty!"));
		if (!isset($params['area-other']) || empty($params['area-other'])) $this->printJson($this->invalid(false, 403, "This area other cannot be empty!"));

		if (!isset($params['pic-name']) || empty($params['pic-name'])) $this->printJson($this->invalid(false, 403, "This pic name cannot be empty!"));
		if (!isset($params['pic-dept']) || empty($params['pic-dept'])) $this->printJson($this->invalid(false, 403, "This pic dept cannot be empty!"));

		if (!$this->filterString($params['pic-name'])) $this->printJson($this->invalid(false, 403, "Pic name isn't valid!"));

		if (isset($params['pic-agre']) && $params['pic-agre'] == true) if (!isset($params['pic-note']) || empty($params['pic-note'])) $this->printJson($this->invalid(false, 403, "This note cannot be empty!"));
		// END GUEST ZONE
		
		// get data guest Zone		
		$gzone = $this->DB->query("SELECT * FROM guest_zone_record WHERE id='". $params['id'] ."'", true);

		if (!$gzone) $this->printJson($this->invalid(false, 403, "Guest zone isn't registered!"));

		$GZ = [
			"company" => $this->e($params['company']),
			"relation" => $this->e($params['relation']),
			"other_relation" => ($this->e($params['relation-other']) == "off" ? "":$this->e($params['relation-other'])),
			"bussines" => $this->e($params['bussines']),
			"area" => $this->e($params['area']),
			"other_area" => ($this->e($params['area-other']) == "off" ? "":$this->e($params['area-other'])),

			"pic_name" => $this->e($params['pic-name']),
			"pic_dept" => $this->e($params['pic-dept']),
			"pic_agree" => $this->e((isset($params['pic-agre']) && $params['pic-agre'] == true ? 1:0)),
			"pic_note" => ($this->e($params['pic-note']) == "off" ? "":$this->e($params['pic-note'])),
		];


		$GU = [];
		// GUEST USER ARRAY
		foreach ($arrayPost as $g_u) {

			$GU = [];

			// Guest User Name
			if (!isset($g_u['guID']) || empty($g_u['guID'])) $this->printJson($this->invalid(false, 403, "Guest user id isn't valid!"));
			// $GU['id'] = $this->e(ucwords(strtolower($g_u['guID'])));

			if (!$this->filterString($g_u['guName'])) $this->printJson($this->invalid(false, 403, "Guest user name isn't valid!"));
			$GU['name'] = $this->e(ucwords(strtolower($g_u['guName'])));

			// Guest User Identity
			if (!is_numeric($g_u['guIdentity']) || !intval($g_u['guIdentity']) || !$this->filterNumb($g_u['guIdentity']) && strlen($this->e($g_u['guIdentity'])) !== 16) $this->printJson($this->invalid(false, 403, "guest user identity isn't valid!"));
			$GU['identity'] = $this->e($g_u['guIdentity']);

			// Guest User Vaksin
			if (!isset($g_u['guVaksin']) || empty($g_u['guVaksin'])) $this->printJson($this->invalid(false, 403, "This Vaksin cannot be empty!"));
			$GU['vaksin'] = $this->e($g_u['guVaksin']);

			// Guest User Temperatur
			if (!isset($g_u['guTemp']) || empty($g_u['guTemp']) && strlen($this->e($g_u['guTemp'])) !== 2) $this->printJson($this->invalid(false, 403, "guest user temperature isn't valid!"));
			$GU['temp'] = $this->e($g_u['guTemp']);

			// Guest User ID Card
			if (!isset($g_u['guCard']) || empty($g_u['guCard']) && strlen($this->e($g_u['guCard'])) !== 3) $this->printJson($this->invalid(false, 403, "guest user card number isn't valid!"));
			$GU['card_numb'] = $this->e($g_u['guCard']);

			$updateGU = $this->DB->updateTB("guest_user_record", $GU, "id", $this->e($g_u['guID']));

			if (!$gzone) $this->printJson($this->invalid(false, 403, "Update guest user failed!"));
		}
		// END GUEST USER ARRAY

		$updateGZ = $this->DB->updateTB("guest_zone_record", $GZ, "id", $this->e($params['id']));
		if (!$gzone) $this->printJson($this->invalid(false, 403, "Update guest zone failed!"));

		$result = [
			"url" => $this->base_url("/dashboard/form/".$this->balitbangEncode($params['id'])),
		];

		$this->printJson($this->invalid(true, 200, "Success update to guest record entrace.", $result));
	}

	public function checkout()
	{	
		// Check session login
		if (!isset($_SESSION['email']) || empty($_SESSION['email'])) $this->printJson($this->invalid());

		// get request
		$params = $this->Request->get();

		// GUEST USER
		if (!isset($params['code']) || empty($params['code'])) $this->printJson($this->invalid(false, 403, "code data cannot be empty!"));

		$code = $this->balitbangDecode($this->e($params['code']));
		
		if (!$code) $this->printJson($this->invalid(false, 403, "code isn't valid!"));

		$zone = $this->DB->query("SELECT * FROM guest_zone_record WHERE id = '".$this->balitbangDecode($this->e($params['code']))  ."'", true);

		$user =  $this->DB->query("SELECT * FROM guest_user_record WHERE gz_id = '". $this->balitbangDecode($this->e($params['code'])) ."'");

		$users = $this->DB->selectTB("db_users", "email", $this->e($_SESSION['email']), true);

		if (!isset($zone) || empty($zone) && !isset($user) || empty($user) && !isset($users) || empty($users)) $this->printJson($this->invalid(false, 403, "code not found!"));

		if ($zone['date_out']) $this->printJson($this->invalid(false, 403, "cannot sign out be back!"));

		$dataTable = [
			"date_out" => time(),
			"out_by" => $this->e($users['id']),
		];


		$result = ['url'=>$this->base_url('/dashboard/summary')];

		$excecute = $this->DB->updateTB("guest_zone_record", $dataTable, "id", $this->balitbangDecode($this->e($params['code'])));
		if (!$excecute) $this->printJson($this->invalid(false, 403, "Sign out failed, Please try!"));
		$this->printJson($this->invalid(true, 200, "Sign out success.", $result));
	}

	public function getSummary($value='')
	{
		// get request
		$params = $this->Request->get();

		// GUEST USER
		if (!isset($params['code']) || empty($params['code'])) $this->printJson($this->invalid(false, 403, "code data cannot be empty!"));


		$excecute = $this->DB->query("
			SELECT
			COUNT(date_created) AS total,
			date_created AS date
			FROM guest_zone_record
			WHERE DATE_FORMAT(CAST(FROM_UNIXTIME(date_created) AS DATE), '%Y') = '". date("Y", $this->e($params['code'])) ."'
			GROUP BY DATE_FORMAT(CAST(FROM_UNIXTIME(date_created) AS DATE), '%m-%Y')
			ORDER BY date_created ASC
			");

		$details = $this->DB->query("
                SELECT
                zone.company AS company,
                CONCAT(IF(zone.area = 'OTHER', zone.other_area, access.name), '-', area.name) AS area,
                COUNT(user.id) AS guest_total,
                IF(zone.date_out, 'Finish', 'Progress') AS date_out,
                DATE_FORMAT(FROM_UNIXTIME(zone.date_created), '%Y-%m-%d %h:%i:%s') AS date_created
                FROM guest_zone_record AS zone
                INNER JOIN guest_user_record AS user
                ON user.gz_id = zone.id
                INNER JOIN zone_access AS access
                ON access.id = zone.area
                INNER JOIN zone_area AS area
                ON area.id = access.zone
                WHERE DATE_FORMAT(CAST(FROM_UNIXTIME(zone.date_created) AS DATE), '%Y') = '". date("Y", $this->e($params['code'])) ."'
                GROUP BY zone.company
                ORDER BY date_created DESC
            ");

		if (!$excecute || !$details) $this->printJson($this->invalid(false, 403, "Data not found!"));

		$result = [
			"simp" => $excecute,
			"details" => $details,
		];

		$this->printJson($this->invalid(true, 200, "ok", $result));
	}
}