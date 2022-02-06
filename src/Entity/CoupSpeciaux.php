<?php

namespace App\Entity;

use App\Repository\CoupSpeciauxRepository;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass=CoupSpeciauxRepository::class)
 */
class CoupSpeciaux implements JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=255)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pourcentages;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $direction;

    /**
     * @ORM\ManyToOne(targetEntity=Personnage::class, inversedBy="coupSpeciaux")
     * @ORM\JoinColumn(nullable=false)
     */
    private $personnage;


    public function __construct($id){
        $this->id = $id;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPourcentages(): ?string
    {
        return $this->pourcentages;
    }

    public function setPourcentages(string $pourcentages): self
    {
        $this->pourcentages = $pourcentages;

        return $this;
    }

    public function getDirection(): ?string
    {
        return $this->direction;
    }

    public function setDirection(string $direction): self
    {
        $this->direction = $direction;

        return $this;
    }

    public function getPersonnage(): ?Personnage
    {
        return $this->personnage;
    }

    public function setPersonnage(?Personnage $personnage): self
    {
        $this->personnage = $personnage;

        return $this;
    }

    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'pourcentage' => $this->pourcentages,
            'direction' => $this->direction,
            'personnage' => [
                'nom' => $this->personnage->getNom()
            ],
        ];
    }
}
