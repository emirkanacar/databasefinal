<?php
if(!isset($_SESSION)) {
    session_start();
}

if(isset($message)) {
    echo "ok";
    header("refresh:2; url=/panel/gonderiler" );
}


if(!isset($postDetails) || empty($postDetails["postTitle"]) == 1) {
    header("Location: /panel/gonderiler");
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
    <title>Yönetim - Gönderi Düzenle</title>
    <link href="<?php echo e(public_url('vendor/fontawesome-free/css/all.min.css')); ?>" rel="stylesheet" type="text/css">
    <link
            href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
            rel="stylesheet">
    <link href="<?php echo e(public_url('css/sb-admin-2.min.css')); ?>" rel="stylesheet">
</head>

<body id="page-top">

<div id="wrapper">
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
            <div class="sidebar-brand-text mx-3">Yönetim Paneli</div>
        </a>
        <hr class="sidebar-divider my-0">
        <li class="nav-item">
            <a class="nav-link" href="/panel/">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Ana Sayfa</span>
            </a>
        </li>
        <li class="nav-item active">
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
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo e($_SESSION["auth"]["name"]); ?></span>
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
                    <h1 class="h3 mb-0 text-gray-800">Gönderiler</h1>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Gönderi Düzenle</h6>
                    </div>

                    <?php
                    if(isset($message["message"])) {
                        if($message["error"]) {
                            echo '<div class="p-3"><div class="card bg-danger text-white shadow"><div class="card-body">Hata<div class="text-white-50 small">'.$message["message"].'</div></div></div></div>';
                        }else {
                            echo '<div class="p-3"><div class="card bg-success text-white shadow"><div class="card-body">Başarılı<div class="text-white-50 small">'.$message["message"].'</div></div></div></div>';
                        }
                    }
                    ?>

                    <div class="card-body">
                        <form method="POST" action="/panel/gonderiler/duzenle">
                            <input type="hidden" name="id" value="<?php echo e($postDetails["id"]); ?>">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="postTitle">Gönderi Başlığı</label>
                                    <input type="text" class="form-control" name="postTitle" id="postTitle" placeholder="Gönderi Başlığı" value="<?php echo e($postDetails["postTitle"]); ?>" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="postAuthor">Yazar</label>
                                    <input type="text" class="form-control" name="postAuthor" id="postAuthor" placeholder="Yazar" value="<?php echo e($postDetails["name"]); ?>" disabled>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="postContent">Gönderi İçeriği</label>
                                    <textarea class="form-group" name="postContent" id="postContent" required><?php echo $postDetails["postContent"]; ?></textarea>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="postTags">Etiketler</label>
                                    <input type="text" class="form-control" name="postTags" id="postTags" placeholder="Etiketler" value="<?php echo e($postDetails["postTags"]); ?>" required>
                                    <small id="tagsHelp" class="form-text text-muted">Etikletleri virgül ile ayırın.</small>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="postCategory">Gönderi Kategorisi</label>
                                    <select class="form-control" id="postCategory" name="postCategory">
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($category["id"]); ?>" <?php echo e($category["id"] == $postDetails["id"] ? "selected" : ""); ?>><?php echo e($category["categoryName"]); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Kaydet</button>
                        </form>
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

<script src="<?php echo e(public_url('vendor/jquery/jquery.min.js')); ?>"></script>
<script src="<?php echo e(public_url('vendor/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
<script src="<?php echo e(public_url('vendor/jquery-easing/jquery.easing.min.js')); ?>"></script>
<script src="<?php echo e(public_url('js/sb-admin-2.min.js')); ?>"></script>
<script src="<?php echo e(public_url('vendor/chart.js/Chart.min.js')); ?>"></script>
<script src="<?php echo e(public_url('vendor/tinymce/tinymce.min.js')); ?>"></script>
<script>
    tinymce.init({
        selector: 'textarea',
        language: 'tr'
    });
</script>

</body>

</html><?php /**PATH C:\xampp\htdocs\public\views/dashboard/editPost.blade.php ENDPATH**/ ?>