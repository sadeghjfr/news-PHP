<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <link rel="shortcut icon" href="" type="image/x-icon" />

    <link rel="stylesheet" href="<?= asset('public/admin-panel/css/bootstrap.min.css') ?>" type="text/css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <!-- Material Design Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.7.6/css/mdb.min.css" rel="stylesheet">

    <link href="<?= asset('public/admin-panel/css/style.css') ?>" rel="stylesheet" type="text/css">
    <link href="<?= asset('public/jalalidatepicker/persian-datepicker.min.css') ?>" rel="stylesheet" type="text/css">

</head>
<body>

<nav class="navbar  navbar-light bg-gradiant-green-blue nav-shadow">

    <a class="navbar-brand" href=""></a>
    <span class="">
   </a>
        <span class="dropdown">
                <a class="dropdown-toggle text-decoration-none text-dark" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user"></i>

                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="<?=url('logout')?>">logout</a>
                </div>
            </span>
        </span>
</nav>

<div class="container-fluid">
    <div class="row">

        <?php require_once (BASE_PATH . '/template/admin/layouts/sidebar.php') ?>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">