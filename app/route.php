<?php
$app->mount("/", new App\Controller\IndexController($app));
$app->mount("/", new App\Controller\JoueurController($app));
$app->mount("/", new App\Controller\ClubController($app));