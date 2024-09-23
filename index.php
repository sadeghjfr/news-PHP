<?php

use database\Database;
use database\CreateDB;

session_start();

define("CURRENT_DOMAIN", currentDomain() . "/news/");
const BASE_PATH = __DIR__;
const DISPLAY_ERROR = true;
const DB_HOST = "localhost";
const DB_NAME = "news_db";
const DB_USERNAME = "root";
const DB_PASSWORD = "";

require_once 'database/DataBase.php';
//require_once 'database/CreateDB.php';
// $db = new Database();
//$db = new CreateDB();
//$db->run();


//uri("admin/category", "", "");

function uri($reservedUrl, $class, $method, $requestMethod = 'GET'){

    $currentUrl = explode("?", currentUrl())[0];
    $currentUrl = str_replace(CURRENT_DOMAIN, "", $currentUrl);
    $currentUrl = trim($currentUrl, "/");
    $currentUrlArray = explode("/", $currentUrl);
    $currentUrlArray = array_filter($currentUrlArray);

    $reservedUrl = trim($reservedUrl, "/");
    $reservedUrlArray = explode("/", $reservedUrl);
    $reservedUrlArray = array_filter($reservedUrlArray);

    if (sizeof($reservedUrlArray) != sizeof($currentUrlArray) || methodField() != $requestMethod)
        return false;

    $parameters = [];

    for ($key = 0; $key < sizeof($reservedUrlArray); $key++) {

        if ($reservedUrlArray[$key][0] == "{" &&
            $reservedUrlArray[$key][strlen($reservedUrlArray[$key])-1] == "}"){

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

    return stripos($_SERVER['SERVER_PROTOCOL'], "https") ? "https://" : "http://";
}

function currentDomain(){

    return protocol() . $_SERVER["HTTP_HOST"];
}

// css, js, images
function asset($src){

    $domain = trim(CURRENT_DOMAIN, "/ ");
    return $domain . "/" . trim($src, "/");
}

// links
function url($url){

    $domain = trim(CURRENT_DOMAIN, "/ ");
    return $domain . "/" . trim($url, "/");
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
    return "";
}

function dd($var){

    echo "<pre>";
    var_dump($var);
    exit();
}
