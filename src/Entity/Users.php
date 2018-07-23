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
     * @ORM\Column(type="string", length=45)
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
     * @ORM\OneToMany(targetEntity="App\Entity\Messages", mappedBy="user")
     */
    private $messages;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tokenresetpassword", mappedBy="user", orphanRemoval=true)
     */
    private $tokenresetpasswords;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Retro", mappedBy="user")
     */
    private $retros;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Arcade", mappedBy="user")
     */
    private $arcades;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Nextgen", mappedBy="user")
     */
    private $nextgens;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Goodies", mappedBy="user")
     */
    private $goodies;

    /**
     * @ORM\Column(type="integer")
     */
    private $codepostal;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $city;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
        $this->tokenresetpasswords = new ArrayCollection();
        $this->retros = new ArrayCollection();
        $this->arcades = new ArrayCollection();
        $this->nextgens = new ArrayCollection();
        $this->goodies = new ArrayCollection();
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
            $message->setUser($this);
        }

        return $this;
    }

    public function removeMessage(Messages $message): self
    {
        if ($this->messages->contains($message)) {
            $this->messages->removeElement($message);
            // set the owning side to null (unless already changed)
            if ($message->getUser() === $this) {
                $message->setUser(null);
            }
        }

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

    /**
     * @return Collection|Retro[]
     */
    public function getRetros(): Collection
    {
        return $this->retros;
    }

    public function addRetro(Retro $retro): self
    {
        if (!$this->retros->contains($retro)) {
            $this->retros[] = $retro;
            $retro->setUser($this);
        }

        return $this;
    }

    public function removeRetro(Retro $retro): self
    {
        if ($this->retros->contains($retro)) {
            $this->retros->removeElement($retro);
            // set the owning side to null (unless already changed)
            if ($retro->getUser() === $this) {
                $retro->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Arcade[]
     */
    public function getArcades(): Collection
    {
        return $this->arcades;
    }

    public function addArcade(Arcade $arcade): self
    {
        if (!$this->arcades->contains($arcade)) {
            $this->arcades[] = $arcade;
            $arcade->setUser($this);
        }

        return $this;
    }

    public function removeArcade(Arcade $arcade): self
    {
        if ($this->arcades->contains($arcade)) {
            $this->arcades->removeElement($arcade);
            // set the owning side to null (unless already changed)
            if ($arcade->getUser() === $this) {
                $arcade->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Nextgen[]
     */
    public function getNextgens(): Collection
    {
        return $this->nextgens;
    }

    public function addNextgen(Nextgen $nextgen): self
    {
        if (!$this->nextgens->contains($nextgen)) {
            $this->nextgens[] = $nextgen;
            $nextgen->setUser($this);
        }

        return $this;
    }

    public function removeNextgen(Nextgen $nextgen): self
    {
        if ($this->nextgens->contains($nextgen)) {
            $this->nextgens->removeElement($nextgen);
            // set the owning side to null (unless already changed)
            if ($nextgen->getUser() === $this) {
                $nextgen->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Goodies[]
     */
    public function getGoodies(): Collection
    {
        return $this->goodies;
    }

    public function addGoody(Goodies $goody): self
    {
        if (!$this->goodies->contains($goody)) {
            $this->goodies[] = $goody;
            $goody->setUser($this);
        }

        return $this;
    }

    public function removeGoody(Goodies $goody): self
    {
        if ($this->goodies->contains($goody)) {
            $this->goodies->removeElement($goody);
            // set the owning side to null (unless already changed)
            if ($goody->getUser() === $this) {
                $goody->setUser(null);
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
}
