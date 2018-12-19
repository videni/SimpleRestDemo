<?php

declare(strict_types=1);

namespace App\Factory;

use Videni\Bundle\RestBundle\Factory\Factory;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use App\Repository\PostRepository;

class CommentFactory extends Factory
{
    private $postRepository;
    private $tokenStorage;

    public function __construct(
        $className,
        PostRepository $postRepository,
        TokenStorageInterface $tokenStorage
    ) {
        parent::__construct($className);

        $this->postRepository = $postRepository;
        $this->tokenStorage = $tokenStorage;
    }

    public function createByPostId($postId)
    {
        $comment =  $this->createNew();

        $post = $this->postRepository->find($postId);
        if (!$post) {
            throw new NotFoundHttpException(sprintf('Post %s is not found', $postId));
        }

        $comment->setPost($post);
        $comment->setAuthor($this->getUser());

        return $comment;
    }

    protected function getUser()
    {
        return  $this->tokenStorage->getToken()->getUser();
    }
}
