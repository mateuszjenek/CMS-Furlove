<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LitterRepository")
 */
class Litter
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
    private $litter;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cat")
     * @var Cat
     */
    private $mother;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $altMother;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cat")
     * @var Cat
     */
    private $father;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $altFather;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Kitten", mappedBy="litter")
     */
    private $kittens;

    public function __construct()
    {
        $this->kittens = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLitter(): ?string
    {
        return $this->litter;
    }

    public function setLitter(string $litter): self
    {
        $this->litter = $litter;

        return $this;
    }

    public function getMother(): ?Cat
    {
        return $this->mother;
    }

    public function setMother(?Cat $mother): self
    {
        $this->mother = $mother;

        return $this;
    }

    public function getAltMother(): ?string
    {
        return $this->altMother;
    }

    public function setAltMother(?string $altMother): self
    {
        $this->altMother = $altMother;

        return $this;
    }

    public function getFather(): ?Cat
    {
        return $this->father;
    }

    public function setFather(?Cat $father): self
    {
        $this->father = $father;

        return $this;
    }

    public function getAltFather(): ?string
    {
        return $this->altFather;
    }

    public function setAltFather(?string $altFather): self
    {
        $this->altFather = $altFather;

        return $this;
    }

    /**
     * @return Collection|Kitten[]
     */
    public function getKittens(): Collection
    {
        return $this->kittens;
    }

    public function addKitten(Kitten $kitten): self
    {
        if (!$this->kittens->contains($kitten)) {
            $this->kittens[] = $kitten;
            $kitten->setLitter($this);
        }

        return $this;
    }

    public function removeKitten(Kitten $kitten): self
    {
        if ($this->kittens->contains($kitten)) {
            $this->kittens->removeElement($kitten);
            // set the owning side to null (unless already changed)
            if ($kitten->getLitter() === $this) {
                $kitten->setLitter(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->litter." (".$this->mother->getName()." + ".$this->father->getName().")";
    }


}
