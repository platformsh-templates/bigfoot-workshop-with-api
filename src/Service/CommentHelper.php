<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\CommentRepository;

class CommentHelper
{
    public function __construct(private CommentRepository $commentRepository)
    {
    }

    public function countRecentCommentsForUser(User $user): int
    {
        return $this->commentRepository->countForUser($user, (new \DateTimeImmutable('-3 months')));
    }
}
