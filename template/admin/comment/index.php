<?php require_once(BASE_PATH . '/template/admin/layouts/header.php'); ?>


<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h5"><i class="fas fa-newspaper"></i> Comments</h1>
    <!--<div class="btn-toolbar mb-2 mb-md-0">
        <a role="button" href="#" class="btn btn-sm btn-success disabled">create</a>
    </div>-->
</div>
<section class="table-responsive">
    <table class="table table-striped table-sm">
        <caption>List of comments</caption>
        <thead>
        <tr>
            <th>#</th>
            <th>user</th>
            <th>post</th>
            <th>comment</th>
            <th>status</th>
            <th>setting</th>
        </tr>
        </thead>
        <tbody>

        <?php foreach ($comments as $comment){ ?>
        <tr>
            <td><a href=""><?= $comment['id'] ?></a></td>
            <td>
                <?= $comment['user'] ?>
            </td>
            <td>
                <?= substr($comment['post'],0,50)."..." ?>
            </td>
            <td>
                <?= substr($comment['comment'],0,150)."..." ?>
            </td>
            <td>
                <?= $comment['status'] ?>
            </td>
            <td>

                <a role="button" class="btn btn-sm text-black-200 <?php if($comment['status'] == 'unseen'){echo 'btn-warning';}
                elseif ($comment['status'] == 'seen'){echo 'btn-success';}else{echo 'btn-info';} ?>"
                    href="<?=url('admin/comment/status')."/".$comment['id']?>">

                     <?php if($comment['status'] == 'unseen'){echo 'دیدم';}
                elseif ($comment['status'] == 'seen'){echo 'تایید';}else{echo 'مخفی کردن';} ?></a>

                <a role="button" class="btn btn-sm btn-light text-black-100" href="<?= url('admin/comment/show')."/".$comment['id'] ?>">Show</a>
            </td>
        </tr>

        <?php } ?>

        </tbody>
    </table>
</section>

<?php require_once(BASE_PATH . '/template/admin/layouts/footer.php') ?>
