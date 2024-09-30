<?php require_once(BASE_PATH . '/template/app/layouts/header.php') ?>


<div class="site-main-container">
    <!-- Start top-post Area -->
    <section class="top-post-area pt-10">
        <div class="container no-padding">
            <div class="row">
                <div class="col-lg-12">
                    <div class="hero-nav-area">
                        <h1 class="text-white"><?php if (isset($lastNews[0])){ echo $lastNews[0]['category']; } ?></h1>

                    </div>
                </div>

                <?php if (!empty($breakingNews)){ ?>
                    <div class="col-lg-12">
                        <div class="news-tracker-wrap">
                            <h6><span>خبر فوری:</span> <a href="<?= url('show-post')."/".$breakingNews['id'] ?>"><?= $breakingNews['title'] ?></a></h6>
                        </div>
                    </div>
                <?php } ?>

            </div>
        </div>
    </section>
    <!-- End top-post Area -->
    <!-- Start latest-post Area -->
    <section class="latest-post-area pb-120">
        <div class="container no-padding">
            <div class="row">
                <div class="col-lg-8 post-list">



                    <!-- Start latest-post Area -->
                    <div class="latest-post-wrap">
                        <h4 class="cat-title">آخرین اخبار</h4>

                        <?php foreach ($lastNews as $news) { ?>

                            <div class="single-latest-post row align-items-center">
                                <div class="col-lg-5 post-left">
                                    <div class="feature-img relative">
                                        <div class="overlay overlay-bg"></div>
                                        <img class="img-fluid" src="<?= asset($news['image']) ?>" alt="">
                                    </div>
                                    <ul class="tags">
                                        <li><a href="#"><?= $news['category'] ?></a></li>
                                    </ul>
                                </div>
                                <div class="col-lg-7 post-right">
                                    <a href="<?= url('show-post')."/".$news['id'] ?>">
                                        <h4><?= $news['title'] ?></h4>
                                    </a>
                                    <ul class="meta">
                                        <li><a href="#"><span class="lnr lnr-user"></span><?= $news['username'] ?></a></li>
                                        <li><a href="#"><?= jalaliDate($news['created_at']) ?><span class="lnr lnr-calendar-full"></span></a></li>
                                        <li><a href="#"> <?= $news['comments_count'] ?><span class="lnr lnr-bubble"></span></a></li>
                                    </ul>
                                    <p class="excert">
                                        <?= $news['summary'] ?>
                                    </p>
                                </div>
                            </div>

                        <?php } ?>

                    </div>
                    <!-- End latest-post Area -->


                    <!-- Start banner-ads Area -->
                    <?php if (!empty($banner)) { ?>
                        <div class="col-lg-12 ad-widget-wrap mt-30 mb-30">
                            <a href="<?=$banner['url']?>" ><img class="img-fluid" src="<?=asset($banner['image'])?>" alt=""></a>
                        </div>
                    <?php } ?>
                    <!-- End banner-ads Area -->



                    <!-- Start popular-post Area -->
                    <div class="popular-post-wrap">
                        <h4 class="title">اخبار پربازدید</h4>

                        <?php if (isset($popularNews[0])){ ?>
                            <div class="feature-post relative">
                                <div class="feature-img relative">
                                    <div class="overlay overlay-bg"></div>
                                    <img class="img-fluid" src="<?= asset($popularNews[0]['image']) ?>" alt="">
                                </div>
                                <div class="details">
                                    <ul class="tags">
                                        <li><a href="#"><?= $popularNews[0]['category'] ?></a></li>
                                    </ul>
                                    <a href="<?= url('show-post')."/".$popularNews[0]['id'] ?>">
                                        <h3><?= $popularNews[0]['title'] ?></h3>
                                    </a>
                                    <ul class="meta">
                                        <li><a href="#"><span class="lnr lnr-user"></span><?= $popularNews[0]['username'] ?></a></li>
                                        <li><a href="#"><?= jalaliDate($popularNews[0]['created_at']) ?><span class="lnr lnr-calendar-full"></span></a></li>
                                        <li><a href="#"><?= $popularNews[0]['comments_count'] ?><span class="lnr lnr-bubble"></span></a></li>
                                    </ul>
                                </div>
                            </div>
                        <?php } ?>


                        <div class="row mt-20 medium-gutters">

                            <?php if (isset($popularNews[1])){ ?>
                                <div class="col-lg-6 single-popular-post">
                                    <div class="feature-img-wrap relative">
                                        <div class="feature-img relative">
                                            <div class="overlay overlay-bg"></div>
                                            <img class="img-fluid" src="<?= asset($popularNews[1]['image']) ?>" alt="">
                                        </div>
                                        <ul class="tags">
                                            <li><a href="#"><?= $popularNews[1]['category'] ?></a></li>
                                        </ul>
                                    </div>
                                    <div class="details">
                                        <a href="<?= url('show-post')."/".$popularNews[1]['id'] ?>">
                                            <h4><?= $popularNews[1]['title'] ?></h4>
                                        </a>
                                        <ul class="meta">
                                            <li><a href="#"><span class="lnr lnr-user"></span><?= $popularNews[1]['username'] ?></a></li>
                                            <li><a href="#"><?= jalaliDate($popularNews[1]['created_at']) ?><span class="lnr lnr-calendar-full"></span></a></li>
                                            <li><a href="#"> <?= $popularNews[1]['comments_count'] ?><span class="lnr lnr-bubble"></span></a></li>
                                        </ul>

                                    </div>
                                </div>
                            <?php } ?>

                            <?php if (isset($popularNews[2])){ ?>
                                <div class="col-lg-6 single-popular-post">
                                    <div class="feature-img-wrap relative">
                                        <div class="feature-img relative">
                                            <div class="overlay overlay-bg"></div>
                                            <img class="img-fluid" src="<?= asset($popularNews[2]['image']) ?>" alt="">
                                        </div>
                                        <ul class="tags">
                                            <li><a href="#"><?= $popularNews[2]['category'] ?></a></li>
                                        </ul>
                                    </div>
                                    <div class="details">
                                        <a href="<?= url('show-post')."/".$popularNews[2]['id'] ?>">
                                            <h4><?= $popularNews[2]['title'] ?></h4>
                                        </a>
                                        <ul class="meta">
                                            <li><a href="#"><span class="lnr lnr-user"></span><?= $popularNews[2]['username'] ?></a></li>
                                            <li><a href="#"><?= jalaliDate($popularNews[2]['created_at']) ?><span class="lnr lnr-calendar-full"></span></a></li>
                                            <li><a href="#"><?= $popularNews[2]['comments_count'] ?><span class="lnr lnr-bubble"></span></a></li>
                                        </ul>

                                    </div>
                                </div>
                            <?php } ?>

                        </div>
                    </div>
                    <!-- End popular-post Area -->



                </div>
                <?php require_once(BASE_PATH . '/template/app/layouts/sidebar.php') ?>
            </div>
        </div>
    </section>
    <!-- End latest-post Area -->
</div>

<?php require_once(BASE_PATH . '/template/app/layouts/footer.php') ?>
