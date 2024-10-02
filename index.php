<?php

use database\Database;
use database\CreateDB;

session_start();

define("CURRENT_DOMAIN", currentDomain() ."/news/");
const BASE_PATH = __DIR__;
const DISPLAY_ERROR = true;
const DB_HOST ="localhost";
const DB_NAME ="news_db";
const DB_USERNAME ="root";
const DB_PASSWORD ="";

const MAIL_HOST = "smtp.gmail.com";
const SMTP_AUTH = true;
const MAIL_USERNAME = "sadeghjfr22@gmail.com";
const MAIL_PASSWORD = "rvyq pmos xapp boia";
const MAIL_PORT = 587;
const SENDER_MAIL = "sadeghjfr22@gmail.com";
const SENDER_NAME = "SADEGH JAFARI";

require_once 'database/DataBase.php';

require_once 'activities/admin/Admin.php';
require_once 'activities/admin/Dashboard.php';
require_once 'activities/admin/Category.php';
require_once 'activities/admin/Post.php';
require_once 'activities/admin/Banner.php';
require_once 'activities/admin/User.php';
require_once 'activities/admin/Comment.php';
require_once 'activities/admin/Menu.php';
require_once 'activities/admin/Setting.php';

require_once 'activities/auth/Auth.php';
require_once 'activities/app/Home.php';

spl_autoload_register(function ($className){
    $path = BASE_PATH . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR;
    $className = str_replace("\\", DIRECTORY_SEPARATOR, $className);
    include $path . $className . '.php';
});


function jalaliDate($date){
    date_default_timezone_set('Iran');
    return Parsidev\Jalali\jdate::forge($date)->format('%A, %d %B %Y  ساعت H:i:s');
}

function uri($reservedUrl, $class, $method, $requestMethod = 'GET'){

    $currentUrl = explode("?", currentUrl())[0];
    $currentUrl = str_replace(CURRENT_DOMAIN,"", $currentUrl);
    $currentUrl = trim($currentUrl,"/");
    $currentUrlArray = explode("/", $currentUrl);
    $currentUrlArray = array_filter($currentUrlArray);

    $reservedUrl = trim($reservedUrl,"/");
    $reservedUrlArray = explode("/", $reservedUrl);
    $reservedUrlArray = array_filter($reservedUrlArray);

    if (sizeof($reservedUrlArray) != sizeof($currentUrlArray) || methodField() != $requestMethod)
        return false;

    $parameters = [];

    for ($key = 0; $key < sizeof($reservedUrlArray); $key++) {

        if ($reservedUrlArray[$key][0] =="{" &&
            $reservedUrlArray[$key][strlen($reservedUrlArray[$key])-1] =="}"){

            $parameters[] = $currentUrlArray[$key];
        }

        elseif ($currentUrlArray[$key] != $reservedUrlArray[$key])
            return false;
    }


    if (methodField() == 'POST'){

        $request = isset($_FILES) ? array_merge($_POST, $_FILES) : $_POST;

        $parameters = array_merge([$request], $parameters);
    }


    $object = new $class;
    call_user_func_array(array($object, $method), $parameters);

    exit();
}

function protocol(){

    return stripos($_SERVER['SERVER_PROTOCOL'],"https") ?"https://" :"http://";
}

function currentDomain(){

    return protocol() . $_SERVER["HTTP_HOST"];
}

// css, js, images
function asset($src){

    $domain = trim(CURRENT_DOMAIN,"/");
    return $domain ."/" . trim($src,"/");
}

// links
function url($url){

    $domain = trim(CURRENT_DOMAIN,"/");
    return $domain ."/" . trim($url,"/");
}

function currentUrl(){
    return currentDomain() . $_SERVER['REQUEST_URI'];
}

function methodField(){

    return $_SERVER["REQUEST_METHOD"];
}

function displayError($displayError){

    if ($displayError){

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }

    else{

        ini_set('display_errors', 0);
        ini_set('display_startup_errors', 0);
        error_reporting(0);
    }

}

global $flash_message;

if (isset($_SESSION['flash_message'])){
    $flash_message = $_SESSION['flash_message'];
    unset($_SESSION['flash_message']);
}

function flash($name, $value = null){

    if ($value === null){

        global $flash_message;
        return isset($flash_message[$name]) ? $flash_message[$name] : '';
    }

    else{

        $_SESSION['flash_message'][$name] = $value;
    }
    return"";
}

function dd($var){

    echo"<pre>";
    var_dump($var);
    exit();
}


//dashboard
uri("admin","admin\Dashboard","index");

//category

uri("admin/category","admin\Category","index");
uri("admin/category/create","admin\Category","create");
uri("admin/category/store","admin\Category","store","POST");
uri("admin/category/edit/{id}","admin\Category","edit");
uri("admin/category/update/{id}","admin\Category","update","POST");
uri("admin/category/delete/{id}","admin\Category","delete");

//post

uri("admin/post","admin\Post","index");
uri("admin/post/create","admin\Post","create");
uri("admin/post/store","admin\Post","store","POST");
uri("admin/post/edit/{id}","admin\Post","edit");
uri("admin/post/update/{id}","admin\Post","update","POST");
uri("admin/post/delete/{id}","admin\Post","delete");
uri("admin/post/selected/{id}","admin\Post","selected");
uri("admin/post/breaking-news/{id}","admin\Post","breakingNews");

//banner

uri("admin/banner","admin\Banner","index");
uri("admin/banner/create","admin\Banner","create");
uri("admin/banner/store","admin\Banner","store","POST");
uri("admin/banner/edit/{id}","admin\Banner","edit");
uri("admin/banner/update/{id}","admin\Banner","update","POST");
uri("admin/banner/delete/{id}","admin\Banner","delete");

//user

uri("admin/user","admin\User","index");
uri("admin/user/edit/{id}","admin\User","edit");
uri("admin/user/update/{id}","admin\User","update","POST");
uri("admin/user/permission/{id}","admin\User","permission");

//comment

uri("admin/comment","admin\Comment","index");
uri("admin/comment/show/{id}","admin\Comment","show");
uri("admin/comment/status/{id}","admin\Comment","status");


//menu

uri("admin/menu","admin\Menu","index");
uri("admin/menu/create","admin\Menu","create");
uri("admin/menu/store","admin\Menu","store","POST");
uri("admin/menu/edit/{id}","admin\Menu","edit");
uri("admin/menu/update/{id}","admin\Menu","update","POST");
uri("admin/menu/delete/{id}","admin\Menu","delete");

//menu

uri("admin/setting","admin\Setting","index");
uri("admin/setting/edit","admin\Setting","edit");
uri("admin/setting/update","admin\Setting","update","POST");

//auth

uri("register","auth\Auth","register");
uri("register/store","auth\Auth","registerStore","POST");
uri("activation/{verify_token}","auth\Auth","activation");
uri("login","auth\Auth","login");
uri("check-login","auth\Auth","checkLogin","POST");
uri("logout","auth\Auth","logout");
uri("forgot","auth\Auth","forgot");
uri("forgot/request","auth\Auth","forgotRequest", "POST");
uri("reset-password-form/{forgot_token}","auth\Auth","resetPasswordView");
uri("reset-password/{forgot_token}","auth\Auth","resetPassword", "POST");

//app

uri('/', 'app\Home', 'index');
uri('/home', 'app\Home', 'index');
uri('/show-post/{id}', 'app\Home', 'show');
uri('/show-category/{id}', 'app\Home', 'category');
uri('/comment-store/{id}', 'app\Home', 'commentStore', 'POST');

require_once 'template/404.php';