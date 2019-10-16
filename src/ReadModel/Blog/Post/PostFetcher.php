<?php

namespace App\ReadModel\Blog\Post;

use App\Model\Blog\Entity\Post\Post;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;
use Doctrine\ORM\EntityManagerInterface;

class PostFetcher
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function all()
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'b.id',
                'b.title',
                'b.content_content as content'
            )
            ->from('blog_post', 'b')
            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }
}