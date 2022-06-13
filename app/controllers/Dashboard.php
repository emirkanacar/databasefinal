<?php

namespace App\Controllers;

use Carbon\Carbon;
use Core\Controller;
use Illuminate\Database\Capsule\Manager;
use Symfony\Component\HttpFoundation\Request;
use PDO;

class Dashboard extends Controller
{

    public function main(Request $request)
    {
        if(isset($_SESSION["isAuth"]) && $_SESSION["isAuth"] === true && $_SESSION["auth"]["isAdmin"] == 1) {

            $postsCount = count($this->db->query("CALL getPosts")->fetchAll(PDO::FETCH_ASSOC));
            $usersCount = count($this->db->query("CALL getUsers")->fetchAll(PDO::FETCH_ASSOC));
            $categoriesCount = count($this->db->query("CALL getCategories")->fetchAll(PDO::FETCH_ASSOC));

            return $this->view('dashboard/home', [ "postCount" => $postsCount, "userCount" => $usersCount, "categoriesCount" => $categoriesCount ]);
        }else {
            header("Location: /");
        }
    }

    public function posts(Request $request)
    {
        if(isset($_SESSION["isAuth"]) && $_SESSION["isAuth"] === true && $_SESSION["auth"]["isAdmin"] == 1) {

            $posts = $this->db->query("CALL getPosts")->fetchAll(PDO::FETCH_ASSOC);


            return $this->view('dashboard/posts', [ "posts" => $posts ]);
        }else {
            header("Location: /");
        }
    }

    public function deletePost(Request $request, $id) {
        if(isset($_SESSION["isAuth"]) && $_SESSION["isAuth"] === true && $_SESSION["auth"]["isAdmin"] == 1) {

            $message = [
                "error" => true,
                "message" => null
            ];

            $posts = $this->db->query("CALL getPosts")->fetchAll(PDO::FETCH_ASSOC);

            $deletePost = $this->db->prepare("CALL deletePostById(:id)");
            $deletePost->bindParam(":id", $id,PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT, 4000);
            $deletePost->execute();

            if($deletePost->execute()) {
                $message["error"] = false;
                $message["message"] = "Gönderi başarıyla silindi!";
            }else {
                $message["error"] = true;
                $message["message"] = "Gönderi silinirken hata oluştu!";
            }

            return $this->view('dashboard/posts', [ "posts" => $posts, "message" => $message ]);
        }else {
            header("Location: /");
        }
    }

    public function editPost(Request $request, $id) {
        if(isset($_SESSION["isAuth"]) && $_SESSION["isAuth"] === true && $_SESSION["auth"]["isAdmin"] == 1) {

            $postDetails = $this->db->prepare("CALL getPostById(:id)");
            $postDetails->bindParam(":id", $id,PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT, 4000);
            $postDetails->execute();

            $fetch = $postDetails->fetch();

            $postDetails->closeCursor();

            $categories = $this->db->query("CALL getCategories")->fetchAll(PDO::FETCH_ASSOC);

            if($fetch) {
                return $this->view('dashboard/editPost', [ "postDetails" => $fetch, "categories" => $categories ]);

            }else {
                header("Location: /panel/gonderiler" );

            }
        }else {
            header("Location: /");
        }
    }

    public function editPostForm(Request $request) {
        if($request->isMethod('POST'))
        {
            $this->validator->rule('required', ['postTitle', 'postContent', 'postTags', 'postCategory', 'id']);

            if ($this->validator->validate()) {
                $message = [
                    "error" => true,
                    "message" => null
                ];

                $posts = $this->db->query("CALL getPosts")->fetchAll(PDO::FETCH_ASSOC);


                $query = $this->db->prepare('call updatePostById(:id, :title, :tags, :content, :category)');
                $query->bindParam(":title", $this->validator->data()["postTitle"], PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT, 4000);
                $query->bindParam(":content", $this->validator->data()["postContent"], PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT, 4000);
                $query->bindParam(":tags", $this->validator->data()["postTags"], PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT, 4000);
                $query->bindParam(":category", $this->validator->data()["postCategory"], PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT, 4000);
                $query->bindParam(":id", $this->validator->data()["id"], PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT, 4000);
                $query->execute();

                if($query->rowCount() > 0) {
                    $message["error"] = false;
                    $message["message"] = "Gönderi başarıyla düzenlend,!";
                }else {
                    $message["error"] = true;
                    $message["message"] = "Gönderi düzenlenirken hata oluştu!";
                }

                return $this->view('dashboard/posts', [ "posts" => $posts, "message" => $message ]);
            }
        }else {
            return 'Geçersiz istek!';
        }
    }

    public function addPost(Request $request)
    {
        $categories = $this->db->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);

        return $this->view('dashboard/postAdd', [ "categories" => $categories ]);
    }

    public function addPostForm(Request $request) {
        if($request->isMethod('POST'))
        {
            $this->validator->rule('required', ['postTitle', 'postContent', 'postTags', 'postCategory']);

            if ($this->validator->validate()) {
                $message = [
                    "error" => true,
                    "message" => null
                ];

                $posts = $this->db->query("CALL getPosts")->fetchAll(PDO::FETCH_ASSOC);

                $insertQuery = $this->db->prepare("call addPost(:title, :content, :tags, :category, :author)");
                $insertQuery->bindParam(":title", $this->validator->data()["postTitle"], PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT, 4000);
                $insertQuery->bindParam(":content", $this->validator->data()["postContent"], PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT, 4000);
                $insertQuery->bindParam(":tags", $this->validator->data()["postTags"], PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT, 4000);
                $insertQuery->bindParam(":category", $this->validator->data()["postCategory"], PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT, 4000);
                $insertQuery->bindParam(":author", $_SESSION["auth"]["id"], PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT, 4000);

                if($insertQuery->execute()) {
                    $message["error"] = false;
                    $message["message"] = "Gönderi başarıyla eklendi!";
                }else {
                    $message["error"] = true;
                    $message["message"] = "Gönderi eklenirken hata oluştu!";
                }

                return $this->view('dashboard/posts', [ "posts" => $posts, "message" => $message ]);
            }
        }else {
            return 'Geçersiz istek!';
        }
    }

    public function categories(Request $request)
    {
        if(isset($_SESSION["isAuth"]) && $_SESSION["isAuth"] === true && $_SESSION["auth"]["isAdmin"] == 1) {

            $categories = $this->db->query("CALL getCategories")->fetchAll(PDO::FETCH_ASSOC);

            return $this->view('dashboard/categories', [ "categories" => $categories ]);
        }else {
            header("Location: /");
        }
    }

    public function deleteCategory(Request $request, $id) {
        if(isset($_SESSION["isAuth"]) && $_SESSION["isAuth"] === true && $_SESSION["auth"]["isAdmin"] == 1) {

            $message = [
                "error" => true,
                "message" => null
            ];

            $categories = $this->db->query("CALL getCategories")->fetchAll(PDO::FETCH_ASSOC);

            $deletePost = $this->db->prepare("CALL deleteCategoryById(:id)");
            $deletePost->bindParam(":id", $id,PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT, 4000);
            $deletePost->execute();

            if($deletePost->execute()) {
                $message["error"] = false;
                $message["message"] = "Kategori başarıyla silindi!";
            }else {
                $message["error"] = true;
                $message["message"] = "Kategori silinirken hata oluştu!";
            }

            return $this->view('dashboard/categories', [ "categories" => $categories, "message" => $message ]);
        }else {
            header("Location: /");
        }
    }

    public function editCategory(Request $request, $id) {
        if(isset($_SESSION["isAuth"]) && $_SESSION["isAuth"] === true && $_SESSION["auth"]["isAdmin"] == 1) {

            $categoryDetails = $this->db->query("CALL getCategories")->fetch(PDO::FETCH_ASSOC);

            if($categoryDetails) {
                return $this->view('dashboard/editCategory', [ "categoryDetails" => $categoryDetails ]);

            }else {
                header("Location: /panel/gonderiler" );

            }
        }else {
            header("Location: /");
        }
    }

    public function editCategoryForm(Request $request) {
        if($request->isMethod('POST'))
        {
            $this->validator->rule('required', ['categoryTitle', 'categoryDesc', 'id']);

            if ($this->validator->validate()) {
                $message = [
                    "error" => true,
                    "message" => null
                ];

                $categories = $this->db->query("CALL getCategories")->fetchAll(PDO::FETCH_ASSOC);

                $query = $this->db->prepare('CALL updateCategoryById(:id, :name, :content)');
                $query->bindParam(":id", $this->validator->data()["id"], PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT, 4000);
                $query->bindParam(":name", $this->validator->data()["categoryTitle"], PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT, 4000);
                $query->bindParam(":content", $this->validator->data()["categoryDesc"], PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT, 4000);

                $query->execute();

                if($query->rowCount() > 0) {
                    $message["error"] = false;
                    $message["message"] = "Kategori başarıyla düzenlend,!";
                }else {
                    $message["error"] = true;
                    $message["message"] = "Kategori düzenlenirken hata oluştu!";
                }

                return $this->view('dashboard/categories', [ "categories" => $categories, "message" => $message ]);
            }
        }else {
            return 'Geçersiz istek!';
        }
    }

    public function addCategory(Request $request)
    {
        return $this->view('dashboard/categoryAdd');
    }

    public function addCategoryForm(Request $request) {
        if($request->isMethod('POST'))
        {
            $this->validator->rule('required', ['categoryTitle', 'categoryContent']);

            if ($this->validator->validate()) {
                $message = [
                    "error" => true,
                    "message" => null
                ];

                $categories = $this->db->query("CALL getCategories")->fetchAll(PDO::FETCH_ASSOC);

                $insertQuery = $this->db->prepare("CALL addCategory(:title, :desc, :author)");
                $insertQuery->bindParam(":title", $this->validator->data()["categoryTitle"], PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT, 4000);
                $insertQuery->bindParam(":desc", $this->validator->data()["categoryContent"], PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT, 4000);
                $insertQuery->bindParam(":author", $_SESSION["auth"]["id"], PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT, 4000);

                $insertQuery->execute();

                if($insertQuery) {
                    $message["error"] = false;
                    $message["message"] = "Kategori başarıyla eklendi!";
                }else {
                    $message["error"] = true;
                    $message["message"] = "Kategori eklenirken hata oluştu!";
                }

                return $this->view('dashboard/categories', [ "categories" => $categories, "message" => $message ]);
            }
        }else {
            return 'Geçersiz istek!';
        }
    }

}