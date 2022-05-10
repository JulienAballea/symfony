<?php

namespace App\Entity;

use App\Repository\VoitureRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Marque;

/**
 * @ORM\Entity(repositoryClass=VoitureRepository::class)
 */
class Voiture
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $modele;

    /**
     * @ORM\Column(type="integer")
     */
    private $nb_place;

    /**
    * @ORM\ManyToOne(targetEntity="Marque")
    * @ORM\JoinColumn(name="marque_id", referencedColumnName="id")
    */
    private  $marque_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModele(): ?string
    {
        return $this->modele;
    }

    public function setModele(string $modele): self
    {
        $this->modele = $modele;

        return $this;
    }

    public function getNbPlace(): ?int
    {
        return $this->nb_place;
    }

    public function setNbPlace(int $nb_place): self
    {
        $this->nb_place = $nb_place;

        return $this;
    }

    public function getMarqueId(): ?Marque
    {
        return $this->marque_id;
    }

    public function setMarqueId(?Marque $marque_id): self
    {
        $this->marque_id = $marque_id;

        return $this;
    }


}
