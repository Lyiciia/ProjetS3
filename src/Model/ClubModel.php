<?php
namespace App\Model;
use Silex\Application;
use Doctrine\DBAL\Query\QueryBuilder;

class ClubModel {

    private $db;

    public function __construct(Application $app) {
        $this->db = $app['db'];
    }

    public function getAllClub() {
        $queryBuilder = new QueryBuilder($this->db);
        $queryBuilder
            ->select('c.idClub', 'c.nomClub', 'c.villeClub')
            ->from('club', 'c')
            ->addOrderBy('c.nomClub', 'ASC');
        return $queryBuilder->execute()->fetchAll();
    }

    public function getClub($id){
        $queryBuilder = new QueryBuilder($this->db);
        $queryBuilder
            ->select('c.nomClub', 'c.villeClub')
            ->from('club', 'c')
            ->where('c.idClub = :id')
            ->setParameter(':id', intval($id));

        $res = $queryBuilder->execute()->fetch();
        return [
            'idClub' => $res['idClub'],
            'nomClub' => $res['nomClub'],
            'villeClub' => $res['villeClub']
        ];
    }

    public function insertClub($donnees) {
        $queryBuilder = new QueryBuilder($this->db);
        $queryBuilder->insert('club')
            ->values([
                'nomClub' => '?',
                'villeClub' => '?'
            ])
            ->setParameter(0, $donnees['nomClub'])
            ->setParameter(1, $donnees['villeClub'])
        ;
        return $queryBuilder->execute();
    }

    public function deleteClub($id){
        $qb = new QueryBuilder($this->db);
        $qb->delete('club')
            ->where('idClub = :id')
            ->setParameter(':id', intval($id))
        ;
        return $qb->execute();
    }

    public function updateClub($id, $donnees){
        $qb = new QueryBuilder($this->db);
        $qb->update('club')
            ->set('nomClub', ':nomClub')
            ->set('villeClub', ':villeClub')
            ->where('idClub = :id')
            ->setParameter(':nomClub', $donnees['nomClub'])
            ->setParameter(':villeClub', $donnees['villeClub'])
            ->setParameter(':id', $id)
        ;
        return $qb->execute();
    }
}