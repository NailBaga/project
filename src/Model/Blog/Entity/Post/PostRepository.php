<?php

namespace App\Model\Blog\Entity\Post;

use App\Model\Blog\Entity\Post\Post;
use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class PostRepository
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Post::class);
        $this->em = $em;
    }


    public function get(Id $id): Post
    {
        /** @var Post $post */
        if (!$post = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('Post is not found.');
        }

        return $post;
    }

    public function add(Post $post): void
    {
        $this->em->persist($post);
    }

    public function remove(Post $post): void
    {
        $this->em->remove($post);
    }

}