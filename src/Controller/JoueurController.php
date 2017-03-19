<?php
namespace App\Controller;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;
use App\Model\JoueurModel;
use App\Model\ClubModel;

class JoueurController implements ControllerProviderInterface {

    private $ClubModel;
    private $JoueurModel;

    public function index(Application $app) {
        return $this->show($app);
    }

    public function show(Application $app) {
        $joueur = (new JoueurModel($app))->getAllJoueur();
        return $app["twig"]->render('joueur/v_table_joueur.html.twig',['data'=>$joueur]);
    }

    public function add(Application $app) {
        $this->ClubModel = new ClubModel($app);
        $Club = $this->ClubModel->getAllClub();
        return $app["twig"]->render('joueur/v_form_create_joueur.html.twig',['club'=>$Club]);
    }

    public function delete(Application $app, $id) {
        $donnees = (new JoueurModel($app))->getJoueur($id);
        return $app["twig"]->render('joueur/v_form_delete.html.twig',compact('donnees'));
    }

    public function edit(Application $app, $id) {
        $this->ClubModel = new ClubModel($app);
        $club = $this->ClubModel->getAllClub();
        $donnees = (new JoueurModel($app))->getJoueur($id);
        return $app["twig"]->render('joueur/v_form_update_joueur.html.twig',compact('club', 'donnees'));
    }

    public function validFormDel(Application $app){
        $id=htmlentities($_POST['idJoueur']);
        $choix=htmlentities($_POST['choix']);

        if($choix == 'non') {
            return $this->show($app);
        }
        else
        {
            (new JoueurModel($app))->deleteJoueur($id);
            return $this->show($app);     
        }
    }

    public function validFormAdd(Application $app){
        if (isset($_POST['nomJoueur']) && isset($_POST['club']) && isset($_POST['prenomJoueur']) && isset($_POST['tailleJoueur'])) {
            $date = $_POST['annee']."-".$_POST['mois']."-".$_POST['jour'];
            $donnees = [
                'nomJoueur' => htmlspecialchars($_POST['nomJoueur']),
                'idClub' => htmlspecialchars($_POST['club']),
                'prenomJoueur' => htmlspecialchars($_POST['prenomJoueur']),
                'tailleJoueur' => htmlspecialchars($_POST['tailleJoueur']),
                'dateNaissJoueur' => $date
            ];

            $erreurs = $this->erreurs($donnees);

            if(!empty($erreurs))
            {
                $this->ClubModel = new ClubModel($app);
                $club = $this->ClubModel->getAllClub();
                return $app["twig"]->render('joueur/v_form_create_joueur.html.twig',['donnees'=>$donnees,'erreurs'=>$erreurs,'club'=>$club]);
            }
            else{
                $this->JoueurModel = new JoueurModel($app);
                $this->JoueurModel->insertJoueur($donnees);
                return $app->redirect($app["url_generator"]->generate("joueur.show"));
            }

        }
        else
            return "Erreur";
    }

    public function validFormUpdate(Application $app){
        $id=htmlentities($_POST['idJoueur']);
        
        $date = $_POST['annee']."-".$_POST['mois']."-".$_POST['jour'];
        $donnees = [
            'idJoueur' => $id,
            'nomJoueur' => htmlspecialchars($_POST['nomJoueur']),
            'idClub' => htmlspecialchars($_POST['club']),
            'prenomJoueur' => htmlspecialchars($_POST['prenomJoueur']),
            'tailleJoueur' => htmlspecialchars($_POST['tailleJoueur']),
            'dateNaissJoueur' => $date
        ];

        $erreurs = $this->erreurs($donnees);

        if(! empty($erreurs)) {
            $this->ClubModel = new ClubModel($app);
            $Club = $this->ClubModel->getAllClub();
            return $app["twig"]->render('joueur/v_form_update_joueur.html.twig',array('donnees'=>$donnees,'erreurs'=>$erreurs,'club'=>$Club));
        }
        else
        {
            (new JoueurModel($app))->updateJoueur($id, $donnees);
            return $app->redirect($app["url_generator"]->generate("joueur.show"));
        }
    }

    /* A FAAAAAAAAAAAAAIRE AU DESSOUS */

    private function erreurs($donnees){
        $erreurs = [];
        if ((!preg_match("/^[A-Za-z ]{2,}/",$donnees['nomJoueur']))) $erreurs['nom']='Nom composé de 2 lettres minimum';
        if ((!preg_match("/^[A-Za-z ]{2,}/",$donnees['prenomJoueur']))) $erreurs['prenom']='Prénom composé de 2 lettres minimum';
        if ($donnees['idClub'] == null) $erreurs['club']='Veuillez choisir un club !';
        if ((!preg_match("/^[0-9]{0,2}(\.[0-9]{0,2})?$/",$donnees['tailleJoueur']))) $erreurs['tailleJoueur']='La taille doit être de type XX.XX';     
        return $erreurs;
    }

    /* A FAAAAAAAAAAAAAAAAIRE AU DESSUS */

    public function connect(Application $app) {
        $controllers = $app['controllers_factory'];

        $controllers->get('/', 'App\Controller\joueurController::index')->bind('joueur.index');
        $controllers->get('/show', 'App\Controller\joueurController::show')->bind('joueur.show');

        $controllers->get('/add', 'App\Controller\joueurController::add')->bind('joueur.add');
        $controllers->post('/add', 'App\Controller\joueurController::validFormAdd')->bind('joueur.validFormAdd');

        $controllers->get('/del', 'App\Controller\joueurController::delete')->bind('joueur.delete');
        $controllers->post('/del', 'App\Controller\joueurController::validFormDel')->bind('joueur.validFormDel');

        $controllers->match('/delete/{id}', 'App\Controller\joueurController::delete')->bind('joueur.delete');

        $controllers->get('/edit/{id}', 'App\Controller\joueurController::edit')->bind('joueur.edit');
        $controllers->post('/edit/{id}', 'App\Controller\joueurController::validFormUpdate')->bind('joueur.validFormUpdate');

        return $controllers;
    }
}