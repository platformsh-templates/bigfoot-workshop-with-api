<?php

namespace App\GitHub;

use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GitHubApiHelper
{
    public function __construct(
        private HttpClientInterface $httpClient,
        private CacheInterface $cache
    )
    {
    }

    public function getOrganizationInfo(string $organization): GitHubOrganization
    {
        $key = sprintf('github_organization_%s', $organization);

        $data = $this->cache->get($key, function (ItemInterface $item) use ($organization) {
            $item->expiresAfter(3600);
            $response = $this->httpClient->request('GET', 'https://api.github.com/orgs/' . $organization . '?per_page=200&sort=updated&type=all');

            return $response->toArray();
        });

        return new GitHubOrganization(
            $data['name'],
            $data['public_repos']
        );
    }

    /**
     * @return GitHubRepository[]
     */
    public function getOrganizationRepositories(string $organization): array
    {
        $key = sprintf('github_repositories_%s', $organization);

        return $this->cache->get($key, function (ItemInterface $item) use ($organization) {
            $item->expiresAfter(3600);

            $response = $this->httpClient->request('GET', sprintf('https://api.github.com/orgs/%s/repos?per_page=200&sort=updated&type=all', $organization));

            $data = $response->toArray();

            $repositories = [];
            $publicRepoCount = 0;
            foreach ($data as $repoData) {
                $repositories[] = new GitHubRepository(
                    $repoData['name'],
                    $repoData['html_url'],
                    \DateTimeImmutable::createFromFormat('Y-m-d\TH:i:s\Z', $repoData['updated_at'])
                );

                if ($repoData['private'] === false) {
                    ++$publicRepoCount;
                }
            }

            // Store in cache organization info as it exists in this Response
            $keyOrganization = sprintf('github_organization_%s', $organization);
            $this->cache->get($keyOrganization, function (ItemInterface $itemOrganization) use ($organization) {
                $itemOrganization->expiresAfter(3600);
                $response = $this->httpClient->request('GET', 'https://api.github.com/orgs/' . $organization . '?per_page=200&sort=updated&type=all');

                return $response->toArray();
            });

            return $repositories;
        });
    }
}
