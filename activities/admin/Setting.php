<?php

namespace admin;

use database\Database;

class Setting extends Admin
{

    public function index()
    {

        $db = new Database();
        $sql = "SELECT * FROM  settings;";
        $setting = $db->select($sql)->fetch();
        require_once(BASE_PATH . '/template/admin/setting/index.php');
    }

    public function edit()
    {

        $db = new Database();
        $sql = "SELECT * FROM  settings;";
        $setting = $db->select($sql)->fetch();
        require_once(BASE_PATH . '/template/admin/setting/set.php');
    }

    public function update($request)
    {

        $db = new Database();
        $sql = "SELECT * FROM settings;";
        $setting = $db->select($sql)->fetch();

        if ($request['logo']['tmp_name'] != null) {

            $this->removeImage($setting['logo']);
            $request['logo'] = $this->saveImage($request['logo'], 'setting', "logo");
        } else
            unset($request['logo']);

        if ($request['icon']['tmp_name'] != null) {

            $this->removeImage($setting['icon']);
            $request['icon'] = $this->saveImage($request['icon'], 'setting', "icon");
        } else
            unset($request['icon']);

        if (!empty($setting))
            $db->update("settings", $setting['id'], array_keys($request), $request);

        else
            $db->insert("settings", array_keys($request), $request);

        $this->redirect('admin/setting');

    }

}
