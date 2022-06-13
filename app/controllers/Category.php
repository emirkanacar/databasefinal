<?php

namespace App\Controllers;

use Carbon\Carbon;
use Core\Controller;
use Illuminate\Database\Capsule\Manager;
use Symfony\Component\HttpFoundation\Request;
use PDO;

class Category extends Controller
{

    public function main(Request $request, $slug, $id)
    {
        $categoryDetails = $this->db->prepare('SELECT * FROM categories WHERE id = :id');
        $categoryDetails->bindValue(':id', $id);
        $categoryDetails->execute();

        $categoryFetch = $categoryDetails->fetch(PDO::FETCH_ASSOC);

        if($categoryFetch) {
            $query = $this->db->prepare('SELECT * FROM posts WHERE postCategory = :id ORDER BY id desc LIMIT 200');
            $query->bindValue(":id", $id);
            $query->execute();

            $rows = $query->fetchAll(PDO::FETCH_ASSOC);

            for($i = 0; $i < count($rows); $i++)
            {
                $authorQuery = $this->db->prepare('SELECT * FROM users WHERE id = :id');
                $authorQuery->bindValue(":id", $rows[$i]["postAuthor"]);
                $authorQuery->execute();

                $fetch = $authorQuery->fetch(PDO::FETCH_ASSOC);
                $rows[$i]["postAuthor"] = $fetch;
            }
            return $this->view('categoryPosts', [ 'posts' => $rows, "slug" => $slug, 'categoryDetails' => $categoryFetch ]);
        }else {
            header('Location: /');
        }
    }

    public function allCategories(Request $request)
    {
        $query = $this->db->prepare('SELECT * FROM categories ORDER BY id desc LIMIT 100');
        $query->execute();

        $rows = $query->fetchAll(PDO::FETCH_ASSOC);

        return $this->view('categories', [ 'categories' => $rows ]);
    }

}