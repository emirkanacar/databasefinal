<?php

namespace App\Controllers;

use Carbon\Carbon;
use Core\Controller;
use Illuminate\Database\Capsule\Manager;
use Symfony\Component\HttpFoundation\Request;
use PDO;

class Home extends Controller
{
    public function main(Request $request)
    {
        $query = $this->db->prepare('SELECT * FROM posts ORDER BY id desc LIMIT 5');
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

        return $this->view('home', [ 'posts' => $rows ]);
    }

}