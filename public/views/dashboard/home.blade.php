<?php
    if(!isset($_SESSION)) {
        session_start();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Yönetim - Ana Sayfa</title>
    <link href="{{ public_url('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
            href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
            rel="stylesheet">
    <link href="{{ public_url('css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>

<body id="page-top">

<div id="wrapper">
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
            <div class="sidebar-brand-text mx-3">Yönetim Paneli</div>
        </a>
        <hr class="sidebar-divider my-0">
        <li class="nav-item active">
            <a class="nav-link" href="/panel/">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Ana Sayfa</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/panel/gonderiler">
                <i class="fas fa-fw fa-list"></i>
                <span>Gönderiler</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/panel/gonderiler/ekle">
                <i class="fas fa-fw fa-plus"></i>
                <span>Gönderi Ekle</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/panel/kategoriler">
                <i class="fas fa-fw fa-list-alt"></i>
                <span>Kategoriler</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/panel/kategoriler/ekle">
                <i class="fas fa-fw fa-plus"></i>
                <span>Kategori Ekle</span>
            </a>
        </li>

    </ul>

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ $_SESSION["auth"]["name"] }}</span>
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                             aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="/yonetim/profil">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Profil
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="/auth/logout">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Çıkış Yap
                            </a>
                        </div>
                    </li>

                </ul>

            </nav>

            <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Ana Sayfa</h1>
                </div>

                <div class="row">

                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Gönderi Sayısı</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $postCount }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-list fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Kullanıcı Sayısı</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $userCount }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-user fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Kategori Sayısı</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $categoriesCount }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-list-alt fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; Blog 2022</span>
                </div>
            </div>
        </footer>
    </div>
</div>

<script src="{{ public_url('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ public_url('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ public_url('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ public_url('js/sb-admin-2.min.js') }}"></script>
<script src="{{ public_url('vendor/chart.js/Chart.min.js') }}"></script>

</body>

</html>