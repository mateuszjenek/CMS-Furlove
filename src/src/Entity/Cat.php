<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CatRepository")
 */
class Cat
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
     * @ORM\Column(type="string", length=255)
     */
    private $sex;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isOur;

    /**
     * @ORM\Column(type="date")
     */
    private $birthDate;

    /**
     * @ORM\Column(type="string", length=1020)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $shortDescription;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $breeding;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CatImage", mappedBy="cat", orphanRemoval=true,cascade={"persist"})
     */
    private $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->litters = new ArrayCollection();
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

    /**
     * @return ArrayCollection
     */
    public function getUploadedImages(): ArrayCollection
    {
        return $this->uploadedImages;
    }

    public function addUploadedImag(UploadedFile $image): self
    {
        if (!$this->uploadedImages->contains($image)) {
            $this->uploadedImages->add($image);
        }

        return $this;
    }

    public function removeUploadedImag(UploadedFile $image): self
    {
        if ($this->uploadedImages->contains($image)) {
            $this->uploadedImages->removeElement($image);
        }

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

    public function getIsOur(): ?bool
    {
        return $this->isOur;
    }

    public function setIsOur(bool $isOur): self
    {
        $this->isOur = $isOur;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function getBreeding(): ?string
    {
        return $this->breeding;
    }

    public function setBreeding(?string $breeding): self
    {
        $this->breeding = $breeding;

        return $this;
    }

    /**
     * @return Collection|CatImage[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(CatImage $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setCat($this);
        }

        return $this;
    }

    public function removeImage(CatImage $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getCat() === $this) {
                $image->setCat(null);
            }
        }

        return $this;
    }
}
