<?php

namespace App\Entity;

use App\Repository\TrajetRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Personne;
use App\Entity\Ville;

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
    * @ORM\ManyToOne(targetEntity="Personne")
    * @ORM\JoinColumn(name="personne_id", referencedColumnName="id")
    */
    private Personne $personne;

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



}
