<?php require_once(BASE_PATH . '/template/admin/layouts/header.php'); ?>


<section class="pt-3 pb-1 mb-2 border-bottom">
    <h1 class="h5">Show Comment</h1>
</section>
<section class="row my-3">
    <section class="col-12">
        <h1 class="h4 border-bottom"><?= $comment['id'] ?></h1>
        <p class="text-secondary border-bottom"><?= $comment['user'] ?></p>
        <p class="text-secondary border-bottom"><?= $comment['post'] ?></p>
        <p class="text-secondary border-bottom"><?= $comment['comment'] ?></p>
        <p class="text-secondary border-bottom"><?= $comment['status'] ?></p>
        <p class="text-secondary border-bottom"><?= jalaliDate($comment['created_at']) ?></p>

        <a role="button" class="btn btn-sm text-black-200 <?php if($comment['status'] == 'unseen'){echo 'btn-warning';}
        elseif ($comment['status'] == 'seen'){echo 'btn-success';}else{echo 'btn-info';} ?>"
           href="<?=url('admin/comment/status')."/".$comment['id']?>">

            <?php if($comment['status'] == 'unseen'){echo 'دیدم';}
            elseif ($comment['status'] == 'seen'){echo 'تایید';}else{echo 'مخفی کردن';} ?></a>

    </section>
</section>


<?php require_once(BASE_PATH . '/template/admin/layouts/footer.php') ?>
