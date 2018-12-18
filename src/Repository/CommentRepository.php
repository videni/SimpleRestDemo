<?php

namespace App\Repository;

use App\Entity\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    public function createQueryBuilderByPostId($postId)
    {
        $queryBuilder = $this->createQueryBuilder('o');
        $queryBuilder
            ->where('IDENTITY(o.post)=:postId')
            ->setParameter('postId', $postId)
        ;

        return $queryBuilder;
    }
}
