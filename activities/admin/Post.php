<?php

namespace admin;
use database\Database;

class Post extends Admin {

    public function index(){

        $db = new Database();
        $sql = "SELECT news.*, users.username as user, categories.name as category FROM news
                LEFT JOIN users ON news.user_id=users.id LEFT JOIN categories ON news.cat_id=categories.id;";

        $posts = $db->select($sql)->fetchAll();
        require_once (BASE_PATH . '/template/admin/post/index.php');
    }

    public function create(){

        $db = new Database();
        $categories = $db->select("SELECT * FROM categories ORDER BY id ASC ;")->fetchAll();
        require_once (BASE_PATH . '/template/admin/post/create.php');
    }

    public function store($request){

        date_default_timezone_set('Iran');
        $timestamp = substr($request['published_at'], 0, 10);
        $request['published_at'] = date("Y-m-d H:i:s", (int) $timestamp);
        $db = new Database();

        if ($request['cat_id'] != null){

            $image = $this->saveImage($request['image'], 'post-images');
            $request['image'] = $image;

            if ($request['image']){

                $request['user_id'] = 1;
                $db->insert("news", array_keys($request), $request);
                $this->redirect('admin/post');
            }

            else
                $this->redirect('admin/post');
        }

        else
            $this->redirect('admin/post');
    }

    public function edit($id){

        $db = new Database();
        $sql = "SELECT * FROM news WHERE id = ?;";
        $post = $db->select($sql, [intval($id)])->fetch();
        $categories = $db->select("SELECT * FROM categories ORDER BY id ASC ;")->fetchAll();
        require_once (BASE_PATH . '/template/admin/post/edit.php');
    }

    public function update($request, $id){

        date_default_timezone_set('Iran');
        $timestamp = substr($request['published_at'], 0, 10);
        $request['published_at'] = date("Y-m-d H:i:s", (int) $timestamp);

        $db = new Database();

        if ($request['cat_id'] != null){

            if ($request['image']['tmp_name'] != null){

                $sql = "SELECT * FROM news WHERE id = ?;";
                $post = $db->select($sql, [intval($id)])->fetch();
                $this->removeImage($post['image']);
                $request['image'] = $this->saveImage($request['image'], 'post-images');
            }

            else
                unset($request['image']);

            $request['user_id'] = 1;
            $db->update("news",$id, array_keys($request), $request);
            $this->redirect('admin/post');
        }

        else
            $this->redirect('admin/post');

    }

    public function delete($id){

        $db = new Database();

        $sql = "SELECT * FROM news WHERE id = ?;";
        $post = $db->select($sql, [intval($id)])->fetch();
        $this->removeImage($post['image']);

        $db->delete('news', $id);
        $this->redirectBack();
    }

    public function selected($id){

        $db = new Database();

        $sql = "SELECT * FROM news WHERE id = ?;";
        $post = $db->select($sql, [intval($id)])->fetch();

        $selected = intval(!((bool)$post['selected']));
        $db->update("news",$id, ['selected'], [$selected]);

        $this->redirectBack();
    }

    public function breakingNews($id){

        $db = new Database();

        $sql = "SELECT * FROM news WHERE id = ?;";
        $post = $db->select($sql, [intval($id)])->fetch();

        $breaking= intval(!((bool)$post['breaking_news']));
        $db->update("news",$id, ['breaking_news'], [$breaking]);

        $this->redirectBack();
    }
}
