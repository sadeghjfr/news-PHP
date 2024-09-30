<?php require_once(BASE_PATH . '/template/app/layouts/header.php') ?>


<div class="site-main-container">

    <!-- Start latest-post Area -->
    <section class="latest-post-area pb-120">
        <div class="container no-padding">
            <div class="row">
                <div class="col-lg-8 post-list">
                    <!-- Start single-post Area -->
                    <div class="single-post-wrap">
                        <div class="feature-img-thumb relative">
                            <div class="overlay overlay-bg"></div>
                            <img class="img-fluid" src="<?= asset($post['image']) ?>" alt="">
                        </div>
                        <div class="content-wrap">
                            <ul class="tags mt-10">
                                <li><a href="<?= url('show-category')."/".$post['cat_id'] ?>"><?= $post['category'] ?></a></li>
                            </ul>
                            <a href="#">
                                <h3><?= $post['title'] ?></h3>
                            </a>
                            <ul class="meta pb-20">
                                <li><a href="#"><span class="lnr lnr-user"></span><?= $post['username'] ?></a></li>
                                <li><a href="#"><?= jalaliDate($post['username']) ?><span class="lnr lnr-calendar-full"></span></a></li>
                                <li><a href="#"><?= $post['comments_count'] ?><span class="lnr lnr-bubble"></span></a></li>
                            </ul>

                            <?= $post['body'] ?>







                            <div class="navigation-wrap justify-content-between d-flex">
                                <a class="prev" href="#"><span class="lnr lnr-arrow-right"></span>خبر بعدی</a>
                                <a class="next" href="#">خبر قبلی<span class="lnr lnr-arrow-left"></span></a>
                            </div>




                            <div class="comment-sec-area">
                                <div class="container">
                                    <div class="row flex-column">
                                        <h6>نظرات</h6>
                                        <?php foreach ($comments as $comment){ ?>
                                        <div class="comment-list">
                                            <div class="single-comment justify-content-between d-flex">
                                                <div class="user justify-content-between d-flex">

                                                    <div class="desc">
                                                        <h5><a href="#"><?=$comment['username']?></a></h5>
                                                        <p class="date mt-3"><?=jalaliDate($comment['username'])?></p>
                                                        <p class="comment">
                                                            <?=$comment['comment']?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>




                        </div>

                        <?php if (isset($_SESSION['user'])){ ?>
                        <div class="comment-form">
                            <h4>درج نظر جدید</h4>
                            <form action="<?=url('comment-store')."/".$post['id']?>" method="POST">
                                <div class="form-group">
                                    <textarea class="form-control mb-10" rows="5" name="comment" placeholder="متن نظر"
                                              onfocus="this.placeholder = ''" onblur="this.placeholder = 'متن نظر'"
                                              required=""></textarea>
                                </div>
                                <button type="submit" class="primary-btn text-uppercase">ارسال</button>
                            </form>
                        </div>
                        <?php } else{?>

                        <p>برای درج نظر وارد حساب کاربری خود شوید</p>
                        <a class="btn btn-success" href="<?=url('login')?>">ورود</a>
                        <a class="btn btn-info" href="<?=url('register')?>">ثبت نام</a>

                        <?php } ?>



                    </div>
                    <!-- End single-post Area -->
                </div>
                <?php require_once(BASE_PATH . '/template/app/layouts/sidebar.php') ?>
            </div>
        </div>
    </section>
    <!-- End latest-post Area -->
</div>

<?php require_once(BASE_PATH . '/template/app/layouts/footer.php') ?>
