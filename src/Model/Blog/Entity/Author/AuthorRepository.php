<?php

namespace App\Model\Blog\Entity\Author;

use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class AuthorRepository
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Author::class);
        $this->em = $em;
    }

    public function get(Id $id): Author
    {
        /** @var Author $author */
        if (!$author = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('Author is not found.');
        }

        return $author;
    }

    public function find(Id $id)
    {
       return $this->repo->find($id->getValue());
    }

    public function add(Author $author): void
    {
        $this->em->persist($author);
    }

    public function remove(Author $author): void
    {
        $this->em->remove($author);
    }

}