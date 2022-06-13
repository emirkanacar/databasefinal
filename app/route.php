<?php

$app->router->any('/', 'Home@main');

$app->router->get('/gonderi/:slug-:id', 'Post@main');
$app->router->get('/gonderiler', 'Post@allPosts');

$app->router->get('/kategori/:slug-:id', 'Category@main');
$app->router->get('/kategoriler', 'Category@allCategories');

$app->router->get('/auth/login', 'Auth@login');
$app->router->post('/auth/login', 'Auth@loginPost');
$app->router->get('/auth/register', 'Auth@register');
$app->router->post('/auth/register', 'Auth@registerPost');
$app->router->get('/auth/logout', 'Auth@logout');

$app->router->get('/yazar/:slug', 'Author@getPosts');

$app->router->get('/panel/', 'Dashboard@main');
$app->router->get('/panel/gonderiler', 'Dashboard@posts');
$app->router->get('/panel/gonderiler/ekle', 'Dashboard@addPost');
$app->router->post('/panel/gonderiler/ekle', 'Dashboard@addPostForm');
$app->router->get('/panel/gonderiler/sil/:id', 'Dashboard@deletePost');
$app->router->get('/panel/gonderiler/duzenle/:id', 'Dashboard@editPost');
$app->router->post('/panel/gonderiler/duzenle', 'Dashboard@editPostForm');

$app->router->get('/panel/kategoriler', 'Dashboard@categories');
$app->router->get('/panel/kategoriler/sil/:id', 'Dashboard@deleteCategory');
$app->router->get('/panel/kategoriler/duzenle/:id', 'Dashboard@editCategory');
$app->router->post('/panel/kategoriler/duzenle', 'Dashboard@editCategoryForm');
$app->router->get('/panel/kategoriler/ekle', 'Dashboard@addCategory');
$app->router->post('/panel/kategoriler/ekle', 'Dashboard@addCategoryForm');
