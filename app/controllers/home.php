<?php

/**
* 
*/
use Controller\Controller;


class home extends Controller
{
    
    function __construct()
    {
        $this->DB = $this->model('db_models');
        $this->config();
        $this->Menu = $this->helper("menu");
    }

    public function index()
    {   
        header("location: ".$this->base_url('/dashboard/login'));
        // $data = [
        //     "header" => $this->Menu->header(),
        //     "zone" => $this->DB->query("
        //         SELECT 
        //         access.id AS id,
        //         CONCAT(access.name, ' - ', area.name) AS name
        //         FROM zone_access AS access
        //         INNER JOIN zone_area AS area
        //         ON area.id = access.zone
        //         ORDER BY area.name, access.name DESC
        //     "),
        //     "relation" => $this->DB->allTB("relation"),
        // ];

        // $this->view('templates/home/header', $data);
        // $this->view('templates/home/topbar', $data);
        // $this->view('home/open-form', $data);
        // $this->view('templates/home/footer', $data);
    }
}