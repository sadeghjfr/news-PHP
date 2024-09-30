<?php

namespace app;

use database\Database;

class Home{

    public function index(){

        $db = new Database();

        $sql = "SELECT * FROM settings;";
        $setting = $db->select($sql)->fetch();

        $sql = "SELECT * FROM menus WHERE parent_id IS NULL;";
        $menus = $db->select($sql)->fetchAll();

        $sql = "SELECT news.*, 
                  (SELECT users.username FROM users WHERE users.id=news.user_id) AS username, 
                  (SELECT COUNT(*) FROM comments WHERE comments.news_id=news.id) AS comments_count,
                  (SELECT categories.name FROM categories WHERE categories.id=news.cat_id) AS category 
                FROM news WHERE news.selected=1 ORDER BY news.created_at DESC LIMIT 0,3;";

        $topSelectedPosts = $db->select($sql)->fetchAll();

        $sql = "SELECT * FROM news WHERE breaking_news = 1 ORDER BY created_at DESC LIMIT 0,1;";
        $breakingNews = $db->select($sql)->fetch();

        $sql = "SELECT news.*, 
                  (SELECT users.username FROM users WHERE users.id=news.user_id) AS username, 
                  (SELECT COUNT(*) FROM comments WHERE comments.news_id=news.id) AS comments_count,
                  (SELECT categories.name FROM categories WHERE categories.id=news.cat_id) AS category 
                FROM news ORDER BY news.created_at DESC LIMIT 0,6;";

        $lastNews = $db->select($sql)->fetchAll();

        $sql = "SELECT * FROM banners LIMIT 0,1;";
        $banner = $db->select($sql)->fetch();

        $sql = "SELECT news.*, 
                  (SELECT users.username FROM users WHERE users.id=news.user_id) AS username, 
                  (SELECT COUNT(*) FROM comments WHERE comments.news_id=news.id) AS comments_count,
                  (SELECT categories.name FROM categories WHERE categories.id=news.cat_id) AS category 
                FROM news ORDER BY news.view DESC LIMIT 0,3;";

        $popularNews = $db->select($sql)->fetchAll();

        $sql = "SELECT news.*, (SELECT COUNT(*) FROM comments WHERE comments.news_id=news.id) AS comments_count 
                FROM news ORDER BY comments_count DESC LIMIT 0,6;";

        $mostCommentNews = $db->select($sql)->fetchAll();

        require_once (BASE_PATH . '/template/app/index.php');
    }

    public function show($id){

        $db = new Database();

        $sql = "SELECT * FROM settings;";
        $setting = $db->select($sql)->fetch();

        $sql = "SELECT * FROM menus WHERE parent_id IS NULL;";
        $menus = $db->select($sql)->fetchAll();

        $sql = "SELECT news.*, 
                  (SELECT users.username FROM users WHERE users.id=news.user_id) AS username, 
                  (SELECT COUNT(*) FROM comments WHERE comments.news_id=news.id) AS comments_count,
                  (SELECT categories.name FROM categories WHERE categories.id=news.cat_id) AS category 
                FROM news ORDER BY news.view DESC LIMIT 0,3;";

        $popularNews = $db->select($sql)->fetchAll();

        $sql = "SELECT news.*, (SELECT COUNT(*) FROM comments WHERE comments.news_id=news.id) AS comments_count 
                FROM news ORDER BY comments_count DESC LIMIT 0,6;";

        $mostCommentNews = $db->select($sql)->fetchAll();

        $sql = "SELECT news.*, 
                    (SELECT users.username FROM users WHERE users.id=news.user_id) AS username, 
                    (SELECT COUNT(*) FROM comments WHERE comments.news_id=news.id) AS comments_count,
                    (SELECT categories.name FROM categories WHERE categories.id=news.cat_id) AS category 
                FROM news WHERE news.id = ?;";

        $post = $db->select($sql, [$id])->fetch();

        if (empty($post)) {
            $this->redirect("/");
        }

        $sql = "SELECT *, 
                    (SELECT users.username FROM users WHERE users.id=comments.user_id) AS username 
                    FROM comments WHERE comments.news_id = ? AND comments.status = 'approved' ORDER BY created_at DESC ;";

        $comments = $db->select($sql, [$id])->fetchAll();

        require_once (BASE_PATH . '/template/app/show-post.php');
    }

    public function category($id){

        $db = new Database();

        $sql = "SELECT * FROM settings;";
        $setting = $db->select($sql)->fetch();

        $sql = "SELECT * FROM menus WHERE parent_id IS NULL;";
        $menus = $db->select($sql)->fetchAll();

        $sql = "SELECT news.*, 
                  (SELECT users.username FROM users WHERE users.id=news.user_id) AS username, 
                  (SELECT COUNT(*) FROM comments WHERE comments.news_id=news.id) AS comments_count,
                  (SELECT categories.name FROM categories WHERE categories.id=news.cat_id) AS category 
                FROM news ORDER BY news.view DESC LIMIT 0,3;";
        $popularNews = $db->select($sql)->fetchAll();

        $sql = "SELECT news.*, (SELECT COUNT(*) FROM comments WHERE comments.news_id=news.id) AS comments_count 
                FROM news ORDER BY comments_count DESC LIMIT 0,6;";
        $mostCommentNews = $db->select($sql)->fetchAll();


        $sql = "SELECT * FROM news WHERE breaking_news = 1 AND cat_id = ? ORDER BY created_at DESC LIMIT 0,1;";
        $breakingNews = $db->select($sql, [$id])->fetch();

        $sql = "SELECT * FROM banners LIMIT 0,1;";
        $banner = $db->select($sql)->fetch();

        $sql = "SELECT news.*, 
                  (SELECT users.username FROM users WHERE users.id=news.user_id) AS username, 
                  (SELECT COUNT(*) FROM comments WHERE comments.news_id=news.id) AS comments_count,
                  (SELECT categories.name FROM categories WHERE categories.id=news.cat_id) AS category 
                FROM news WHERE news.cat_id=? ORDER BY news.created_at DESC LIMIT 0,6;";

        $lastNews = $db->select($sql,[$id])->fetchAll();

        if (!empty($lastNews))
            require_once (BASE_PATH . '/template/app/category.php');

        else
            $this->redirect("/");

    }

    public function commentStore($request, $id){


        if (isset($_SESSION['user']) && $_SESSION['user'] != null){

            $db = new Database();

            $request['user_id'] = $_SESSION['user'];
            $request['news_id'] = $id;

            $db->insert('comments', array_keys($request), $request);
            $this->redirectBack();
        }

        else
            $this->redirectBack();

    }

    protected function redirectBack(){

        header("Location:" . $_SERVER["HTTP_REFERER"]);
        exit();
    }

    protected function redirect($url){

        header("Location:".trim(CURRENT_DOMAIN,"/")."/".trim($url,"/"));
        exit();
    }

}








