<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Put;
use App\Repository\BigFootSightingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BigFootSightingRepository::class)]
#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => 'sighting:item']),
        new GetCollection(normalizationContext: ['groups' => 'sighting:list']),
        new Put(),
        new Patch(),
        new Delete(),
        new GetCollection(),
        new Post(),
    ],
    mercure: true,
)]
class BigFootSighting
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['sighting:list', 'sighting:item'])]
    private ?int $id = null;

    #[ORM\Column(type: 'string')]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    #[Groups(['sighting:list', 'sighting:item'])]
    private string $title;

    #[ORM\Column(type: 'text')]
    #[Groups(['sighting:list', 'sighting:item'])]
    private string $description;

    #[ORM\Column(type: 'integer')]
    #[Groups(['sighting:list', 'sighting:item'])]
    private int $confidenceIndex;

    #[ORM\Column(type: 'decimal', precision: 9, scale: 6)]
    #[Groups(['sighting:list', 'sighting:item'])]
    private float $latitude;

    #[ORM\Column(type: 'decimal', precision: 9, scale: 6)]
    #[Groups(['sighting:list', 'sighting:item'])]
    private float $longitude;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'bigFootSightings')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['sighting:list', 'sighting:item'])]
    private User $owner;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['sighting:list', 'sighting:item'])]
    private \DateTimeInterface $createdAt;

    /**
     * @var Comment[]|Collection
     */
    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: "bigFootSighting")]
    #[ORM\OrderBy(['createdAt' => 'DESC'])]
    #[Groups(['sighting:item'])]
    private Collection $comments;

    #[ORM\Column(type: 'integer')]
    #[Groups(['sighting:list', 'sighting:item'])]
    private ?int $score = 0;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getConfidenceIndex(): ?int
    {
        return $this->confidenceIndex;
    }

    public function setConfidenceIndex(int $confidenceIndex): self
    {
        $this->confidenceIndex = $confidenceIndex;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(string $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(string $longitude): self
    {
        $this->longitude = $longitude;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }


    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setBigFootSighting($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getBigFootSighting() === $this) {
                $comment->setBigFootSighting(null);
            }
        }

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): self
    {
        $this->score = $score;

        return $this;
    }
}
