<?php

namespace admin;
use database\Database;

class Banner extends Admin {

    public function index(){

        $db = new Database();
        $sql = "SELECT * FROM banners;";

        $banners = $db->select($sql)->fetchAll();
        require_once (BASE_PATH . '/template/admin/banner/index.php');
    }

    public function create(){

        $db = new Database();
        require_once (BASE_PATH . '/template/admin/banner/create.php');
    }

    public function store($request){

        $db = new Database();
        $image = $this->saveImage($request['image'], 'banners');
        $request['image'] = $image;

        if ($request['image']){

            $db->insert("banners", array_keys($request), $request);
            $this->redirect('admin/banner');
        }

        else
            $this->redirect('admin/banner');
    }

    public function edit($id){

        $db = new Database();
        $sql = "SELECT * FROM banners WHERE id = ?;";
        $banner = $db->select($sql, [intval($id)])->fetch();
        require_once (BASE_PATH . '/template/admin/banner/edit.php');
    }

    public function update($request, $id){


        $db = new Database();

        if ($request['image']['tmp_name'] != null){

            $sql = "SELECT * FROM banners WHERE id = ?;";
            $banner = $db->select($sql, [intval($id)])->fetch();
            $this->removeImage($banner['image']);
            $request['image'] = $this->saveImage($request['image'], 'banners');
        }

        else
            unset($request['image']);

        $db->update("banners",$id, array_keys($request), $request);
        $this->redirect('admin/banner');
    }

    public function delete($id){

        $db = new Database();
        $sql = "SELECT * FROM banners WHERE id = ?;";
        $banner = $db->select($sql, [intval($id)])->fetch();
        $this->removeImage($banner['image']);

        $db->delete('banners', $id);
        $this->redirectBack();
    }

}
