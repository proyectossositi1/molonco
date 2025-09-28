<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Home extends BaseController
{
    function index(){
        $data['empresa'] = 'molonco';
        
        return view("www/{$data['empresa']}/index", $data);
    }

    function navegation($view = null){
        $data['empresa'] = 'molonco';
        
        if(!empty($view)){
            return view("www/{$data['empresa']}/{$view}", $data);
        }
    }
}