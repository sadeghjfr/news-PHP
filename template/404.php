<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>
    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon-->
    <link rel="shortcut icon" href="<?= asset($setting['icon']) ?>">
    <!-- Author Meta -->
    <meta name="author" content="colorlib">
    <!-- Meta Description -->
    <meta name="description" content="<?= $setting['description'] ?>">
    <!-- Meta Keyword -->
    <meta name="keywords" content="<?= $setting['keywords'] ?>">
    <!-- meta character set -->
    <meta charset="UTF-8">
    <!-- Site Title -->
    <title><?= $setting['title'] ?></title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet">
    <!--
		CSS
		============================================= -->
    <link rel="stylesheet" href="<?= asset('public/app/css/linearicons.css') ?>">
    <link rel="stylesheet" href="<?= asset('public/app/css/font-awesome.min.css') ?>">
    <link rel="stylesheet" href="<?= asset('public/app/css/bootstrap.css') ?>">
    <link rel="stylesheet" href="<?= asset('public/app/css/magnific-popup.css') ?>">
    <link rel="stylesheet" href="<?= asset('public/app/css/nice-select.css') ?>">
    <link rel="stylesheet" href="<?= asset('public/app/css/animate.min.css') ?>">
    <link rel="stylesheet" href="<?= asset('public/app/css/owl.carousel.css') ?>">
    <link rel="stylesheet" href="<?= asset('public/app/css/jquery-ui.css') ?>">
    <link rel="stylesheet" href="<?= asset('public/app/css/main.css') ?>">
</head>

<body>

<div class="main-content-page">
    <div class="container">
        <!-- breadcrumb -->
        <div class="breadcrumb">
            <ul itemtype="http://schema.org/BreadcrumbList">
                <li itemtype="http://schema.org/ListItem" itemscope itemprop="itemListElement"><a href="" itemprop="item" class="current"><span itemprop="name">  خطای 404 </span></a></li>
            </ul>
        </div>
        <!-- /breadcrumb -->

        <div class="notfound-page">

            <div class="container">
                <div class="notfound text-center">
                    <img width="500" height="500" src="<?= asset('public/image/404.svg') ?>" class="lazy" alt="">
                    <br>
                    <br>
                    <p class="title"> ممکن است صفحه ای که به دنبال آن میگردید حذف شده باشد و یا آدرس آن را به درستی وارد نکرده باشید </p>
                </div>
            </div>

        </div>

    </div>
</div>

<script src="<?= asset('public/app/js/vendor/jquery-2.2.4.min.js') ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="<?= asset('public/app/js/vendor/bootstrap.min.js') ?>"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhOdIF3Y9382fqJYt5I_sswSrEw5eihAA"></script>
<script src="<?= asset('public/app/js/easing.min.js') ?>"></script>
<script src="<?= asset('public/app/js/hoverIntent.js') ?>"></script>
<script src="<?= asset('public/app/js/superfish.min.js') ?>"></script>
<script src="<?= asset('public/app/js/jquery.ajaxchimp.min.js') ?>"></script>
<script src="<?= asset('public/app/js/jquery.magnific-popup.min.js') ?>"></script>
<script src="<?= asset('public/app/js/mn-accordion.js') ?>"></script>
<script src="<?= asset('public/app/js/jquery-ui.js') ?>"></script>
<script src="<?= asset('public/app/js/jquery.nice-select.min.js') ?>"></script>
<script src="<?= asset('public/app/js/owl.carousel.min.js') ?>"></script>
<script src="<?= asset('public/app/js/mail-script.js') ?>"></script>
<script src="<?= asset('public/app/js/main.js') ?>"></script>
</body>

</html>