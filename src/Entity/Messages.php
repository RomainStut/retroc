<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MessagesRepository")
 */
class Messages
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datepost;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Products", inversedBy="messages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users", inversedBy="messages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $expediteur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users", inversedBy="messagesRecus")
     * @ORM\JoinColumn(nullable=false)
     */
    private $destinataire;

    public function getId()
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getDatepost(): ?\DateTimeInterface
    {
        return $this->datepost;
    }

    public function setDatepost(\DateTimeInterface $datepost): self
    {
        $this->datepost = $datepost;

        return $this;
    }


    public function getProduct(): ?Products
    {
        return $this->product;
    }

    public function setProduct(?Products $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getExpediteur(): ?Users
    {
        return $this->expediteur;
    }

    public function setExpediteur(?Users $expediteur): self
    {
        $this->expediteur = $expediteur;

        return $this;
    }

    public function getDestinataire(): ?Users
    {
        return $this->destinataire;
    }

    public function setDestinataire(?Users $destinataire): self
    {
        $this->destinataire = $destinataire;

        return $this;
    }
}
