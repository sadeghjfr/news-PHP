<?php

namespace admin;

use database\Database;

class User extends Admin
{

    public function index()
    {

        $db = new Database();
        $sql = "SELECT * FROM users;";

        $users = $db->select($sql)->fetchAll();
        require_once(BASE_PATH . '/template/admin/user/index.php');
    }

    public function edit($id)
    {

        $db = new Database();
        $sql = "SELECT * FROM users WHERE id = ?;";
        $user = $db->select($sql, [intval($id)])->fetch();
        require_once(BASE_PATH . '/template/admin/user/edit.php');
    }

    public function update($request, $id)
    {

        $db = new Database();
        $request = ['username' => $request['username'], 'permission' => $request['permission']];
        $db->update("users", $id, array_keys($request), $request);
        $this->redirect('admin/user');
    }

    public function permission($id)
    {

        $db = new Database();

        $sql = "SELECT * FROM users WHERE id = ?;";
        $user = $db->select($sql, [intval($id)])->fetch();
        $permission = $user['permission'] === 'user' ? 'admin' : 'user';
        $db->update("users", $id, ['permission'], [$permission]);

        $this->redirectBack();
    }

}