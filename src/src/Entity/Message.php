<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MessageRepository")
 * FIXME: Send emails directly
 */
class Message
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
    private $senderName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $senderEmail;

    /**
     * @ORM\Column(type="string", length=1020)
     */
    private $message;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isReaded;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isAnswered;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isStared;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSenderName(): ?string
    {
        return $this->senderName;
    }

    public function setSenderName(string $senderName): self
    {
        $this->senderName = $senderName;

        return $this;
    }

    public function getSenderEmail(): ?string
    {
        return $this->senderEmail;
    }

    public function setSenderEmail(string $senderEmail): self
    {
        $this->senderEmail = $senderEmail;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getIsReaded(): ?bool
    {
        return $this->isReaded;
    }

    public function setIsReaded(bool $isReaded): self
    {
        $this->isReaded = $isReaded;

        return $this;
    }

    public function getIsAnswered(): ?bool
    {
        return $this->isAnswered;
    }

    public function setIsAnswered(bool $isAnswered): self
    {
        $this->isAnswered = $isAnswered;

        return $this;
    }

    public function getIsStared(): ?bool
    {
        return $this->isStared;
    }

    public function setIsStared(bool $isStared): self
    {
        $this->isStared = $isStared;

        return $this;
    }
}
