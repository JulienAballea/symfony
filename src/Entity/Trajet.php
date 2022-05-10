<?php

namespace App\Entity;

use App\Repository\TrajetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TrajetRepository::class)
 */
class Trajet
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbKms;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datetrajet;

    /**
     * @ORM\OneToOne(targetEntity=Ville::class,cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private Ville $ville_dep;

    /**
     * @ORM\OneToOne(targetEntity=Ville::class,cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private Ville $ville_arr;

    /**
     * @ORM\ManyToMany(targetEntity=Personne::class,cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private Personne $personne;

    public function __construct()
    {
        $this->personne = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbKms(): ?int
    {
        return $this->nbKms;
    }

    public function setNbKms(int $nbKms): self
    {
        $this->nbKms = $nbKms;

        return $this;
    }

    public function getDatetrajet(): ?\DateTimeInterface
    {
        return $this->datetrajet;
    }

    public function setDatetrajet(\DateTimeInterface $datetrajet): self
    {
        $this->datetrajet = $datetrajet;

        return $this;
    }

    public function getVilleDep(): ?Ville
    {
        return $this->ville_dep;
    }

    public function setVilleDep(?Ville $ville_dep): self
    {
        $this->ville_dep = $ville_dep;

        return $this;
    }

    public function getVilleArr(): ?Ville
    {
        return $this->ville_arr;
    }

    public function setVilleArr(?Ville $ville_arr): self
    {
        $this->ville_arr = $ville_arr;

        return $this;
    }

    public function getPersonne(): ?Personne
    {
        return $this->personne;
    }

    public function setPersonne(?Personne $personne): self
    {
        $this->personne = $personne;

        return $this;
    }

    public function addPersonne(Personne $personne): self
    {
        if (!$this->personne->contains($personne)) {
            $this->personne[] = $personne;
        }

        return $this;
    }

    public function removePersonne(Personne $personne): self
    {
        $this->personne->removeElement($personne);

        return $this;
    }
}
