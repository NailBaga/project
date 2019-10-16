<?php

namespace App\ReadModel\Blog\Author;

use App\Model\Blog\Entity\Post\Post;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;
use Doctrine\ORM\EntityManagerInterface;

class AuthorFetcher
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function findAll()
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'b.id',
                'b.name_first as FirstName',
                'b.name_last as LastName'
            )
            ->from('blog_author_author', 'b')
            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }
}