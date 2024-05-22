<?php

namespace App\Entity;

use App\Repository\FriendsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FriendsRepository::class)]
class Friends
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?user $user1 = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?user $user2 = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser1(): ?user
    {
        return $this->user1;
    }

    public function setUser1(?user $user1): static
    {
        $this->user1 = $user1;

        return $this;
    }

    public function getUser2(): ?user
    {
        return $this->user2;
    }

    public function setUser2(?user $user2): static
    {
        $this->user2 = $user2;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }
}
