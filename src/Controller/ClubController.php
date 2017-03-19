<?php
namespace App\Controller;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;
use App\Model\JoueurModel;
use App\Model\ClubModel;

class ClubController implements ControllerProviderInterface {

    private $ClubModel;
    private $JoueurModel;

    public function indexC(Application $app) {
        return $this->showC($app);
    }

    public function showC(Application $app) {
        $club = (new ClubModel($app))->getAllClub();
        return $app["twig"]->render('club/v_table_club.html.twig',['data'=>$club]);
    }

    public function addC(Application $app){
        return $this->showC($app);
    }

    public function editC(Application $app){
        return $this->showC($app);
    }

    public function deleteC(Application $app){
        return $this->showC($app);
    }

    public function connect(Application $app) {
        $controllers = $app['controllers_factory'];

        $controllers->get('/addC', 'App\Controller\clubController::addC')->bind('club.addC');

        $controllers->get('/', 'App\Controller\clubController::indexC')->bind('club.indexC');
        $controllers->get('/showC', 'App\Controller\clubController::showC')->bind('club.showC');

        $controllers->get('/delC', 'App\Controller\clubController::deleteC')->bind('club.deleteC');

        $controllers->get('/editC/{id}', 'App\Controller\clubController::editC')->bind('club.editC');


        return $controllers;
    }
}