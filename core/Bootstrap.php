<?php

namespace Core;

use Buki\Router\Router;
use Carbon\Carbon;
use Illuminate\Database\Capsule\Manager as Capsule;
use Valitron\Validator;
use Arrilot\DotEnv\DotEnv;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;
use PDO;

class Bootstrap
{

    public $router;
    public $view;
    public $validator;
    public $db;

    public function __construct()
    {

        DotEnv::load(dirname(__DIR__) . '/.env.php');

        $whoops = new Run();
        $whoops->pushHandler(new PrettyPageHandler());

        if (config('DEVELOPMENT')) {
            $whoops->register();
        }

        Carbon::setLocale(config('LOCALE', 'tr_TR'));

        try {
            $this->db = new PDO("mysql:host=localhost;dbname=blog", "root", "");
        } catch ( PDOException $e ){
            print $e->getMessage();
        }

        // Tablo Kontrolü

        // Kullanıcılar Tablosunu Oluştur
        $this->db->exec("
            CREATE TABLE IF NOT EXISTS users (
              `id` int(11) AUTO_INCREMENT PRIMARY KEY,
              `name` varchar(255) NOT NULL,
              `username` varchar(255) NOT NULL,
              `email` varchar(255) NOT NULL,
              `bio` text NOT NULL,
              `password` varchar(255) NOT NULL,
              `isAdmin` int(11) NOT NULL DEFAULT 0,
              `created_at` timestamp NULL DEFAULT current_timestamp(),
              `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
            ) 
        ");

        // Göderiler Tablosunu Oluştur
        $this->db->exec("
            CREATE TABLE IF NOT EXISTS posts (
              `id` int(11) AUTO_INCREMENT PRIMARY KEY,
              `postTitle` varchar(255) NOT NULL,
              `postContent` text NOT NULL,
              `postTags` varchar(255) NOT NULL,
              `postCategory` int(11) NOT NULL,
              `postAuthor` int(11) NOT NULL,
              `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
              `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
            ) 
        ");

        // Kategoriler Tablosunu Oluştur
        $this->db->exec("
            CREATE TABLE IF NOT EXISTS categories (
              `id` int(11) AUTO_INCREMENT PRIMARY KEY,
              `categoryName` varchar(255) NOT NULL,
              `categoryDesc` text NOT NULL,
              `categoryAuthor` int(11) NOT NULL,
              `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
              `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
            ) 
        ");


        $this->router = new Router([
            'paths' => [
                'controllers' => 'app/controllers',
                'middlewares' => 'app/middlewares'
            ],
            'namespaces' => [
                'controllers' => 'App\Controllers',
                'middlewares' => 'App\Middlewares'
            ],
            'debug' => true,
        ]);
        $this->validator = new Validator($_POST);
        Validator::langDir(dirname(__DIR__) . '/public/validator_lang');
        Validator::lang('tr');
        $this->view = new View($this->validator);
    }

    public function run()
    {
        $this->router->run();
    }

}