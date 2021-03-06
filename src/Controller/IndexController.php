<?php
namespace App\Controller;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;   // version 2.0 avant sans Api


class IndexController implements ControllerProviderInterface
{
    public function index(Application $app)
    {
        return $app["twig"]->render("v_test.html.twig");
    }

    public function validMonForm(Application $app)
    {
        $data=$_POST['test'];
        return $app["twig"]->render("v_test.html.twig",["data"=>$data]);
    }

    public function connect(Application $app)
    {
        // créer un nouveau controleur basé sur la route par défaut
        $index = $app['controllers_factory'];
        $index->match("/", 'App\Controller\IndexController::index');
        $index->match("/index", 'App\Controller\IndexController::index');
        $index->match("/info", 'App\Controller\IndexController::info')->bind('phpinfo');
        $index->put("/monForm1", 'App\Controller\IndexController::validMonForm')->bind('validForm');
        $index->get('/', 'App\Controller\IndexController::index')->bind('index.root');

        return $index;
    }
}