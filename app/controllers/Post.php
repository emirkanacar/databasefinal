<?php

namespace App\Controllers;

use Carbon\Carbon;
use Core\Controller;
use Illuminate\Database\Capsule\Manager;
use Symfony\Component\HttpFoundation\Request;
use PDO;

class Post extends Controller
{

    public function main(Request $request, $slug, $id)
    {
        $query = $this->db->prepare('SELECT * FROM posts WHERE id = :id');
        $query->bindValue(":id", $id);
        $query->execute();

        $fetch = $query->fetch(PDO::FETCH_ASSOC);

        $authorQuery = $this->db->prepare('SELECT * FROM users WHERE id = :id');
        $authorQuery->bindValue(":id", $fetch["postAuthor"]);
        $authorQuery->execute();

        $authorFetch = $authorQuery->fetch(PDO::FETCH_ASSOC);
        $fetch["postAuthor"] = $authorFetch;

        $categoryQuery = $this->db->prepare('SELECT * FROM categories WHERE id = :id');
        $categoryQuery->bindValue(":id", $fetch["postCategory"]);
        $categoryQuery->execute();

        $categoryFetch = $categoryQuery->fetch(PDO::FETCH_ASSOC);
        $fetch["categoryDetails"] = $categoryFetch;

        return $this->view('post', [ 'post' => $fetch, "slug" => $slug ]);
    }

    public function allPosts(Request $request)
    {
        $query = $this->db->prepare('SELECT * FROM posts ORDER BY id desc LIMIT 200');
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

        return $this->view('posts', [ 'posts' => $rows ]);
    }

}