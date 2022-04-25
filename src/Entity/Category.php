<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    private $name;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'category')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Message::class)]
    private $categoryMessage;

    public function __construct()
    {
        $this->categoryMessage = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getCategoryMessage(): Collection
    {
        return $this->categoryMessage;
    }

    public function addCategoryMessage(Message $categoryMessage): self
    {
        if (!$this->categoryMessage->contains($categoryMessage)) {
            $this->categoryMessage[] = $categoryMessage;
            $categoryMessage->setCategory($this);
        }

        return $this;
    }

    public function removeCategoryMessage(Message $categoryMessage): self
    {
        if ($this->categoryMessage->removeElement($categoryMessage)) {
            // set the owning side to null (unless already changed)
            if ($categoryMessage->getCategory() === $this) {
                $categoryMessage->setCategory(null);
            }
        }

        return $this;
    }
}
