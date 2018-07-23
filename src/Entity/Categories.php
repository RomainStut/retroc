<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoriesRepository")
 */
class Categories
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
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Retro", mappedBy="categorie")
     */
    private $retros;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Arcade", mappedBy="categorie")
     */
    private $arcades;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Nextgen", mappedBy="categorie")
     */
    private $nextgens;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Goodies", mappedBy="categorie")
     */
    private $goodies;

    public function __construct()
    {
        $this->retros = new ArrayCollection();
        $this->arcades = new ArrayCollection();
        $this->nextgens = new ArrayCollection();
        $this->goodies = new ArrayCollection();
    }

    public function getId()
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
            $retro->setCategorie($this);
        }

        return $this;
    }

    public function removeRetro(Retro $retro): self
    {
        if ($this->retros->contains($retro)) {
            $this->retros->removeElement($retro);
            // set the owning side to null (unless already changed)
            if ($retro->getCategorie() === $this) {
                $retro->setCategorie(null);
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
            $arcade->setCategorie($this);
        }

        return $this;
    }

    public function removeArcade(Arcade $arcade): self
    {
        if ($this->arcades->contains($arcade)) {
            $this->arcades->removeElement($arcade);
            // set the owning side to null (unless already changed)
            if ($arcade->getCategorie() === $this) {
                $arcade->setCategorie(null);
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
            $nextgen->setCategorie($this);
        }

        return $this;
    }

    public function removeNextgen(Nextgen $nextgen): self
    {
        if ($this->nextgens->contains($nextgen)) {
            $this->nextgens->removeElement($nextgen);
            // set the owning side to null (unless already changed)
            if ($nextgen->getCategorie() === $this) {
                $nextgen->setCategorie(null);
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
            $goody->setCategorie($this);
        }

        return $this;
    }

    public function removeGoody(Goodies $goody): self
    {
        if ($this->goodies->contains($goody)) {
            $this->goodies->removeElement($goody);
            // set the owning side to null (unless already changed)
            if ($goody->getCategorie() === $this) {
                $goody->setCategorie(null);
            }
        }

        return $this;
    }
}
