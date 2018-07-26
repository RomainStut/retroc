<?php

namespace App\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="App\Repository\UsersRepository")
 */
class Users implements UserInterface, \Serializable
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
    private $username;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $tel;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datebirth;

    /**
     * @ORM\Column(type="text")
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $password;

    /**
     * @param mixed
     */
    private $plainPassword;

    /**
     * @ORM\Column(name="roles", type="array")
     */
    private $roles;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $profilepicture;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tokenresetpassword", mappedBy="user", orphanRemoval=true)
     */
    private $tokenresetpasswords;

    /**
     * @ORM\Column(type="integer")
     */
    private $codepostal;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $city;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Products", mappedBy="user")
     */
    private $products;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Messages", mappedBy="expediteur", orphanRemoval=true)
     */
    private $messages;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Messages", mappedBy="destinataire", orphanRemoval=true)
     */
    private $messagesRecus;


    public function __construct()
    {
        $this->messages = new ArrayCollection();
        $this->tokenresetpasswords = new ArrayCollection();
        $this->retros = new ArrayCollection();
        $this->arcades = new ArrayCollection();
        $this->nextgens = new ArrayCollection();
        $this->goodies = new ArrayCollection();
        $this->products = new ArrayCollection();
        $this->messagesRecus = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getDatebirth(): ?\DateTimeInterface
    {
        return $this->datebirth;
    }

    public function setDatebirth(\DateTimeInterface $datebirth): self
    {
        $this->datebirth = $datebirth;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getProfilepicture(): ?string
    {
        return $this->profilepicture;
    }

    public function setProfilepicture(?string $profilepicture): self
    {
        $this->profilepicture = $profilepicture;

        return $this;
    }

    public function eraseCredentials(){
        $this->plainPassword = null;
    }

    public function getSalt(){

        return null;
    }

    public function serialize(){
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    public function unserialize($serialized){
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized, ['allowed_classes' => false]);
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    

    /**
     * @return Collection|Tokenresetpassword[]
     */
    public function getTokenresetpasswords(): Collection
    {
        return $this->tokenresetpasswords;
    }

    public function addTokenresetpassword(Tokenresetpassword $tokenresetpassword): self
    {
        if (!$this->tokenresetpasswords->contains($tokenresetpassword)) {
            $this->tokenresetpasswords[] = $tokenresetpassword;
            $tokenresetpassword->setUser($this);
        }

        return $this;
    }

    public function removeTokenresetpassword(Tokenresetpassword $tokenresetpassword): self
    {
        if ($this->tokenresetpasswords->contains($tokenresetpassword)) {
            $this->tokenresetpasswords->removeElement($tokenresetpassword);
            // set the owning side to null (unless already changed)
            if ($tokenresetpassword->getUser() === $this) {
                $tokenresetpassword->setUser(null);
            }
        }

        return $this;
    }


    public function getCodepostal(): ?int
    {
        return $this->codepostal;
    }

    public function setCodepostal(int $codepostal): self
    {
        $this->codepostal = $codepostal;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return Collection|Products[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Products $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setUser($this);
        }

        return $this;
    }

    public function removeProduct(Products $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            // set the owning side to null (unless already changed)
            if ($product->getUser() === $this) {
                $product->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Messages[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Messages $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setExpediteur($this);
        }

        return $this;
    }

    public function removeMessage(Messages $message): self
    {
        if ($this->messages->contains($message)) {
            $this->messages->removeElement($message);
            // set the owning side to null (unless already changed)
            if ($message->getExpediteur() === $this) {
                $message->setExpediteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Messages[]
     */
    public function getMessagesRecus(): Collection
    {
        return $this->messagesRecus;
    }

    public function addMessagesRecus(Messages $messagesRecus): self
    {
        if (!$this->messagesRecus->contains($messagesRecus)) {
            $this->messagesRecus[] = $messagesRecus;
            $messagesRecus->setDestinataire($this);
        }

        return $this;
    }

    public function removeMessagesRecus(Messages $messagesRecus): self
    {
        if ($this->messagesRecus->contains($messagesRecus)) {
            $this->messagesRecus->removeElement($messagesRecus);
            // set the owning side to null (unless already changed)
            if ($messagesRecus->getDestinataire() === $this) {
                $messagesRecus->setDestinataire(null);
            }
        }

        return $this;
    }
}
