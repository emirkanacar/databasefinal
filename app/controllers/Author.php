<?php

namespace App\Controllers;

use Carbon\Carbon;
use Core\Controller;
use Illuminate\Database\Capsule\Manager;
use Symfony\Component\HttpFoundation\Request;
use PDO;

class Author extends Controller
{

    public function getPosts(Request $request, $slug)
    {
        $getAuthor = $this->db->prepare('SELECT * FROM users WHERE username = :id');
        $getAuthor->bindValue(':id', $slug);
        $getAuthor->execute();

        $authorFetch = $getAuthor->fetch(PDO::FETCH_ASSOC);

        if($authorFetch) {
            $query = $this->db->prepare('SELECT * FROM posts WHERE postAuthor = :id ORDER BY id desc LIMIT 200');
            $query->bindValue(":id", $authorFetch["id"]);
            $query->execute();

            $rows = $query->fetchAll(PDO::FETCH_ASSOC);

            for($i = 0; $i < count($rows); $i++)
            {
                $rows[$i]["postAuthor"] = $authorFetch;
            }
            return $this->view('authorPosts', [ 'posts' => $rows, "author" => $authorFetch ]);
        }else {
            header('Location: /');
        }
    }
}