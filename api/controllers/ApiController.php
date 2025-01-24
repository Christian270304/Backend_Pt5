<?php
require_once 'api/models/UserModel.php';
require_once 'api/models/ArticlesModel.php';

class ApiController {
    

    public function getUser($id = null) {
        $userModel = new UserModel();
        header('Content-Type: application/json');
        if ($id) {
            http_response_code(200);
            $user = $userModel->getUserById($id);
            echo json_encode($user, JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(400);
            echo json_encode(['error' => "User ID not provided"]);
        }
    }

    public function getUsers() {
        $usersModel = new UserModel();
        $users = $usersModel->getUsers();
        
        header('Content-Type: application/json');
        
        if ($users) {
            http_response_code(200);
            echo json_encode($users, JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(404); 
            echo json_encode(['error' => "Users not found"]);
        }
    }

    public function getArticle($id = null) {
        $userModel = new ArticlesModel();
        header('Content-Type: application/json');
        if ($id) {
            http_response_code(200);
            $user = $userModel->getArticleById($id);
            echo json_encode($user, JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(400);
            echo json_encode(['error' => "Article ID not provided"]);
        }
    }

    public function getArticles() {
        $articlesModel = new ArticlesModel();
        $articles = $articlesModel->getArticles();
        
        header('Content-Type: application/json');
        
        if ($articles) {
            http_response_code(200);
            echo json_encode($articles, JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(404); 
            echo json_encode(['error' => "Articles not found"]);
        }
    }
}

?>