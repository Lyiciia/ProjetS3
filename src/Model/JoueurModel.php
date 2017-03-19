<?php
namespace App\Model;
use Silex\Application;
use Doctrine\DBAL\Query\QueryBuilder;

class JoueurModel {

    private $db;

    public function __construct(Application $app) {
        $this->db = $app['db'];
    }

    public function getAllJoueur() {
        $queryBuilder = new QueryBuilder($this->db);
        $queryBuilder
            ->select('j.idJoueur', 'c.nomClub', 'j.nomJoueur', 'j.prenomJoueur', 'j.tailleJoueur', 'j.dateNaissJoueur')
            ->from('joueur', 'j')
            ->innerJoin('j', 'club', 'c', 'j.idClub=c.idClub')
            ->addOrderBy('j.nomJoueur', 'ASC');
        return $queryBuilder->execute()->fetchAll();
    }

    public function getJoueur($id){
        $queryBuilder = new QueryBuilder($this->db);
        $queryBuilder
            ->select('j.idJoueur', 'c.nomClub', 'j.nomJoueur', 'j.prenomJoueur', 'j.tailleJoueur', 'j.dateNaissJoueur')
            ->from('joueur', 'j')
            ->innerJoin('j', 'club', 'c', 'j.idClub=c.idClub')
            ->where('j.idJoueur = :id')
            ->setParameter(':id', intval($id));

        $res = $queryBuilder->execute()->fetch();
        return [
            'idJoueur' => $res['idJoueur'],
            'nomJoueur' => $res['nomJoueur'],
            'nomClub' => $res['nomClub'],
            'prenomJoueur' => $res['prenomJoueur'],
            'tailleJoueur' => $res['tailleJoueur'],
            'dateNaissJoueur' => $res['dateNaissJoueur']
        ];
    }

    public function insertJoueur($donnees) {
        $queryBuilder = new QueryBuilder($this->db);
        $queryBuilder->insert('joueur')
            ->values([
                'nomJoueur' => '?',
                'prenomJoueur' => '?',
                'tailleJoueur' => '?',
                'dateNaissJoueur' => '?',
                'idClub' => '?'
            ])
            ->setParameter(0, $donnees['nomJoueur'])
            ->setParameter(1, $donnees['prenomJoueur'])
            ->setParameter(2, $donnees['tailleJoueur'])
            ->setParameter(3, $donnees['dateNaissJoueur'])
            ->setParameter(4, $donnees['idClub'])
        ;
        return $queryBuilder->execute();
    }

    public function deleteJoueur($id){
        $qb = new QueryBuilder($this->db);
        $qb->delete('joueur')
            ->where('idJoueur = :id')
            ->setParameter(':id', intval($id))
        ;
        return $qb->execute();
    }

    public function updateJoueur($id, $donnees){
        $qb = new QueryBuilder($this->db);
        $qb->update('joueur')
            ->set('nomJoueur', ':nomJoueur')
            ->set('prenomJoueur', ':prenomJoueur')
            ->set('tailleJoueur', ':tailleJoueur')
            ->set('dateNaissJoueur', ':dateNaissJoueur')
            ->set('idClub', ':idClub')
            ->where('idJoueur = :id')
            ->setParameter(':id', $id)
            ->setParameter(':nomJoueur', $donnees['nomJoueur'])
            ->setParameter(':prenomJoueur', $donnees['prenomJoueur'])
            ->setParameter(':tailleJoueur', $donnees['tailleJoueur'])
            ->setParameter(':dateNaissJoueur', $donnees['dateNaissJoueur'])
            ->setParameter(':idClub', $donnees['idClub'])
        ;
        return $qb->execute();
    }
}