<?php

declare(strict_types=1);

/*
 * This file is part of the BT project.
 *
 * Copyright (c) 2023 BT
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;

use App\Repository\MenuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
class Menu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?int $menuOrder = null;

    #[ORM\ManyToMany(targetEntity: self::class, inversedBy: 'subMenus')]
    private Collection $subMenu;

    #[ORM\ManyToMany(targetEntity: self::class, mappedBy: 'subMenu')]
    private Collection $subMenus;

    #[ORM\Column]
    private ?bool $isVisble = null;

    #[ORM\ManyToOne]
    private ?Article $article = null;

    #[ORM\ManyToOne]
    private ?Category $category = null;

    #[ORM\ManyToOne]
    private ?Page $page = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $link = null;

    public function __construct()
    {
        $this->subMenu = new ArrayCollection();
        $this->subMenus = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getMenuOrder(): ?int
    {
        return $this->menuOrder;
    }

    public function setMenuOrder(?int $menuOrder): static
    {
        $this->menuOrder = $menuOrder;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getSubMenu(): Collection
    {
        return $this->subMenu;
    }

    public function addSubMenu(self $subMenu): static
    {
        if (!$this->subMenu->contains($subMenu)) {
            $this->subMenu->add($subMenu);
        }

        return $this;
    }

    public function removeSubMenu(self $subMenu): static
    {
        $this->subMenu->removeElement($subMenu);

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getSubMenus(): Collection
    {
        return $this->subMenus;
    }

    public function isIsVisble(): ?bool
    {
        return $this->isVisble;
    }

    public function setIsVisble(bool $isVisble): static
    {
        $this->isVisble = $isVisble;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): static
    {
        $this->article = $article;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getPage(): ?Page
    {
        return $this->page;
    }

    public function setPage(?Page $page): static
    {
        $this->page = $page;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): static
    {
        $this->link = $link;

        return $this;
    }
}
