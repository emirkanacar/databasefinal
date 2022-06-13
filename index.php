<?php

require __DIR__ . '/vendor/autoload.php';

session_start();
date_default_timezone_set(config('TIMEZONE', 'Europe/Istanbul'));

$app = new \Core\Bootstrap();

require __DIR__ . '/app/route.php';

$app->run();