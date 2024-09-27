<?php

namespace admin;
use database\Database;

class Comment extends Admin {

    public function index(){

        $db = new Database();
        $sql = "SELECT comments.*, users.username as user, news.title as post FROM comments
                LEFT JOIN users ON comments.user_id=users.id LEFT JOIN news ON comments.news_id=news.id;";

        $comments = $db->select($sql)->fetchAll();
        require_once (BASE_PATH . '/template/admin/comment/index.php');
    }

    public function show($id){

        $db = new Database();
        $sql = "SELECT comments.*, users.username as user, news.title as post FROM comments
                LEFT JOIN users ON comments.user_id=users.id LEFT JOIN news ON comments.news_id=news.id HAVING id = ? ;";

        $comment = $db->select($sql, [intval($id)])->fetch();
        require_once (BASE_PATH . '/template/admin/comment/show.php');
    }


    public function status($id){

        $db = new Database();

        $sql = "SELECT * FROM comments WHERE id = ?;";
        $comment = $db->select($sql, [intval($id)])->fetch();

        $status = '';

        switch ($comment['status']){

            case 'unseen':
                $status = 'seen';
                break;
            case 'seen':
                $status = 'approved';
                break;
            case 'approved':
                $status = 'unseen';
                break;

        }

        $db->update("comments",$id, ['status'], [$status]);

        $this->redirectBack();
    }

}
