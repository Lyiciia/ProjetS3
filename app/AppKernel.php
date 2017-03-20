<?php
include('config.php');
ini_set('date.timezone', 'Europe/Paris');
$loader = require_once join(DIRECTORY_SEPARATOR,[dirname(__DIR__), 'vendor', 'autoload.php']);
$loader->addPsr4('App\\',join(DIRECTORY_SEPARATOR,[dirname(__DIR__), 'src']));
$app = new Silex\Application();
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver' => 'pdo_mysql',
        'dbhost' => hostname,
        'host' => hostname,
        'dbname' => database,
        'user' => username,
        'password' => password,
        'charset'   => 'utf8mb4',
    ),
));
$app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => join(DIRECTORY_SEPARATOR, [dirname(__DIR__), 'src', 'View'])));
$app->register(new Silex\Provider\SessionServiceProvider());
$app['debug'] = true;
$app->register(new Silex\Provider\AssetServiceProvider(), array(
    'assets.named_packages' => array(
        'css' => array(
            'version' => 'css2',
            'base_path' => __DIR__.'/../web/'
        )
    ),
));
use Symfony\Component\HttpFoundation\Request;
Request::enableHttpMethodParameterOverride();
include('route.php');
$app->run();
