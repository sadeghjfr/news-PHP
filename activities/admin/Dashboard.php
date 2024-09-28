<?php

namespace admin;
use database\Database;

class Dashboard extends Admin {

    public function index(){

        $db = new Database();
        $categoryCount = $db->select("SELECT COUNT(*) as count FROM categories ;")->fetch();

        $userCount = $db->select("SELECT COUNT(*) as count FROM users WHERE permission = 'user' ;")->fetch();
        $adminCount = $db->select("SELECT COUNT(*) as count FROM users WHERE permission = 'admin' ;")->fetch();

        $postCount = $db->select("SELECT COUNT(*) as count FROM news;")->fetch();
        $postsViews = $db->select("SELECT SUM(view) as view FROM news;")->fetch();

        $commentCount = $db->select("SELECT COUNT(*) as count FROM comments;")->fetch();
        $commentUnseenCount = $db->select("SELECT COUNT(*) as count FROM comments WHERE status = 'unseen' ;")->fetch();
        $commentApprovedCount = $db->select("SELECT COUNT(*) as count FROM comments WHERE status = 'approved' ;")->fetch();

        $mostViewedPosts = $db->select("SELECT * FROM news ORDER BY `view` DESC LIMIT 0, 5 ;")->fetchAll();

        $sql = "SELECT news.*, COUNT(comments.news_id) as commentCount FROM
                news LEFT JOIN comments ON news.id=comments.news_id GROUP BY news.id ORDER BY commentCount DESC LIMIT 0,5;";
        $mostCommentedPosts = $db->select($sql)->fetchAll();

        $sql = "SELECT comments.*, users.username as user FROM
                comments LEFT JOIN users ON comments.user_id=users.id ORDER BY created_at DESC LIMIT 0,5;";
        $lastComments = $db->select($sql)->fetchAll();

        require_once (BASE_PATH . '/template/admin/index.php');
    }

}
