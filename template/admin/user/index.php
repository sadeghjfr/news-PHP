<?php require_once(BASE_PATH . '/template/admin/layouts/header.php'); ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h5"><i class="fas fa-newspaper"></i> Users</h1>
       <!-- <div class="btn-toolbar mb-2 mb-md-0">
            <a role="button" href="#" class="btn btn-sm btn-success disabled">create</a>
        </div>-->
    </div>
    <section class="table-responsive">
        <table class="table table-striped table-sm">
            <caption>List of users</caption>
            <thead>
                <tr>
                    <th>#</th>
                    <th>username</th>
                    <th>email</th>
                    <!--<th>password</th>-->
                    <th>permission</th>
                    <th>created at</th>
                    <th>setting</th>
                </tr>
            </thead>
            <tbody>


            <?php foreach ($users as $user){ ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><?= $user['username'] ?></td>
                    <td><?= $user['email'] ?></td>
                    <!--<td>s</td>-->
                    <td><?= $user['permission'] ?></td>
                    <td><?= $user['created_at'] ?></td>
                    <td>

                        <a role="button" class="btn btn-sm text-black-50 <?= ($user['permission'] === 'user')? 'btn-warning' : 'btn-success' ?>"
                           href="<?=url('admin/user/permission')."/".$user['id']?>">
                            <?= ($user['permission'] === 'user')? 'click to be admin' : 'click not to be admin' ?></a>

                <!--<a role="button" class="btn btn-sm btn-success text-white" href="">click to be admin</a>
                <a role="button" class="btn btn-sm btn-warning text-white" href="">click not to be admin</a>-->
             

                <a role="button" class="btn btn-sm btn-primary text-white" href="<?=url('admin/user/edit')."/".$user['id']?>">edit</a>
                <!--<a role="button" class="btn btn-sm btn-danger text-white" href="">delete</a>-->
                </td>
                </tr> <?php } ?>
                </tbody>
                </table>
                </section>
            
<?php require_once (BASE_PATH . '/template/admin/layouts/footer.php') ?>
