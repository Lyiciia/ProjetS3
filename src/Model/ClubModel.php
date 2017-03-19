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
}