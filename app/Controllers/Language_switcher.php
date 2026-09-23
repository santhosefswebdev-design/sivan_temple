<?php
namespace App\Controllers;
use App\Controllers\BaseController;



use App\Models\PermissionModel;
class Language_switcher extends BaseController
{
    function __construct(){
        parent:: __construct();
    }
    
    public function index($switch_lang = 'english'){
        if($switch_lang == 'english'){
            $_SESSION['language'] = 'english';
        }elseif($switch_lang == 'tamil'){
             $_SESSION['language'] = 'tamil';
        }else{
             $_SESSION['language'] = 'english';
        }
        header('location: '.base_url().'/dashboard');
        exit;
    }
}