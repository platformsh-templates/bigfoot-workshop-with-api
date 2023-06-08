<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity()]
#[ORM\Table(name: "comment")]
#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => 'comment:item']),
        new GetCollection(normalizationContext: ['groups' => 'comment:list']),
        new Put(),
        new Patch(),
        new Delete(),
        new Post(),
    ],
    mercure: true,
)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    #[Groups(['comment:list', 'comment:item'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['comment:list', 'comment:item'])]
    private ?string $content = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['comment:list', 'comment:item'])]
    private ?User $owner = null;

    #[ORM\ManyToOne(targetEntity: BigFootSighting::class, inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['comment:list', 'comment:item'])]
    private ?BigFootSighting $bigFootSighting = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['comment:list', 'comment:item'])]
    private \DateTime $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getBigFootSighting(): ?BigFootSighting
    {
        return $this->bigFootSighting;
    }

    public function setBigFootSighting(?BigFootSighting $bigFootSighting): self
    {
        $this->bigFootSighting = $bigFootSighting;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
