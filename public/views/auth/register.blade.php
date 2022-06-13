<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Blog - Kayıt Ol</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css" />
    <link href="{{ public_url('css/styles.css') }}" rel="stylesheet" />
</head>
<body>
<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-light" id="mainNav">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="/">Blog</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menü
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto py-4 py-lg-0">
                <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="/">Ana Sayfa</a></li>
                <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="/kategoriler">Kategoriler</a></li>
            </ul>
            <ul class="navbar-nav ms-auto py-4 py-lg-0">
                <?php
                if(isset($_SESSION["isAuth"]) && $_SESSION["isAuth"] === true) {
                    echo '<li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="/">' . $_SESSION["auth"]["name"] . '</a></li>';
                    if($_SESSION["auth"]["isAdmin"] == 1) {
                        echo '<li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="/panel/">Yönetim</a></li>';
                    }
                    echo '<li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="/auth/logout">Çıkış Yap</a></li>';
                }else {
                    echo '<li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="/auth/login">Giriş Yap</a></li>';
                    echo '<li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="/auth/register">Kayıt Ol</a></li>';
                }
                ?>
            </ul>
        </div>
    </div>
</nav>
<!-- Page Header-->
<header class="masthead">
    <div class="container position-relative px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7">
                <div class="site-heading">
                    <h1>Kayıt Ol</h1>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Main Content-->
<div class="container px-8 px-lg-5">
    <div class="row gx-4 gx-lg-5 justify-content-center">
        <div class="col-md-10 col-lg-8 col-xl-7">
            <form action="/auth/register" method="post">
                <div class="mb-3">
                    <label for="name" class="form-label">Adınız</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Adınız" required>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Kullanıcı Adı</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Kullanıcı Adı" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email Adresiniz</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email Adresiniz" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Şifre</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Şifre" required>
                </div>
                <div class="mb-3">
                    <label for="passwordAgain" class="form-label">Şifrenizi Tekrarlayın</label>
                    <input type="password" class="form-control" id="passwordAgain" name="passwordAgain" placeholder="Şifrenizi Tekrarlayın" required>
                </div>
                <div class="mb-3">
                    <label for="bio" class="form-label">Biyografiniz</label>
                    <textarea id="bio" class="form-control" name="bio" placeholder="Kendiniz hakkında bilgi verin..." required></textarea>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Gönder</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Footer-->
<footer class="border-top">
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7">
                <ul class="list-inline text-center">
                    <li class="list-inline-item">
                        <a href="#!">
                                    <span class="fa-stack fa-lg">
                                        <i class="fas fa-circle fa-stack-2x"></i>
                                        <i class="fab fa-twitter fa-stack-1x fa-inverse"></i>
                                    </span>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="#!">
                                    <span class="fa-stack fa-lg">
                                        <i class="fas fa-circle fa-stack-2x"></i>
                                        <i class="fab fa-facebook-f fa-stack-1x fa-inverse"></i>
                                    </span>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="#!">
                                    <span class="fa-stack fa-lg">
                                        <i class="fas fa-circle fa-stack-2x"></i>
                                        <i class="fab fa-github fa-stack-1x fa-inverse"></i>
                                    </span>
                        </a>
                    </li>
                </ul>
                <div class="small text-center text-muted fst-italic">Copyright &copy; Your Website 2022</div>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ public_url('js/scripts.js') }}"></script>
</body>
</html>
