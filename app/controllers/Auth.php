<?php

namespace App\Controllers;

use Carbon\Carbon;
use Core\Controller;
use Illuminate\Database\Capsule\Manager;
use Symfony\Component\HttpFoundation\Request;
use PDO;

class Auth extends Controller
{
    public function login(Request $request)
    {
        return $this->view('auth/login');
    }

    public function loginPost(Request $request)
    {
        if($request->isMethod('POST'))
        {
            $this->validator->rule('required', ['username', 'password']);

            if ($this->validator->validate()) {
                $query = $this->db->prepare('SELECT * FROM users WHERE username = :username AND password = :password');
                $query->bindValue(":username", $this->validator->data()["username"]);
                $md5 = md5($this->validator->data()["password"]);
                $query->bindValue(":password", $md5);
                $query->execute();

                $fetch = $query->fetch(PDO::FETCH_ASSOC);

                if($fetch) {
                    session_start();

                    $_SESSION["isAuth"] = true;
                    $_SESSION["auth"]["name"] = $fetch["name"];
                    $_SESSION["auth"]["username"] = $fetch["username"];
                    $_SESSION["auth"]["id"] = $fetch["id"];
                    $_SESSION["auth"]["isAdmin"] = $fetch["isAdmin"];

                    header("Location: /");
                }else {
                    return 'Kullanıcı adı veya şifre yanlış!';
                }
            }
        }else {
            return 'Geçersiz istek!';
        }
    }

    public function register(Request $request)
    {
        return $this->view('auth/register');
    }

    public function registerPost(Request $request)
    {
        if($request->isMethod('POST'))
        {
            $this->validator->rule('required', ['name', 'email', 'username', 'password', 'passwordAgain', 'bio']);

            if ($this->validator->validate()) {
                $usernameQuery = $this->db->prepare('SELECT * FROM users WHERE username = :username');
                $usernameQuery->bindValue(":username", $this->validator->data()["username"]);
                $usernameQuery->execute();

                $usernameFetch = $usernameQuery->fetch(PDO::FETCH_ASSOC);

                if($usernameFetch)
                {
                    return "Kullanıcı adı kullanılıyor!";
                }

                $emailQuery = $this->db->prepare('SELECT * FROM users WHERE email = :email');
                $emailQuery->bindValue(":email", $this->validator->data()["email"]);
                $emailQuery->execute();

                $emailFetch = $emailQuery->fetch(PDO::FETCH_ASSOC);

                if($emailFetch)
                {
                    return "Email adresi kullanılıyor!";
                }

                if($this->validator->data()["password"] !== $this->validator->data()["passwordAgain"])
                {
                    return 'Şifreler eşleşmiyor!';
                }

                $insertQuery = $this->db->prepare("INSERT INTO users (username, name, email, bio, password) VALUES (?,?,?,?,?)");
                $insertQuery->execute([
                    $this->validator->data()["username"],
                    $this->validator->data()["name"],
                    $this->validator->data()["email"],
                    $this->validator->data()["bio"],
                    md5($this->validator->data()["password"])
                ]);

                if($insertQuery)
                {
                    session_start();

                    $_SESSION["isAuth"] = true;
                    $_SESSION["auth"]["name"] = $this->validator->data()["name"];
                    $_SESSION["auth"]["username"] = $this->validator->data()["username"];
                    $_SESSION["auth"]["id"] = $this->db->lastInsertId();
                    $_SESSION["auth"]["isAdmin"] = 0;

                    header("Location: /");
                }
            }
        }else {
            return 'Geçersiz istek!';
        }
    }

    public function logout(Request $request)
    {
        session_start();

        session_destroy();
        ob_clean();
        ob_flush();

        header("Location: /");
    }

}