<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass="App\Repository\KittenRepository")
 */
class Kitten
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
     * @ORM\Column(type="integer")
     */
    private $state;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $stateMessage;

    /**
     * @ORM\Column(type="string", length=1020)
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     */
    private $weight;

    /**
     * @ORM\Column(type="date")
     */
    private $birthDate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $shortDescription;

    /**
     * @ORM\Column(type="string", length=1)
     */
    private $sex;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isDisplay;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Litter", inversedBy="kittens",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $litter;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\KittenImage", mappedBy="kitten", orphanRemoval=true ,cascade={"persist"})
     */
    private $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->uploadedImages = new ArrayCollection();
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

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getStateMessage(): ?string
    {
        return $this->stateMessage;
    }

    public function setStateMessage(?string $stateMessage): self
    {
        $this->stateMessage = $stateMessage;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(string $notes): self
    {
        $this->notes = $notes;

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

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(string $shortDescription): self
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    public function getSex(): ?string
    {
        return $this->sex;
    }

    public function setSex(string $sex): self
    {
        $this->sex = $sex;

        return $this;
    }

    public function getIsDisplay(): ?bool
    {
        return $this->isDisplay;
    }

    public function setIsDisplay(bool $isDisplay): self
    {
        $this->isDisplay = $isDisplay;

        return $this;
    }

    public function getLitter(): ?Litter
    {
        return $this->litter;
    }

    public function setLitter(?Litter $litter): self
    {
        $this->litter = $litter;

        return $this;
    }

    /**
     * @return Collection|KittenImage[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(KittenImage $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setKitten($this);
        }

        return $this;
    }

    public function removeImage(KittenImage $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getKitten() === $this) {
                $image->setKitten(null);
            }
        }

        return $this;
    }
}
