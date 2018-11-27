<?php

namespace App\Bundle\AppBundle\Repository;

use App\Bundle\AppBundle\Entity\Comment;
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
