<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OptionRepository")
 */
class Option
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Property", mappedBy="Options")
     */
    private $propieties;

    public function __construct()
    {
        $this->propieties = new ArrayCollection();
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

    /**
     * @return Collection|Property[]
     */
    public function getPropieties(): Collection
    {
        return $this->propieties;
    }

    public function addPropiety(Property $propiety): self
    {
        if (!$this->propieties->contains($propiety)) {
            $this->propieties[] = $propiety;
        }

        return $this;
    }

    public function removePropiety(Property $propiety): self
    {
        if ($this->propieties->contains($propiety)) {
            $this->propieties->removeElement($propiety);
        }

        return $this;
    }
}
