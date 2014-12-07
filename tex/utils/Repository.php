<?php

namespace tex\utils;

use Doctrine\DBAL\Connection;

class Repository
{
    private $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    public function getHeaderStats()
    {
        $sql = "SELECT status, COUNT(id) AS number FROM bets GROUP BY status";
        return $this->db->fetchAll($sql);
    }

    public function getNumberOfPages()
    {
        $numberOfBets = $this->db->executeQuery("SELECT id FROM bets")->rowCount();
        return ceil($numberOfBets / 5);
    }

    public function getPaginatedBets($offset, $limit)
    {
        $stmt = $this->db->prepare("SELECT * FROM bets ORDER BY date DESC LIMIT :offset, :limit");
        $stmt->bindValue('offset', $offset, \PDO::PARAM_INT);
        $stmt->bindValue('limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}