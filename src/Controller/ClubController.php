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
        return $app["twig"]->render('club/v_form_create_club.html.twig');
    }

    public function validFormAddC(Application $app){
        if (isset($_POST['nomClub']) && isset($_POST['villeClub'])) {
            $donnees = [
                'nomClub' => htmlspecialchars($_POST['nomClub']),
                'villeClub' => htmlspecialchars($_POST['villeClub'])
            ];

            $erreurs = $this->erreurs($donnees);

            if(!empty($erreurs))
            {
                return $app["twig"]->render('club/v_form_create_club.html.twig',['donnees'=>$donnees,'erreurs'=>$erreurs]);
            }
            else{
                $this->ClubModel = new ClubModel($app);
                $this->ClubModel->insertClub($donnees);
                return $app->redirect($app["url_generator"]->generate("club.showC"));
            }

        }
        else
            return "Erreur";
    }

    public function editC(Application $app, $id){
        $donnees = (new ClubModel($app))->getClub($id);
        return $app["twig"]->render('club/v_form_update_club.html.twig',compact('donnees'));
    }

    public function validFormUpdateC(Application $app){
        $id=htmlentities($_POST['idClub']);
        $donnees = [
            'nomClub' => htmlspecialchars($_POST['nomClub']),
            'villeClub' => htmlspecialchars($_POST['villeClub'])
        ];

        $erreurs = $this->erreurs($donnees);

        if(! empty($erreurs)) {
            return $app["twig"]->render('club/v_form_update_club.html.twig',array('donnees'=>$donnees,'erreurs'=>$erreurs));
        }
        else
        {
            (new ClubModel($app))->updateClub($id, $donnees);
            return $app->redirect($app["url_generator"]->generate("club.showC"));
        }
    }

    public function deleteC(Application $app, $id){
        $donnees = (new ClubModel($app))->getClub($id);
        return $app["twig"]->render('club/v_form_delete_club.html.twig',compact('donnees'));
    }

    public function validFormDelC(Application $app){
        $id=htmlentities($_POST['idClub']);
        $choix=htmlentities($_POST['choix']);

        if($choix == 'non') {
            return $this->showC($app);
        }
        else
        {
            (new ClubModel($app))->deleteClub($id);
            return $this->showC($app);     
        }
    }

    public function erreurs($donnees){
        if ((!preg_match("/^[A-Za-z ]{2,}/",$donnees['nomClub']))) $erreurs['nomClub']='Nom composé de 2 lettres minimum';
        if ((!preg_match("/^[A-Za-z ]{2,}/",$donnees['villeClub']))) $erreurs['villeClub']='Ville composée de 2 lettres minimum';
    }

    public function connect(Application $app) {
        $controllers = $app['controllers_factory'];

        $controllers->get('/addC', 'App\Controller\clubController::addC')->bind('club.addC');
        $controllers->post('/addC', 'App\Controller\clubController::validFormAddC')->bind('club.validFormAddC');

        $controllers->get('/', 'App\Controller\clubController::indexC')->bind('club.indexC');
        $controllers->get('/showC', 'App\Controller\clubController::showC')->bind('club.showC');

        $controllers->get('/delC', 'App\Controller\clubController::deleteC')->bind('club.deleteC');
        $controllers->post('/delC', 'App\Controller\clubController::validFormDelC')->bind('club.validFormDelC');

        $controllers->match('/deleteC/{id}', 'App\Controller\clubController::deleteC')->bind('club.deleteC');

        $controllers->get('/editC/{id}', 'App\Controller\clubController::editC')->bind('club.editC');
        $controllers->post('/editC/{id}', 'App\Controller\clubController::validFormUpdateC')->bind('club.validFormUpdateC');
        
        return $controllers;
    }
}