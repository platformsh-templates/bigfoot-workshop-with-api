<?php

namespace App\Twig;

use App\Entity\User;
use App\Service\CommentHelper;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class AppExtension extends AbstractExtension
{
    public function __construct(private CommentHelper $commentHelper, private CacheInterface $cache)
    {
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('user_activity_text', [$this, 'getUserActivityText']),
        ];
    }

    public function getUserActivityText(User $user): string
    {
        $key = sprintf('user_activity_text_%s', $user->getId());

        return $this->cache->get($key, function(ItemInterface $item) use ($user) {
            $item->expiresAfter(3600);

            return $this->calculateUserActivityText($user);
        });
    }

    private function calculateUserActivityText(User $user): string
    {
        $commentCount = $this->commentHelper->countRecentCommentsForUser($user);

        if ($commentCount > 50) {
            return 'bigfoot fanatic';
        }

        if ($commentCount > 30) {
            return 'believer';
        }

        if ($commentCount > 20) {
            return 'hobbyist';
        }

        return 'skeptic';
    }
}
